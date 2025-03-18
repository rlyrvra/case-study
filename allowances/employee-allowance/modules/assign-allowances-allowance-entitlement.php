<style>
    .label-danger {
        color: red;
    }
</style>
<div class="modal fade" id="allowance_entitlement_modal" tabindex="-1" aria-labelledby="assign_allowances_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-info" id="assign_allowances_modalTitle">
                    <i class="bx bx-wallet"></i> Assign Allowances > Assign Allowances By Employee
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="assign_allowances_form" onsubmit="event.preventDefault(); assignAllowancesClick();">
                    <div class="row g-3">
                        <!-- Employee Name -->
                        <div class="col-md-12">
                            <label for="employee_allowance_entitlement" class="form-label fw-semibold">
                                Assign Allowance for Employee: <span class="text-danger">*</span>
                            </label>
                            <h3 class="display-6 text-center text-info" id="employee_allowance_entitlement"></h3>
                        </div>
                    </div>

                    <!-- Allowances Table -->
                    <div class="mt-3">
                        <h5 class="fw-semibold">Assign Allowances</h5>
                        <table class="table table-hover shadow-sm">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Select</th>
                                    <th scope="col">Allowance Type</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Frequency</th>
                                </tr>
                            </thead>
                            <tbody id="allowances_body">
                                <!-- Dynamically generated rows will be inserted here -->
                            </tbody>
                        </table>
                    </div>
            </div>

            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary" 
                data-bs-target="#assign_allowances_modal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal" 
                >
                <i class="bx bx-arrow-back bx-sm"></i>Back
                </button>
                <button type="submit" class="btn btn-outline-info">
                <i class="bx bx-plus bx-sm"></i>Save Assigned Allowances
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
