<style>
    .label-danger {
        color: red;
    }
</style>
<div class="modal fade" id="deductions_entitlement_modal" tabindex="-1" aria-labelledby="deductions_entitlement_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-danger" id="deductions_entitlement_modalLabel">
                    <i class="bx bx-minus-circle"></i> Assign Deductions > Assign Deductions By Employee
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="assign_deductions_form" onsubmit="event.preventDefault();">
                    <div class="row g-3">
                        <!-- Employee Name -->
                        <div class="col-md-12">
                            <label for="employee_deductions_entitlement" class="form-label fw-semibold">
                                Assign Deduction(s) for Employee: <span class="text-danger">*</span>
                            </label>
                            <h3 class="display-6 text-center text-danger" id="employee_deductions_entitlement"></h3>
                        </div>
                    </div>

                    <!-- Deductions Table -->
                    <div class="mt-3">
                        <h5 class="fw-semibold">Assign Deductions</h5>
                        <table class="table table-hover shadow-sm">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Select</th>
                                    <th scope="col">Deduction</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Frequency</th>
                                </tr>
                            </thead>
                            <tbody id="deductions_body">
                                <!-- Dynamically generated rows will be inserted here -->
                            </tbody>
                        </table>
                    </div>
            </div>

            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary" 
                data-bs-target="#assign_deductions_modal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal" 
                >
                <i class="bx bx-arrow-back bx-sm"></i>Back
                </button>
                <button type="submit" class="btn btn-outline-danger" onclick="assignDeductionsClick();">
                    <i class="bx bx-plus bx-sm"></i>Save Assigned Deductions
                </button>
            </div>
            </form>
        </div>
    </div>
</div>