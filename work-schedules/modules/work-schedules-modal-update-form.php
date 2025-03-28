<!-- Work Schedule Update Form Modal -->
<div class="modal fade" id="update_work_schedules" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-info" id="update_work_schedulesTitle">
                    <i class="bx bx-calendar-edit"></i> Work Schedule Form
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form onsubmit="event.preventDefault()" id="work_schedules_update_form">
                    <!-- <div class="my-3 alert alert-danger text-center">
                        New schedule may overlap with existing attendance records if the original schedule is deleted and will be applied on the next scheduled day.
                    </div> -->
                    <div class="row g-3">

                        <!-- Start Time -->
                        <div class="col-md-6">
                            <label for="update_startTime" class="form-label fw-semibold">Start Time <span class="text-danger">*</span></label>
                            <select class="form-select shadow-sm" id="update_startTime" name="update_startTime" required onchange="updateResetBreakHours()">
                                <option value="" selected disabled>Select start time...</option>
                                ${generateTimeOptions()}
                            </select>
                        </div>

                        <!-- End Time -->
                        <div class="col-md-6">
                            <label for="update_endTime" class="form-label fw-semibold">End Time <span class="text-danger">*</span></label>
                            <select class="form-select shadow-sm" id="update_endTime" name="update_endTime" required onchange="updateResetBreakHours();">
                                <option value="" selected disabled>Select end time...</option>
                                ${generateTimeOptions()}
                            </select>
                        </div>

                        <!-- Flextime Checkbox -->
                        <div class="col-md-12 form-check">
                            <input class="form-check-input shadow-sm" type="checkbox" id="update_isFlextime" data-bs-toggle="collapse" data-bs-target="#update_flextimeOptions" onchange="updateFlextimeEnabled();">
                            <label class="form-check-label fw-semibold" for="update_isFlextime">Enable Flextime</label>
                        </div>

                        <!-- Flextime Options -->
                        <div class="collapse col-md-12" id="update_flextimeOptions">
                            <div class="card card-body shadow-sm">
                                <label for="update_totalHoursPerWeek" class="form-label fw-semibold">Total Hours Per Day</label>
                                <input type="number" class="form-control shadow-sm" id="update_totalHoursPerWeek" name="update_totalHoursPerWeek" min="0">
                            </div>
                        </div>

                        <!-- Total Work Hours -->
                        <div class="col-md-12">
                            <label for="update_totalWorkHours" class="form-label fw-semibold">Total Work Hours <span class="text-danger">*</span></label>
                            <input type="number" class="form-control shadow-sm" id="update_totalWorkHours" name="update_totalWorkHours" min="0" readonly required>
                        </div>
                    </div>

                    <!-- Assign Breaks Section -->
                    <div id="update_break_assignment" class="table-responsive mt-4">
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
                            <tbody id="update_break_assignment_table_body"></tbody>
                        </table>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary shadow-sm" onclick="updateWorkSchedulesBreakCreate()">
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
                <button type="submit" class="btn btn-info shadow-sm" onclick="updateWorkScheduleBreak(this);" id="update_work_schedule_button">
                    <i class="bx bx-edit-alt"></i> Update
                </button>
            </div>
            </form> 
        </div>
    </div>
</div>
<script>
// Populate start and end time dropdowns
document.getElementById('update_startTime').innerHTML += generateTimeOptions();
document.getElementById('update_endTime').innerHTML += generateTimeOptions();
</script>