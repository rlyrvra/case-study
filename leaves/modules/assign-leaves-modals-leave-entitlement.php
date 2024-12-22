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
                    <label for="employment-type" class="form-label">Employment Type*</label>
                    <select class="form-select" id="employment-type" required>
                        <option value="" selected disabled>Select Type</option>
                        <option value="Regular">Regular</option>
                        <option value="Regular Permanent">Regular Permanent</option>
                        <option value="Casual">Casual</option>
                        <option value="Contractual">Contractual</option>
                        <option value="Project-Based">Project-Based</option>
                        <option value="Seasonal">Seasonal</option>
                        <option value="Fixed-Term">Fixed-Term</option>
                        <option value="Probationary">Probationary</option>
                        <option value="Part-Time">Part-Time</option>
                        <option value="Regular Part-Time">Regular Part-Time</option>
                        <option value="Part-Time Permanent">Part-Time Permanent</option>
                        <option value="Self-Employment">Self-Employment</option>
                        <option value="Freelance">Freelance</option>
                        <option value="Internship">Internship</option>
                        <option value="Consultancy">Consultancy</option>
                        <option value="Apprenticeship">Apprenticeship</option>
                        <option value="Traineeship">Traineeship</option>
                        <option value="Gig">Gig</option>
                    </select>
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
                data-bs-toggle="modal"
                data-bs-dismiss="modal" 
                >
                <i class="bx bx-plus bx-sm"></i>Save Assigned Leaves
                </button>
            </div>
        </div>
    </div>
</div>
