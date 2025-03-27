<style>
    .label-danger {
        color: red;
    }
</style>
<div class="modal fade" id="leaveEntitlementModal" tabindex="-1" aria-labelledby="assign_leave_types_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-info" id="assign_leave_types_modalTitle">
                    <i class="bx bx-calendar"></i> Assign Leave Types > Assign Leaves By Employment Type
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="assign_leave_types_form" onsubmit="event.preventDefault();">
                    <div class="row g-3">
                        <!-- Employment Type -->
                        <div class="col-md-12">
                            <label for="employment-type" class="form-label fw-semibold">
                                Employment Type <span class="text-danger">*</span>
                            </label>
                            <select class="form-select shadow-sm" id="employment-type" name="employment-type" required onchange="checkEmploymentTypeLeaves()">
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
                        </div>
                    </div>

                    <!-- Leave Type Table -->
                    <div class="mt-3">
                        <h5 class="fw-semibold">Assign Leaves</h5>
                        <table class="table table-hover shadow-sm">
                            <thead class="table-light">
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

            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-secondary" 
                data-bs-target="#assign_leave_types_modal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal" 
                >
                <i class="bx bx-arrow-back bx-sm"></i>Back
                </button>
                <button type="submit" class="btn btn-outline-info" onclick="assignLeavesViaType()"
                >
                <i class="bx bx-plus bx-sm"></i>Save Assigned Leaves
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
