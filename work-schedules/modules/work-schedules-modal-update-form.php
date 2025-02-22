<!-- Modal -->
<div class="modal fade" id="update_work_schedules" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="update_work_schedulesTitle">Work Schedule Form</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">
                <div class="container mt-4">
                    <form onsubmit="event.preventDefault()" id="work_schedules_update_form">
                        <div class="mb-3">
                            <label for="update_startTime" class="form-label">Start Time</label>
                            <select class="form-select" id="update_startTime" name="update_startTime" required onchange="updateCalculateWorkHrs()">
                                <option value="" selected disabled>Select start time...</option>
                                <option value="12:00AM">12:00AM</option>
                                <option value="1:00AM">1:00AM</option>
                                <option value="2:00AM">2:00AM</option>
                                <option value="3:00AM">3:00AM</option>
                                <option value="4:00AM">4:00AM</option>
                                <option value="5:00AM">5:00AM</option>
                                <option value="6:00AM">6:00AM</option>
                                <option value="7:00AM">7:00AM</option>
                                <option value="8:00AM">8:00AM</option>
                                <option value="9:00AM">9:00AM</option>
                                <option value="10:00AM">10:00AM</option>
                                <option value="11:00AM">11:00AM</option>
                                <option value="12:00PM">12:00PM</option>
                                <option value="1:00PM">1:00PM</option>
                                <option value="2:00PM">2:00PM</option>
                                <option value="3:00PM">3:00PM</option>
                                <option value="4:00PM">4:00PM</option>
                                <option value="5:00PM">5:00PM</option>
                                <option value="6:00PM">6:00PM</option>
                                <option value="7:00PM">7:00PM</option>
                                <option value="8:00PM">8:00PM</option>
                                <option value="9:00PM">9:00PM</option>
                                <option value="10:00PM">10:00PM</option>
                                <option value="11:00PM">11:00PM</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="update_endTime" class="form-label">End Time</label>
                            <select class="form-select" id="update_endTime" name="update_endTime" required onchange="updateCalculateWorkHrs()">
                                <option value="" selected disabled>Select end time...</option>
                                <option value="12:00AM">12:00AM</option>
                                <option value="1:00AM">1:00AM</option>
                                <option value="2:00AM">2:00AM</option>
                                <option value="3:00AM">3:00AM</option>
                                <option value="4:00AM">4:00AM</option>
                                <option value="5:00AM">5:00AM</option>
                                <option value="6:00AM">6:00AM</option>
                                <option value="7:00AM">7:00AM</option>
                                <option value="8:00AM">8:00AM</option>
                                <option value="9:00AM">9:00AM</option>
                                <option value="10:00AM">10:00AM</option>
                                <option value="11:00AM">11:00AM</option>
                                <option value="12:00PM">12:00PM</option>
                                <option value="1:00PM">1:00PM</option>
                                <option value="2:00PM">2:00PM</option>
                                <option value="3:00PM">3:00PM</option>
                                <option value="4:00PM">4:00PM</option>
                                <option value="5:00PM">5:00PM</option>
                                <option value="6:00PM">6:00PM</option>
                                <option value="7:00PM">7:00PM</option>
                                <option value="8:00PM">8:00PM</option>
                                <option value="9:00PM">9:00PM</option>
                                <option value="10:00PM">10:00PM</option>
                                <option value="11:00PM">11:00PM</option>
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="update_isFlextime" data-bs-toggle="collapse" data-bs-target="#update_flextimeOptions" name="update_isFlextime">
                            <label class="form-check-label" for="update_isFlextime">Is Flextime</label>
                        </div>
                        <div class="collapse" id="update_flextimeOptions">
                            <div class="card card-body">
                                <div class="mb-3">
                                    <label for="update_totalHoursPerWeek" class="form-label">Total Hours Per Day</label>
                                    <input type="number" class="form-control" id="update_totalHoursPerWeek" name="update_totalHoursPerWeek" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label for="update_totalWorkHours" class="form-label">Total Work Hours</label>
                            <input type="number" class="form-control" id="update_totalWorkHours" name="update_totalWorkHours" min="0" readonly required>
                        </div>
                        <!-- Layout for Break Addition (work schedules) -->
                        <div id="update_break_assignment">
                            <h6 class="text-center">Assign Breaks to this Schedule (0-5 breaks)</h6>
                            <table class="table table-hover mt-3">
                            <thead>
                                <tr>
                                    <th style="width: 30% !important;">Name</th>
                                    <th style="width: 5% !important;">Paid</th>
                                    <th style="width: 30% !important;">Start Time</th>
                                    <th style="width: 30% !important;">End Time</th>
                                    <th style="width: 5% !important;">Action</th>
                                </tr>
                                </thead>
                            <tbody id="update_break_assignment_table_body">
                            </tbody>
                            </table>
                            <div class="mt-3 d-flex justify-content-between">
                                <button class="btn btn-outline-secondary" onclick="updateWorkSchedulesBreakCreate()">Add break ▼</button>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Check Validity</button>
                        </div>
                    </form>  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back bx-xs"></i>Close
                </button>
                <button type="submit" class="btn btn-info" onclick="updateWorkScheduleBreak(this);" id="update_work_schedule_button"><i class="bx bx-edit-alt bx-xs"></i>Update</button>
            </div>   
            
        </div>
    </div>
</div>