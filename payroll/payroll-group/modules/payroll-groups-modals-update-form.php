<style>
    .label-danger {
        color: red;
    }
</style>

<!-- Payroll Groups Update Form Modal -->
<div class="modal fade" id="update-payrollGroups-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-primary" id="update-payrollGroups-modalTitle">
                    <i class="bx bx-credit-card"></i> Update Payroll Group
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="update_payrollGroups_form" onsubmit="event.preventDefault();">
                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label for="update_name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control shadow-sm" id="update_name" name="update_name" maxlength="50" 
                                required minlength="3" maxlength="50" pattern="^[A-Za-z0-9 ]{3,50}$"
                                title="Only letters, numbers, and spaces allowed (3-50 characters)"
                                oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')" placeholder="Payroll A" required>
                        </div>

                        <!-- Pay Frequency -->
                        <div class="col-md-6">
                            <label for="update_pay_frequency" class="form-label fw-semibold">Pay Frequency <span class="text-danger">*</span></label>
                            <select class="form-select shadow-sm" id="update_pay_frequency" name="update_pay_frequency" required onchange="showFrequencyOptions(this, document.getElementById('update_payrollGroups_form'))">
                                <option value="" disabled selected>Select pay frequency...</option>
                                <option value="Weekly" data-target="update_weekly-container">Weekly</option>
                                <option value="Bi-weekly" data-target="update_bi-weekly-container">Bi-weekly</option>
                                <option value="Semi-monthly" data-target="update_semi-monthly-container">Semi-monthly</option>
                            </select>
                        </div>
                    </div>

                    <!-- Frequency-Based Inputs -->
                    <div class="mt-3">
                        <div class="card card-body mb-3 visually-hidden frequency-container" id="update_weekly-container">
                            <label for="update_weekly_payday">Weekly Pay Day <span class="text-danger">*</span></label>
                            <div class="input-group" name="update_weekly_payday">
                                <span class="display-6 input-group-text">Every:</span>
                                <select class="form-select shadow-sm" id="update_weekly_payday">
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
                        
                        <div class="card card-body mb-3 visually-hidden frequency-container" id="update_bi-weekly-container">
                            <label for="update_bi_weekly_payday">Bi-weekly Pay Day <span class="text-danger">*</span></label>
                            <div class="input-group" name="update_bi_weekly_payday">
                                <span class="display-6 input-group-text">Every other:</span>
                                <select class="form-select shadow-sm" id="update_bi_weekly_payday">
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

                        <div class="card card-body mb-3 visually-hidden frequency-container" id="update_semi-monthly-container">
                            <label for="update_semi_monthly_first_cutoff">Semi-Monthly First Pay Date <span class="text-danger">*</span></label>
                            <div class="input-group mb-3" name="update_semi_monthly_first_cutoff">
                                <span class="display-6 input-group-text">1st Pay Date:</span>
                                <select class="form-select shadow-sm" id="update_semi_monthly_first_cutoff" onchange="calculateSecondPayUpdate(document.getElementById('update_payrollGroups_form'))">
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
                            <label for="update_semi_monthly_second_cutoff" class="mt-2">Semi-Monthly Second Pay Date <span class="text-danger">*</span></label>
                            <div class="input-group mb-3" name="update_semi_monthly_second_cutoff">
                                <span class="display-6 input-group-text">2nd Pay Date:</span>
                                <input type="number" class="form-control shadow-sm" id="update_semi_monthly_second_cutoff" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Payday Offset -->
                    <div class="mt-3">
                        <label for="update_payday_offset" class="form-label fw-semibold">Payday Offset <span class="text-danger">*</span></label>
                        <select class="form-select shadow-sm" id="update_payday_offset" name="update_payday_offset" required>
                            <option value="" disabled selected>Select number of days...</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <!-- Payment Adjustment -->
                    <div class="mt-3">
                        <label for="update_payment_adjustment" class="form-label fw-semibold">Payday Adjustment <span class="text-danger">*</span></label>
                        <select class="form-select shadow-sm" id="update_payment_adjustment" name="update_payment_adjustment" required>
                            <option value="">Select adjustment...</option>
                            <option value="On the Saturday before">On the Saturday before</option>
                            <option value="Payday remains on the same day">Payday remains on the same day</option>
                            <option value="On the Monday after">On the Monday after</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mt-3">
                        <label for="update_status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select class="form-select shadow-sm" id="update_status" name="update_status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
            </div>

            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back"></i> Close
                </button>
                <button type="submit" id="update_payrollGroup_button" class="btn btn-primary" onclick="updatePayrollGroup(this);">
                    <i class="bx bx-edit"></i> Update
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
