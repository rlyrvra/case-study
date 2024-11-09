<!-- Bootstrap Modal Structure -->
<div class="modal fade" id="leaveEntitlementModal" tabindex="-1" aria-labelledby="leaveEntitlementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaveEntitlementModalLabel">Leave Type Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="leaveTypeInputTest()" data-bs-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
