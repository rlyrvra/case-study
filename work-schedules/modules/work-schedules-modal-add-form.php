<!-- Work Schedule Add Form Modal -->
<div class="modal fade" id="add_work_schedules" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-success" id="add_work_schedulesTitle">
                    <i class="bx bx-calendar"></i> Work Schedule Form
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form onsubmit="event.preventDefault()" id="work_schedules_add_form">
                    <div class="row g-3">
                        <!-- Select Employee -->
                        <div class="col-md-12">
                            <label for="select_employee" class="form-label fw-semibold">Select Employee <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bx bx-user fs-5"></i></span>
                                <select class="form-select selectize_employees shadow-sm" id="select_employee" required></select>
                            </div>
                        </div>

                        <!-- Start Time -->
                        <div class="col-md-6">
                            <label for="startTime" class="form-label fw-semibold">Start Time <span class="text-danger">*</span></label>
                            <select class="form-select shadow-sm" id="startTime" name="startTime" required>
                                <option value="" selected disabled>Select start time...</option>
                                <!-- Dynamic time options -->
                                ${generateTimeOptions()}
                            </select>
                        </div>

                        <!-- End Time -->
                        <div class="col-md-6">
                            <label for="endTime" class="form-label fw-semibold">End Time <span class="text-danger">*</span></label>
                            <select class="form-select shadow-sm" id="endTime" name="endTime" required onchange="calculateWorkHours();">
                                <option value="" selected disabled>Select end time...</option>
                                <!-- Dynamic time options -->
                                ${generateTimeOptions()}
                            </select>
                        </div>

                        <!-- Flextime Checkbox -->
                        <div class="col-md-12 form-check">
                            <input class="form-check-input shadow-sm" type="checkbox" id="isFlextime" data-bs-toggle="collapse" data-bs-target="#flextimeOptions" onchange="createFlextimeEnabled();">
                            <label class="form-check-label fw-semibold" for="isFlextime">Enable Flextime</label>
                        </div>

                        <!-- Flextime Options -->
                        <div class="collapse col-md-12" id="flextimeOptions">
                            <div class="card card-body shadow-sm">
                                <label for="totalHoursPerWeek" class="form-label fw-semibold">Total Hours Per Day</label>
                                <input type="number" class="form-control shadow-sm" id="totalHoursPerWeek" name="totalHoursPerWeek" min="0">
                            </div>
                        </div>

                        <!-- Total Work Hours -->
                        <div class="col-md-12">
                            <label for="totalWorkHours" class="form-label fw-semibold">Total Work Hours <span class="text-danger">*</span></label>
                            <input type="number" class="form-control shadow-sm" id="totalWorkHours" name="totalWorkHours" min="0" readonly required>
                        </div>
                    </div>

                    <!-- Assign Breaks Section -->
                    <div id="create_break_assignment" class="table-responsive mt-4">
                        <h6 class="text-center fw-semibold">Assign Breaks to this Schedule (0-5 breaks)</h6>
                        <table class="table table-hover mt-3">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Paid</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="create_break_assignment_table_body"></tbody>
                        </table>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary shadow-sm" onclick="addWorkSchedulesBreakCreate()">
                                <i class="bx bx-plus"></i> Add Break
                            </button>
                        </div>
                    </div>

                    <!-- Validation Button -->
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary shadow-sm">Check Validity</button>
                    </div>
                 
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back"></i> Close
                </button>
                <button type="submit" class="btn btn-success shadow-sm" onclick="createWorkSchedule();">
                    <i class="bx bx-plus"></i> Create
                </button>
            </div>
            </form> 
        </div>
    </div>
</div>

<script>
    // Function to generate time options dynamically
    function generateTimeOptions() {
        const times = [];
        for (let i = 0; i < 24; i++) {
            let suffix = i < 12 ? 'AM' : 'PM';
            let hour = i % 12 || 12;
            times.push(`<option value="${hour}:00${suffix}">${hour}:00${suffix}</option>`);
        }
        return times.join('');
    }

    // Populate start and end time dropdowns
    document.getElementById('startTime').innerHTML += generateTimeOptions();
    document.getElementById('endTime').innerHTML += generateTimeOptions();
</script>
<!-- /Work Schedule Add Form Modal -->