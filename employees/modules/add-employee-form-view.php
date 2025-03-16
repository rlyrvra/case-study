<?php

require_once __DIR__ . '/../EmployeeDao.php';
require_once __DIR__ . '/../EmployeeService.php';
require_once __DIR__ . '/../EmployeeRepository.php';
require_once __DIR__ . '/../Employee.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

function getEmployeesAllColumns($pdo, $token)
{
    try {
        $employeeDao = new EmployeeDao($pdo);


        $filterCriteria = [
            [
                "column" => "SHA2(employee.id, 256)",
                "operator" => "=",
                "value" => $token
            ],
        ];



        $employeeRepository = new EmployeeRepository($employeeDao);
        $employeeService = new EmployeeService($employeeRepository);
        $result = $employeeService->fetchAllEmployees([], $filterCriteria, [], 1);
        if ($result !== ActionResult::FAILURE) {
            $employees = $result['result_set'];
        }
        return $result;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return 0;
    }
}

$resultSet = getEmployeesAllColumns($pdo, $token);
$employees;
if ($resultSet["total_row_count"] <= 0) {
    header("Location: " . $SMARTWAGE_LOCATION . "/manage-employee.php?e=404");
    exit;
} else {
    $employees = $resultSet['result_set'];
}




?>
<style>.label-danger{color:red !important;}</style>
<div class="tab-pane fade show active" id="navs-pills-personal-information" role="tabpanel">
    <!-- Form -->
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-user-circle bx-lg"></i>  Personal Information: (1/6)</h3>
        <form onsubmit="event.preventDefault()" id="personal_information">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="firstName" class="form-label">First Name*</label>
                    <input type="text" class="form-control" id="firstName" placeholder="First Name" value='<?php echo $employees[0]['first_name']; ?>' readonly>
                </div>
                <div class="col-md-4">
                    <label for="middleName" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" id="middleName" placeholder="Middle Name" value='<?php echo $employees[0]['middle_name']; ?>' readonly>
                </div>
                <div class="col-md-4">
                    <label for="lastName" class="form-label">Last Name*</label>
                    <input type="text" class="form-control" id="lastName" placeholder="Last Name" value='<?php echo $employees[0]['last_name']; ?>' readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dob" class="form-label">Date of Birth*</label>
                    <input type="date" class="form-control" id="dob" value='<?php echo $employees[0]['date_of_birth']; ?>' readonly>
                </div>
                <div class="col-md-4">
                    <label for="gender" class="form-label">Gender*</label>
                    <select id="gender" class="form-select" readonly disabled>
                        <option disabled <?php echo empty($employees[0]['gender']) ? 'selected' : ''; ?>>Choose...</option>
                        <option value="Male" <?php echo $employees[0]['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $employees[0]['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo $employees[0]['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="maritalStatus" class="form-label">Marital Status*</label>
                    <select id="maritalStatus" class="form-select" disabled>
                        <option disabled>Choose...</option>
                        <option value="Single" <?php echo $employees[0]['marital_status'] === 'Single' ? 'selected' : ''; ?>>Single</option>
                        <option value="Married" <?php echo $employees[0]['marital_status'] === 'Married' ? 'selected' : ''; ?>>Married</option>
                        <option value="Divorced" <?php echo $employees[0]['marital_status'] === 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                        <option value="Widowed" <?php echo $employees[0]['marital_status'] === 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nationality" class="form-label">Nationality*</label>
                    <input type="text" class="form-control" id="nationality" placeholder="Nationality" value='<?php echo $employees[0]['nationality']; ?>' readonly>
                </div>
                <div class="col-md-6">
                    <label for="religion" class="form-label">Religion</label>
                    <input type="text" class="form-control" id="religion" placeholder="Religion" value='<?php echo $employees[0]['religion']; ?>' readonly>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="tab-pane fade" id="navs-pills-login-credentials" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-lock-alt bx-lg"></i> Login Credentials: (2/6)</h3>
        <form onsubmit="event.preventDefault()" id="login_credentials">
            <div class="mb-3">
                <label for="username" class="form-label">Username*:</label>
                <input type="text" class="form-control" id="username" placeholder="Enter your username" value='<?php echo $employees[0]['username']; ?>' readonly>
            </div>
        </form>
    </div>
</div>
<div class="tab-pane fade" id="navs-pills-contact-information" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-phone bx-lg"></i> Contact Information: (3/6)</h3>
        <form onsubmit="event.preventDefault()" id="contact_information">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone Number*</label>
                    <input type="text" class="form-control" id="phone" placeholder="Enter phone number" value='<?php echo $employees[0]['phone_number']; ?>' readonly>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email Address*</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email address" value='<?php echo $employees[0]['email_address']; ?>' readonly>
                </div>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address*</label>
                <textarea class="form-control" id="address" placeholder="Enter address" value='' readonly><?php echo $employees[0]['address']; ?></textarea>
            </div>

            <h3 class="form-title">Emergency Contact Information:</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="emergency-name" class="form-label">Name*</label>
                    <input type="text" class="form-control" id="emergency-name" placeholder="Enter name" value='<?php echo $employees[0]['emergency_contact_name']; ?>' readonly>
                </div>
                <div class="col-md-6">
                    <label for="relationship" class="form-label">Relationship*</label>
                    <input type="text" class="form-control" id="relationship" placeholder="Enter relationship" value='<?php echo $employees[0]['emergency_contact_relationship']; ?>' readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="emergency-phone" class="form-label">Phone Number*</label>
                    <input type="text" class="form-control" id="emergency-phone" placeholder="Enter phone number" value='<?php echo $employees[0]['emergency_contact_phone_number']; ?>' readonly>
                </div>
                <div class="col-md-6">
                    <label for="emergency-email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="emergency-email" placeholder="Enter email address" value='<?php echo $employees[0]['emergency_contact_email_address']; ?>' readonly>
                </div>
            </div>
            <div class="mb-3">
                <label for="emergency-address" class="form-label">Address</label>
                <input type="text" class="form-control" id="emergency-address" placeholder="Enter address" value='<?php echo $employees[0]['emergency_contact_address']; ?>' readonly>
            </div>
        </form>
    </div>
</div>
<div class="tab-pane fade" id="navs-pills-employment-information" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-briefcase bx-lg"></i> Employment Information: (4/6)</h3>
        <form onsubmit="event.preventDefault()" id="employment_information">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="rfid" class="form-label">RFID Tag*</label>
                    <input type="text" class="form-control" id="rfid" placeholder="Enter RFID Tag" value='<?php echo $employees[0]['rfid_uid']; ?>' readonly>
                </div>
                <div class="col-md-6">
                    <label for="employee-code" class="form-label">Employee Code*</label>
                    <input type="text" class="form-control" id="employee-code" placeholder="Enter Employee Code" value='<?php echo $employees[0]['employee_code']; ?>' readonly>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="job-title" class="form-label">Job Title*</label>
                    <select class="form-select selectize_job_title" id="job-title" name="job-title" readonly disabled>
                        <option value="<?php echo $employees[0]['job_title_id']; ?>" selected><?php echo $employees[0]['job_title_title']; ?></option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="department" class="form-label">Department*</label>
                    <select class="form-select selectize_department" id="department" name="departments" readonly disabled>
                        <option value="<?php echo $employees[0]['department_id']; ?>" selected><?php echo $employees[0]['department_name']; ?></option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="employment-type" class="form-label">Employment Type*</label>
                    <select class="form-select" id="employment-type" readonly disabled>
                        <option selected disabled>Select Type</option>
                        <option value="<?php echo $employees[0]['employment_type']; ?>" selected><?php echo $employees[0]['employment_type']; ?></option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date-of-hire" class="form-label">Date of Hire*</label>
                    <input type="date" class="form-control" id="date-of-hire" value='<?php echo $employees[0]['date_of_hire']; ?>' readonly>
                </div>
                <div class="col-md-6">
                    <label for="supervisor" class="form-label">Supervisor</label>
                    <select class="form-select selectize_supervisors" id="supervisor" readonly disabled>
                        <option value="<?php
                                        if (isset($employees[0]['supervisor_id'])) {
                                            echo $employees[0]['supervisor_id'];
                                        }
                                        // }else if(isset($employees[0]['manager_id'])){
                                        //     echo $employees[0]['manager_id']; 
                                        // }

                                        ?>" selected><?php
                                if (isset($employees[0]['supervisor_id'])) {
                                    echo $employees[0]['supervisor_first_name'] . " " . $employees[0]['supervisor_last_name'];
                                }
                                // }else if(isset($employees[0]['manager_id'])){
                                //     echo $employees[0]['manager_first_name'] . " " . $employees[0]['manager_last_name'];
                                // }
                                ?> </option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="btn-group">
                    <label class="display-5 pe-4">Role*:</label>
                    <input class="btn-check" type="radio" name="role" id="role-staff" value="Staff" <?php echo ($employees[0]['access_role'] == 'Staff') ? 'checked' : ''; ?> readonly disabled>
                    <label class="btn btn-outline-primary" for="role-staff">Staff</label>
                    <input class="btn-check" type="radio" name="role" id="role-supervisor" value="Supervisor" <?php echo ($employees[0]['access_role'] == 'Supervisor') ? 'checked' : ''; ?> readonly disabled>
                    <label class="btn btn-outline-primary" for="role-supervisor">Supervisor</label>
                    <input class="btn-check" type="radio" name="role" id="role-manager" value="Manager" <?php echo ($employees[0]['access_role'] == 'Manager') ? 'checked' : ''; ?> readonly disabled>
                    <label class="btn btn-outline-primary" for="role-manager">Manager</label>
                    <input class="btn-check" type="radio" name="role" id="role-admin" value="Admin" <?php echo ($employees[0]['access_role'] == 'Admin') ? 'checked' : ''; ?> readonly disabled>
                    <label class="btn btn-outline-primary" for="role-admin">Admin</label>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="tab-pane fade" id="navs-pills-pay-information" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-credit-card bx-lg"></i>  Pay Information: (5/6)</h3>
        <form onsubmit="event.preventDefault()" id="pay_information">
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="payrollGroup" class="form-label">Select Payroll Group*:</label>
                    <select class="form-select" id="payrollGroup" readonly disabled>
                        <option value="<?php echo $employees[0]['payroll_group_id']; ?>" selected></option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="hourlyRate" class="form-label">Basic Salary (per month)*:</label>
                    <input type="number" id="hourlyRate" class="form-control" placeholder="Enter hourly wage" value="<?php echo $employees[0]['basic_salary']; ?>" onchange="samplePayroll()" readonly>
                    <script>
                        $(document).ready(function() {
                            samplePayroll();
                        });
                    </script>
                </div>
            </div>

            <div class="form-container p-3 mb-4">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="annual" class="form-label">Annually:</label>
                        <input type="text" id="annual" class="form-control" placeholder="Annual amount" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="weekly" class="form-label">Weekly:</label>
                        <input type="text" id="weekly" class="form-control" placeholder="Weekly amount" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="monthly" class="form-label">Monthly:</label>
                        <input type="text" id="monthly" class="form-control" placeholder="Monthly amount" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="daily" class="form-label">Daily:</label>
                        <input type="text" id="daily" class="form-control" placeholder="Daily amount" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="semiMonthly" class="form-label">Semi-Monthly:</label>
                        <input type="text" id="semiMonthly" class="form-control" placeholder="Semi-monthly amount" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="hour" class="form-label">Hour:</label>
                        <input type="text" id="hour" class="form-control" placeholder="Hourly amount" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="biWeekly" class="form-label">Bi-Weekly:</label>
                        <input type="text" id="biWeekly" class="form-control" placeholder="Bi-weekly amount" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="perMinute" class="form-label">Per Minute:</label>
                        <input type="text" id="perMinute" class="form-control" placeholder="Per-minute amount" readonly>
                    </div>
                </div>
            </div>

            <!-- Bank Details Section -->
            <div class="bank-details">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="bankName" class="form-label">Bank Name*:</label>
                        <input type="text" id="bankName" class="form-control" placeholder="Enter bank name" value="<?php echo $employees[0]['bank_name']; ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="branchName" class="form-label">Branch Name*:</label>
                        <input type="text" id="branchName" class="form-control" placeholder="Enter branch name" value="<?php echo $employees[0]['bank_branch_name']; ?>" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="accountNumber" class="form-label">Account Number*:</label>
                        <input type="number" id="accountNumber" class="form-control" placeholder="Enter account number" value="<?php echo $employees[0]['bank_account_number']; ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="accountType" class="form-label">Account Type*:</label>
                        <select id="accountType" class="form-control" placeholder="Enter account type" disabled readonly>
                            <option value="" disabled>Select Payroll Account</option>
                            <option value="Payroll Account" <?php echo ($employees[0]['bank_account_type'] == 'Payroll Account') ? 'selected' : ''; ?>>Payroll Account</option>
                            <option value="Current Account" <?php echo ($employees[0]['bank_account_type'] == 'Current Account') ? 'selected' : ''; ?>>Current Account</option>
                            <option value="Checking Account" <?php echo ($employees[0]['bank_account_type'] == 'Checking Account') ? 'selected' : ''; ?>>Checking Account</option>
                            <option value="Savings Account" <?php echo ($employees[0]['bank_account_type'] == 'Savings Account') ? 'selected' : ''; ?>>Savings Account</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="tab-pane fade" id="navs-pills-government-information" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-id-card bx-lg"></i> Government Information: (6/6)</h3>
        <form onsubmit="event.preventDefault()" id="government-information">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tinNumber" class="form-label">TIN Number*:</label>
                    <input type="number" id="tinNumber" class="form-control" placeholder="Enter TIN Number" value="<?php echo $employees[0]['tin_number']; ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="SSSNumber" class="form-label">SSS Number*:</label>
                    <input type="number" id="SSSNumber" class="form-control" placeholder="Enter SSS Number" value="<?php echo $employees[0]['sss_number']; ?>" readonly>
                </div>

            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="PhilHealthNumber" class="form-label">PhilHealth Number*:</label>
                    <input type="number" id="PhilHealthNumber" class="form-control" placeholder="Enter PhilHealth Number" value="<?php echo $employees[0]['philhealth_number']; ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="PagIBIGNumber" class="form-label">Pag-IBIG Number*:</label>
                    <input type="number" id="PagIBIGNumber" class="form-control" placeholder="Enter Pag-IBIG Number" value="<?php echo $employees[0]['pagibig_fund_number']; ?>" readonly>
                </div>
            </div>
        </form>
    </div>
</div>