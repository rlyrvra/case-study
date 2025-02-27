<!-- Modal -->
<div class="modal fade" id="update-payrollGroups-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="update-payrollGroups-modalTitle">Payroll Groups Form</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">

            <form onsubmit='event.preventDefault()' id="update_payrollGroups_form">
                <!-- Name -->
                <div class="form-group mb-3">
                    <label for="update_name">Name*:</label>
                    <input type="text" class="form-control" id="update_name" name="create_name" maxlength="50" placeholder="Ex. Sample Payroll Group" required>
                </div>
                <!-- Freq -->
                <div class="form-group mb-3">
                    <label for="update_pay_frequency">Pay Frequency*:</label>
                    <select class="form-control" id="update_pay_frequency" name="update_pay_frequency" required onchange="showFrequencyOptions(this, document.getElementById('update_payrollGroups_form'));">
                        <option value="" disabled selected>Select pay frequency...</option>
                        <option value="Weekly" data-target="update_weekly-container">Weekly</option>
                        <option value="Bi-weekly" data-target="update_bi-weekly-container">Bi-weekly</option>
                        <option value="Semi-monthly" data-target="update_semi-monthly-container">Semi-monthly</option>
                    </select>
                </div>

                <!-- Weekly -->
                <div class="card card-body mb-3 visually-hidden frequency-container" id="update_weekly-container">
                    <label for="update_weekly_payday">Weekly Pay Day*:</label>
                    <select class="form-control" id="update_weekly_payday" name="update_weekly_payday">
                        <option value="" disabled selected>Select day...</option>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                    </select>
                </div>

                <!-- Bi-weekly -->
                <div class="card card-body mb-3 visually-hidden frequency-container" id="update_bi-weekly-container">
                    <label for="update_bi_weekly_payday">Bi-weekly Pay Day*:</label>
                    <div class="input-group" name="update_bi_weekly_payday">
                        <span class="display-6 input-group-text">Every other:</span>
                        <select class="form-control" id="update_bi_weekly_payday">
                            <option value="" disabled selected>Select day...</option>
                            <option value="1">Monday</option>
                            <option value="2">Tuesday</option>
                            <option value="3">Wednesday</option>
                            <option value="4">Thursday</option>
                            <option value="5">Friday</option>
                            <option value="6">Saturday</option>
                        </select>
                    </div>
                </div>


                <!-- Semi-monthly -->
                <div class="card card-body mb-3 visually-hidden frequency-container" id="update_semi-monthly-container">
                    <label for="update_semi_monthly_first_cutoff">Semi-Monthly First Pay Date:</label>
                    <div class="input-group mb-3" name="update_semi_monthly_first_cutoff">
                        <span class="display-6 input-group-text">1st Pay Date:</span>
                        <select class="form-control" id="update_semi_monthly_first_cutoff" onchange="calculateSecondPayUpdate(document.getElementById('update_payrollGroups_form'));">
                            <option value="" disabled selected>Select date...</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                        </select>
                    </div>
                    <label for="update_semi_monthly_second_cutoff">Semi-Monthly Second Pay Date:</label>
                    <div class="input-group mb-3" name="update_semi_monthly_second_cutoff">
                        <span class="display-6 input-group-text">2nd Pay Date:</span>
                        <input type="number" class="form-control" id="update_semi_monthly_second_cutoff" readonly>
                    </div>
                </div>

                <!-- Payday Offset -->
                <div class="form-group mb-3">
                    <label for="update_payday_offset">Payday Offset*:</label>
                    <select class="form-control" id="update_payday_offset" name="update_payday_offset" required>
                        <option value="" disabled selected>Select number of days...</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>

                <!-- Pament Adjustment -->
                <div class="form-group mb-3">
                    <label for="update_payment_adjustment">Payday Adjustment*:</label>
                    <select class="form-control" id="update_payment_adjustment" name="update_payment_adjustment" required>
                        <option value="">Select adjustment...</option>
                        <option value="On the Saturday before">On the Saturday before</option>
                        <option value="Payday remains on the same day">Payday remains on the same day</option>
                        <option value="On the Monday after">On the Monday after</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="form-group mb-3">
                    <label for="update_status">Status*:</label>
                    <select class="form-control" id="update_status" name="update_status" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back bx-xs"></i>Close
                </button>
                <button type="submit" class="btn btn-info" onclick="updatePayrollGroup(this);" id="update_payrollGroup_button"><i class="bx bx-edit-alt bx-xs"></i>Update</button>
            </div>
            
            </form>
                    
                
            
        </div>
    </div>
</div>