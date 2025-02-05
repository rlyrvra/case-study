<!-- Bootstrap Modal Structure -->
<div class="modal fade" id="deductions_entitlement_modal" tabindex="-1" aria-labelledby="leaveEntitlementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title display-5" id="deductions_entitlement_modalModalLabel">Assign Allowance Form</h4>
                <button type="button" class="btn-close" 
                data-bs-target="#assign_deductions_modal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal" 
                aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <hr/>
                    <h3>Assign Deductions</h3>
                    <label for="employee_deductions_entitlement" class="form-label">Assign Deduction(s) for Employee:*</label>
                    <h3 class="display-3 text-center" id="employee_deductions_entitlement"></h3>
                    <hr/>
                    <!-- Table to display leave types dynamically -->
                    <table class="table table-hover">
                    <thead>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" 
                data-bs-target="#assign_deductions_modal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal" 
                >
                <i class="bx bx-arrow-back bx-sm"></i>Back
                </button>
                <button type="button" class="btn btn-primary" onclick="assignDeductionsClick()" 
                >
                <i class="bx bx-plus bx-sm"></i>Save Assigned Deductions
                </button>
            </div>
        </div>
    </div>
</div>
