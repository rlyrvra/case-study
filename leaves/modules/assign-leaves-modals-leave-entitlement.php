<!-- Bootstrap Modal Structure -->
<div class="modal fade" id="leaveEntitlementModal" tabindex="-1" aria-labelledby="leaveEntitlementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title display-5" id="leaveEntitlementModalLabel">Leave Type Form</h4>
                <button type="button" class="btn-close" 
                data-bs-target="#assign_leave_types_modal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal" 
                aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <h3>Assign Leaves</h3>
                    <!-- Table to display leave types dynamically -->
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Select</th>
                        <th scope="col">Leave Type</th>
                        <th scope="col">Credits</th>
                        </tr>
                    </thead>
                    <tbody id="leaveTableBody">
                        <!-- Dynamically generated rows will be inserted here -->
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" 
                data-bs-target="#assign_leave_types_modal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal" 
                >
                <i class="bx bx-arrow-back bx-sm"></i>Back
                </button>
                <button type="button" class="btn btn-primary" onclick="leaveTypeInputTest()" 
                data-bs-target="#assign_leave_types_modal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal" 
                >
                <i class="bx bx-plus bx-sm"></i>Save Assigned Leaves
                </button>
            </div>
        </div>
    </div>
</div>
