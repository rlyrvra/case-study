<!-- Bootstrap Modal Structure -->
<div class="modal fade" id="allowance_entitlement_modal" tabindex="-1" aria-labelledby="leaveEntitlementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title display-5" id="allowance_entitlement_modalModalLabel">Assign Allowance Form</h4>
                <button type="button" class="btn-close" 
                data-bs-target="#assign_allowances_modal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal" 
                aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <hr/>
                    <h3>Assign Allowances</h3>
                    <label for="employee_allowance_entitlement" class="form-label">Assign Allowance for Employee:*</label>
                    <h3 class="display-3 text-center" id="employee_allowance_entitlement"></h3>
                    <hr/>
                    <!-- Table to display leave types dynamically -->
                    <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Select</th>
                        <th scope="col">Allowances</th>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" 
                data-bs-target="#assign_allowances_modal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal" 
                >
                <i class="bx bx-arrow-back bx-sm"></i>Back
                </button>
                <button type="button" class="btn btn-primary" onclick="assignAllowancesClick()" 
                >
                <i class="bx bx-plus bx-sm"></i>Save Assigned Allowances
                </button>
            </div>
        </div>
    </div>
</div>
