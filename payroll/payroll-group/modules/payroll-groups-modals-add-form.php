<!-- Modal -->
<div class="modal fade" id="add-payrollGroups-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="add-payrollGroups-modalTitle">Payroll Groups Form</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">
            <hr/>

            <form onsubmit='event.preventDefault()' id="add_payrollGroups_form">
                <!-- Name -->
                <div class="form-group mb-3">
                    <label for="create_name">Name*:</label>
                    <input type="text" class="form-control" id="create_name" name="create_name" maxlength="50" placeholder="Ex. Sample Payroll Group" required>
                </div>
                <!-- Freq -->
                <div class="form-group mb-3">
                    <label for="add_pay_frequency">Pay Frequency*:</label>
                    <select class="form-control" id="add_pay_frequency" name="add_pay_frequency" required onchange="showFrequencyOptions(this, document.getElementById('add_payrollGroups_form'));">
                        <option value="" disabled selected>Select pay frequency...</option>
                        <option value="Weekly" data-target="weekly-container">Weekly</option>
                        <option value="Bi-weekly" data-target="bi-weekly-container">Bi-weekly</option>
                        <option value="Semi-monthly" data-target="semi-monthly-container">Semi-monthly</option>
                    </select>
                </div>

                <!-- Weekly -->
                <div class="card card-body mb-3 visually-hidden frequency-container" id="weekly-container">
                    <label for="weekly_payday">Weekly Pay Day*:</label>
                    <select class="form-control" id="weekly_payday" name="weekly_payday">
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
                <div class="card card-body mb-3 visually-hidden frequency-container" id="bi-weekly-container">
                    <label for="bi_weekly_payday">Bi-weekly Pay Day*:</label>
                    <div class="input-group" name="bi_weekly_payday">
                        <span class="display-6 input-group-text">Every other:</span>
                        <select class="form-control" id="bi_weekly_payday">
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
                <div class="card card-body mb-3 visually-hidden frequency-container" id="semi-monthly-container">
                    <label for="semi_monthly_first_cutoff">Semi-Monthly First Pay Date:</label>
                    <div class="input-group mb-3" name="semi_monthly_first_cutoff">
                        <span class="display-6 input-group-text">1st Pay Date:</span>
                        <select class="form-control" id="semi_monthly_first_cutoff" onchange="calculateSecondPay(document.getElementById('add_payrollGroups_form'));">
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
                    <label for="semi_monthly_second_cutoff">Semi-Monthly Second Pay Date:</label>
                    <div class="input-group mb-3" name="semi_monthly_second_cutoff">
                        <span class="display-6 input-group-text">2nd Pay Date:</span>
                        <input type="number" class="form-control" id="semi_monthly_second_cutoff" readonly>
                    </div>
                </div>

                <!-- Payday Offset -->
                <div class="form-group mb-3">
                    <label for="payday_offset">Payday Offset*:</label>
                    <select class="form-control" id="payday_offset" name="payday_offset" required>
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
                    <label for="payment_adjustment">Payday Adjustment*:</label>
                    <select class="form-control" id="payment_adjustment" name="payment_adjustment" required>
                        <option value="">Select adjustment...</option>
                        <option value="On the Saturday before">On the Saturday before</option>
                        <option value="Payday remains on the same day">Payday remains on the same day</option>
                        <option value="On the Monday after">On the Monday after</option>
                    </select>
                </div>

                <!-- Status -->
                <div class="form-group mb-3">
                    <label for="create_status">Status*:</label>
                    <select class="form-control" id="create_status" name="create_status" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

            

            <hr/>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back bx-xs"></i>Close
                </button>
                <button type="submit" class="btn btn-success" onclick="createPayrollGroup();"><i class="bx bx-plus bx-xs"></i>Create</button>
            </div>
            
            </form>
                    
                
            
        </div>
    </div>
</div>