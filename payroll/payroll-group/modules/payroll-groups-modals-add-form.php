<!-- Payroll Groups Add Form Modal -->
<style>
    .label-danger {
        color: red;
    }
</style>
<div class="modal fade" id="add_payrollGroups_modal" tabindex="-1" aria-labelledby="add_payrollGroups_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-success" id="add_payrollGroups_modalTitle">
                    <i class="bx bx-wallet"></i> Create Payroll Group
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="add_payrollGroups_form" onsubmit="event.preventDefault();">
                    <div class="row g-3">
                        <!-- Payroll Group Name -->
                        <div class="col-md-6">
                            <label for="create_name" class="form-label fw-semibold">
                                Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control shadow-sm" id="create_name" name="create_name"
                                required minlength="3" maxlength="50" pattern="^[A-Za-z0-9 ]{3,50}$"
                                title="Only letters, numbers, and spaces allowed (3-50 characters)"
                                oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')" placeholder="Payroll A" required>
                        </div>

                        <!-- Pay Frequency -->
                        <div class="col-md-6">
                            <label for="add_pay_frequency" class="form-label fw-semibold">
                                Pay Frequency <span class="text-danger">*</span>
                            </label>
                            <select class="form-select shadow-sm" id="add_pay_frequency" name="add_pay_frequency" required
                                onchange="showFrequencyOptions(this, document.getElementById('add_payrollGroups_form'))">
                                <option value="" disabled selected>Select pay frequency...</option>
                                <option value="Weekly" data-target="weekly-container">Weekly</option>
                                <option value="Bi-weekly" data-target="bi-weekly-container">Bi-weekly</option>
                                <option value="Semi-monthly" data-target="semi-monthly-container">Semi-monthly</option>
                            </select>
                        </div>
                    </div>

                    <!-- Frequency Options (Weekly, Bi-weekly, Semi-monthly) -->
                    <div class="mt-3">
                        <div class="card card-body visually-hidden frequency-container shadow-sm" id="weekly-container">
                            <label for="weekly_payday" class="form-label">Weekly Pay Day *</label>
                            <div class="input-group" name="weekly_payday">
                                <span class="display-6 input-group-text">Every:</span>
                                <select class="form-select shadow-sm" id="weekly_payday">
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

                        <div class="card card-body visually-hidden frequency-container shadow-sm" id="bi-weekly-container">
                            <label for="bi_weekly_payday" class="form-label">Bi-weekly Pay Day *</label>
                            <div class="input-group" name="bi_weekly_payday">
                                <span class="display-6 input-group-text">Every other:</span>
                                <select class="form-select shadow-sm" id="bi_weekly_payday">
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

                        <div class="card card-body visually-hidden frequency-container shadow-sm" id="semi-monthly-container">
                            <label for="semi_monthly_first_cutoff" class="form-label">First Pay Date</label>
                            <div class="input-group mb-3" name="semi_monthly_first_cutoff">
                                <span class="display-6 input-group-text">1st Pay Date:</span>
                                <select class="form-select shadow-sm" id="semi_monthly_first_cutoff" onchange="calculateSecondPay(document.getElementById('add_payrollGroups_form'));">
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
                                <input type="number" class="form-control shadow-sm" id="semi_monthly_second_cutoff" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Payday Offset -->
                    <div class="mt-3">
                        <label for="payday_offset" class="form-label fw-semibold">Payday Offset <span class="text-danger">*</span></label>
                        <select class="form-select shadow-sm" id="payday_offset" name="payday_offset" required>
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
                        <label for="payment_adjustment" class="form-label fw-semibold">Payment Adjustment <span class="text-danger">*</span></label>
                        <select class="form-select shadow-sm" id="payment_adjustment" name="payment_adjustment" required>
                            <option value="" disabled selected>Select adjustment...</option>
                            <option value="On the Saturday before">On the Saturday before</option>
                            <option value="Payday remains on the same day">Payday remains on the same day</option>
                            <option value="On the Monday after">On the Monday after</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mt-3">
                        <label for="create_status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select class="form-select shadow-sm" id="create_status" name="create_status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
            </div>

            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back"></i> Close
                </button>
                <button type="submit" id="create_payroll_group_btn" class="btn btn-success" onclick="createPayrollGroup();">
                    <i class="bx bx-plus"></i> Create
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Payroll Groups Add Form Modal -->