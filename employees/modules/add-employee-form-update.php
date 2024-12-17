<?php

require_once __DIR__ . '/../EmployeeDao.php';
require_once __DIR__ . '/../EmployeeService.php';
require_once __DIR__ . '/../EmployeeRepository.php';
require_once __DIR__ . '/../Employee.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

function getEmployeesAllColumns($pdo, $token){
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
if($resultSet["total_row_count"] <= 0){
    header("Location: ". $SMARTWAGE_LOCATION . "/manage-employee.php?e=404");
    exit;
}else{
    $employees = $resultSet['result_set'];
}




?>
<div class="tab-pane fade show active" id="navs-pills-personal-information" role="tabpanel">
    <!-- Form -->
    <div class="form-container p-4">
    <h3 class="form-title">Personal Information: (1/6)</h3>
    <form onsubmit="event.preventDefault()" id="personal_information">
        <div class="row mb-3">
        <div class="col-md-4">
            <label for="firstName" class="form-label">First Name*</label>
            <input type="text" class="form-control" id="firstName" placeholder="First Name" value='<?php echo $employees[0]['first_name'];?>'>
        </div>
        <div class="col-md-4">
            <label for="middleName" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middleName" placeholder="Middle Name" value='<?php echo $employees[0]['middle_name'];?>'>
        </div>
        <div class="col-md-4">
            <label for="lastName" class="form-label">Last Name*</label>
            <input type="text" class="form-control" id="lastName" placeholder="Last Name" value='<?php echo $employees[0]['last_name'];?>'>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-4">
            <label for="dob" class="form-label">Date of Birth*</label>
            <input type="date" class="form-control" id="dob" value='<?php echo $employees[0]['date_of_birth'];?>'>
        </div>
        <div class="col-md-4">
            <label for="gender" class="form-label">Gender*</label>
            <select id="gender" class="form-select">
                <option disabled <?php echo empty($employees[0]['gender']) ? 'selected' : ''; ?>>Choose...</option>
                <option value="Male" <?php echo $employees[0]['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo $employees[0]['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo $employees[0]['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="maritalStatus" class="form-label">Marital Status*</label>
            <select id="maritalStatus" class="form-select">
                <option disabled>Choose...</option>
                <option value="Single" <?php echo $employees[0]['marital_status'] === 'Single' ? 'selected' : ''; ?>>Single</option>
                <option value="Married" <?php echo $employees[0]['marital_status'] === 'Married' ? 'selected' : ''; ?>>Married</option>
                <option value="Divorced" <?php echo $employees[0]['marital_status'] === 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
            </select>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="nationality" class="form-label">Nationality*</label>
            <input type="text" class="form-control" id="nationality" placeholder="Nationality" value='<?php echo $employees[0]['nationality'];?>'>
        </div>
        <div class="col-md-6">
            <label for="religion" class="form-label">Religion</label>
            <input type="text" class="form-control" id="religion" placeholder="Religion" value='<?php echo $employees[0]['religion'];?>'>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-12">
            <label for="profilePicture" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" id="profilePicture" accept=".jpg" onchange="previewImage(event)">
        </div>
        </div>
    </form>
    </div>
</div>
<div class="tab-pane fade" id="navs-pills-login-credentials" role="tabpanel">
    <div class="form-container p-4">
    <h3 class="form-title">Login Credentials: (2/6)</h3>
    <form onsubmit="event.preventDefault()" id="login_credentials">
        <div class="mb-3">
        <label for="username" class="form-label">Username*:</label>
        <input type="text" class="form-control" id="username" placeholder="Enter your username" value='<?php echo $employees[0]['username'];?>'>
        </div>
        <div class="mb-3">
        <label for="password" class="form-label">Password*:</label>
        <input type="password" class="form-control" id="password" placeholder="Enter your password" value='<?php echo $employees[0]['password'];?>'>
        </div>
    </form>
    </div>
</div>
<div class="tab-pane fade" id="navs-pills-contact-information" role="tabpanel">
    <div class="form-container p-4">
    <h3 class="form-title">Contact Information: (3/6)</h3>
    <form onsubmit="event.preventDefault()" id="contact_information">
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="phone" class="form-label">Phone Number*</label>
            <input type="text" class="form-control" id="phone" placeholder="Enter phone number" value='<?php echo $employees[0]['phone_number'];?>'>
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email Address*</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email address" value='<?php echo $employees[0]['email_address'];?>'>
        </div>
        </div>
        <div class="mb-3">
        <label for="address" class="form-label">Address*</label>
        <textarea class="form-control" id="address" placeholder="Enter address"><?php echo $employees[0]['address'];?></textarea>
        </div>

        <h3 class="form-title">Emergency Contact Information:</h3>
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="emergency-name" class="form-label">Name*</label>
            <input type="text" class="form-control" id="emergency-name" placeholder="Enter name" value='<?php echo $employees[0]['emergency_contact_name'];?>'>
        </div>
        <div class="col-md-6">
            <label for="relationship" class="form-label">Relationship*</label>
            <input type="text" class="form-control" id="relationship" placeholder="Enter relationship" value='<?php echo $employees[0]['emergency_contact_relationship'];?>'>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="emergency-phone" class="form-label">Phone Number*</label>
            <input type="text" class="form-control" id="emergency-phone" placeholder="Enter phone number" value='<?php echo $employees[0]['emergency_contact_phone_number'];?>'>
        </div>
        <div class="col-md-6">
            <label for="emergency-email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="emergency-email" placeholder="Enter email address" value='<?php echo $employees[0]['emergency_contact_email_address'];?>'>
        </div>
        </div>
        <div class="mb-3">
        <label for="emergency-address" class="form-label">Address</label>
        <input type="text" class="form-control" id="emergency-address" placeholder="Enter address" value='<?php echo $employees[0]['emergency_contact_address'];?>'>
        </div>
    </form>
    </div>
</div>
<div class="tab-pane fade" id="navs-pills-employment-information" role="tabpanel">
    <div class="form-container p-4">
    <h3 class="form-title">Employment Information: (4/6)</h3>
    <form onsubmit="event.preventDefault()" id="employment_information">
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="rfid" class="form-label">RFID Tag*</label>
            <input type="number" class="form-control" id="rfid" placeholder="Enter RFID Tag" value='<?php echo $employees[0]['rfid_uid'];?>'>
        </div>
        <div class="col-md-6">
            <label for="employee-code" class="form-label">Employee Code*</label>
            <input type="text" class="form-control" id="employee-code" placeholder="Enter Employee Code" value='<?php echo $employees[0]['employee_code'];?>'>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-4">
            <label for="job-title" class="form-label">Job Title*</label>
            <select class="form-select selectize_job_title" id="job-title" name="job-title">
                <option value="<?php echo $employees[0]['job_title_id']; ?>" selected><?php echo $employees[0]['job_title_title']; ?></option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="department" class="form-label">Department*</label>
            <select class="form-select selectize_department" id="department" name="departments">
                <option value="<?php echo $employees[0]['department_id']; ?>" selected><?php echo $employees[0]['department_name']; ?></option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="employment-type" class="form-label">Employment Type*</label>
            <select class="form-select" id="employment-type">
            <option selected disabled>Select Type</option>
            <option value="<?php echo $employees[0]['employment_type']; ?>" selected><?php echo $employees[0]['employment_type']; ?></option>
            <option value="Regular / Permanent">Regular / Permanent</option>
            <option value="Casual">Casual</option>
            <option value="Contractual">Contractual</option>
            <option value="Project-Based">Project-Based</option>
            <option value="Seasonal">Seasonal</option>
            <option value="Fixed-Term">Fixed-Term</option>
            <option value="Probationary">Probationary</option>
            <option value="Part-Time">Part-Time</option>
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
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="date-of-hire" class="form-label">Date of Hire*</label>
            <input type="date" class="form-control" id="date-of-hire" value='<?php echo $employees[0]['date_of_hire'];?>'>
        </div>
        <div class="col-md-6">
            <label for="supervisor" class="form-label">Supervisor</label>
            <select class="form-select selectize_supervisors" id="supervisor" disabled>
                <option value="<?php
                if(isset($employees[0]['supervisor_id'])){
                    echo $employees[0]['supervisor_id']; 
                }
                // }else if(isset($employees[0]['manager_id'])){
                //     echo $employees[0]['manager_id']; 
                // }
                
                ?>" selected><?php 
                if(isset($employees[0]['supervisor_id'])){
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
            <label class="form-label">Role*</label>
            <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="role-staff" value="Staff" <?php echo ($employees[0]['access_role'] == 'Staff') ? 'checked' : ''; ?>>
            <label class="form-check-label" for="role-staff">Staff</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="role" id="role-supervisor" value="Supervisor" <?php echo ($employees[0]['access_role'] == 'Supervisor') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="role-supervisor">Supervisor</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="role" id="role-manager" value="Manager" <?php echo ($employees[0]['access_role'] == 'Manager') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="role-manager">Manager</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="role" id="role-admin" value="Admin" <?php echo ($employees[0]['access_role'] == 'Admin') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="role-admin">Admin</label>
            </div>
        </div>
    </form>
    </div>
</div>
<div class="tab-pane fade" id="navs-pills-pay-information" role="tabpanel">
    <div class="form-container p-4">
    <h3 class="form-title">Pay Information: (5/6)</h3>
    <form onsubmit="event.preventDefault()" id="pay_information">
        <div class="row mb-4">
        <div class="col-md-4">
            <label for="payrollGroup" class="form-label">Select Payroll Group*:</label>
            <select class="form-select" id="payrollGroup">
                <option value="<?php echo $employees[0]['payroll_group_id']; ?>" selected></option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="hourlyRate" class="form-label">Hourly Rate*:</label>
            <input type="number" id="hourlyRate" class="form-control" placeholder="Enter hourly wage" value="<?php echo $employees[0]['hourly_rate']; ?>" onchange="samplePayroll()">
            <script>
                $(document).ready(function () {
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
                <input type="text" id="bankName" class="form-control" placeholder="Enter bank name" value="<?php echo $employees[0]['bank_name']; ?>">
            </div>
            <div class="col-md-6">
                <label for="branchName" class="form-label">Branch Name*:</label>
                <input type="text" id="branchName" class="form-control" placeholder="Enter branch name" value="<?php echo $employees[0]['bank_branch_name']; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="accountNumber" class="form-label">Account Number*:</label>
                <input type="number" id="accountNumber" class="form-control" placeholder="Enter account number" value="<?php echo $employees[0]['bank_account_number']; ?>">
            </div>
            <div class="col-md-6">
                <label for="accountType" class="form-label">Account Type*:</label>
                <input type="text" id="accountType" class="form-control" placeholder="Enter account type" value="<?php echo $employees[0]['bank_account_type']; ?>">
            </div>
        </div>
        </div>
    </form>
    </div>
</div>
<div class="tab-pane fade" id="navs-pills-government-information" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title">Government Information: (6/6)</h3>
        <form onsubmit="event.preventDefault()" id="government-information">
            <div class="row mb-3">
                <div class="col-md-6">
                <label for="tinNumber" class="form-label">TIN Number*:</label>
                <input type="number" id="tinNumber" class="form-control" placeholder="Enter TIN Number" value="<?php echo $employees[0]['tin_number']; ?>">
                </div>
                <div class="col-md-6">
                <label for="SSSNumber" class="form-label">SSS Number*:</label>
                <input type="number" id="SSSNumber" class="form-control" placeholder="Enter SSS Number" value="<?php echo $employees[0]['sss_number']; ?>">
                </div>
                
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                <label for="PhilHealthNumber" class="form-label">PhilHealth Number*:</label>
                <input type="number" id="PhilHealthNumber" class="form-control" placeholder="Enter PhilHealth Number" value="<?php echo $employees[0]['philhealth_number']; ?>">
                </div>
                <div class="col-md-6">
                <label for="PagIBIGNumber" class="form-label">Pag-IBIG Number*:</label>
                <input type="number" id="PagIBIGNumber" class="form-control" placeholder="Enter Pag-IBIG Number" value="<?php echo $employees[0]['pagibig_fund_number']; ?>">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12 justify-content-end d-flex">
        <button type="button" class="btn btn-info" id="personal_info_submit" onclick="updateEmployee(this)" data-token="<?php echo $token; ?>"><i class="bx bx-edit-alt"></i>Submit</button>
    </div>
</div>
