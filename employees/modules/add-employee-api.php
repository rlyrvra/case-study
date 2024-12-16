<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../EmployeeDao.php';
require_once __DIR__ . '/../EmployeeService.php';
require_once __DIR__ . '/../EmployeeRepository.php';
require_once __DIR__ . '/../Employee.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . "/../../includes/enums/ActionResult.php";
require_once __DIR__ . '/../../database/database.php';

require_once __DIR__ . '/../../includes/session.php';

try {
    $employeeDao = new EmployeeDao($pdo);
    $action = $_POST['action'] ?? '';

    if($action == 'create'){
        if(!isset($_POST['employeeData'])){
            return;
        }
        $employeeData = isset($_POST['employeeData']) ? $_POST['employeeData'] : [];

        $first_name = isset($employeeData['first_name']) ? validateInput($employeeData['first_name'], 'Personal Information: First Name') : '';
        $middle_name = isset($employeeData['middle_name']) ? $employeeData['middle_name'] : null;
        $last_name = isset($employeeData['last_name']) ? validateInput($employeeData['last_name'], 'Personal Information:  Last Name') : '';
        $date_of_birth = isset($employeeData['date_of_birth']) ? validateInput($employeeData['date_of_birth'], 'Personal Information:  Date of Birth') : '';
        $gender = isset($employeeData['gender']) ? validateInput($employeeData['gender'], 'Personal Information: Gender') : '';
        $marital_status = isset($employeeData['marital_status']) ? validateInput($employeeData['marital_status'], 'Personal Information: Marital Status') : '';
        $nationality = isset($employeeData['nationality']) ? validateInput($employeeData['nationality'], 'Personal Information:  Nationality') : '';
        $religion = isset($employeeData['religion']) ? $employeeData['religion'] : '';
        $profile_picture = isset($employeeData['profile_picture']) ? $employeeData['profile_picture'] : null;


        $username = isset($employeeData['username']) ? validateInput($employeeData['username'], 'Username') : '';
        $password = isset($employeeData['password']) ? validateInput($employeeData['password'], 'Password') : '';


        $phone = isset($employeeData['phone']) ? validateInput($employeeData['phone'], 'Phone') : '';
        $email = isset($employeeData['email']) ? validateInput($employeeData['email'], 'Email') : '';
        $address = isset($employeeData['address']) ? validateInput($employeeData['address'], 'Address') : '';
        $emergency_name = isset($employeeData['emergency_name']) ? validateInput($employeeData['emergency_name'], 'Emergency Contact Name') : '';
        $emergency_relationship = isset($employeeData['emergency_relationship']) ? validateInput($employeeData['emergency_relationship'], 'Emergency Relationship') : '';
        $emergency_phone = isset($employeeData['emergency_phone']) ? validateInput($employeeData['emergency_phone'], 'Emergency Phone') : '';
        $emergency_email = isset($employeeData['emergency_email']) ? $employeeData['emergency_email'] : null;
        $emergency_address = isset($employeeData['emergency_address']) ? $employeeData['emergency_address'] : null;


        $rfid = isset($employeeData['rfid']) ? validateInput($employeeData['rfid'], 'RFID') : '';
        $employment_type = isset($employeeData['employment_type']) ? validateInput($employeeData['employment_type'], 'RFID') : '';
        $job_title_id = isset($employeeData['job_title_id']) ? $employeeData['job_title_id'] : null;
        $department_id = isset($employeeData['department_id']) ? $employeeData['department_id'] : null;
        $date_of_hire = isset($employeeData['date_of_hire']) ? validateInput($employeeData['date_of_hire'], 'Date of Hire') : '';
        $supervisor_id = isset($employeeData['supervisor']) && !empty($employeeData['supervisor']) ? (int) $employeeData['supervisor'] : null;
        $access_role = isset($employeeData['access_role']) ? validateInput($employeeData['access_role'], 'Access Role') : '';

        
        $payroll_group_id = isset($employeeData['payroll_group_id']) ? validateInput($employeeData['payroll_group_id'], 'Payroll Group ID') : '';
        $hourly_rate = isset($employeeData['hourly_rate']) ? validateInput($employeeData['hourly_rate'], 'Hourly Rate') : null;
        $bank_name = isset($employeeData['bank_name']) ? validateInput($employeeData['bank_name'], 'Bank Name') : '';
        $bank_branch_name = isset($employeeData['branch_name']) ? validateInput($employeeData['branch_name'], 'Bank Branch Name') : '';
        $bank_account_number = isset($employeeData['bank_account_number']) ? validateInput($employeeData['bank_account_number'], 'Bank Account Number') : '';
        $bank_account_type = isset($employeeData['bank_account_type']) ? validateInput($employeeData['bank_account_type'], 'Bank Account Type') : '';


        $tin_number = isset($employeeData['tin_number']) ? validateInput($employeeData['tin_number'], 'Government Information: TIN Number') : '';
        $sss_number = isset($employeeData['sss_number']) ? validateInput($employeeData['sss_number'], 'Government Information: SSS Number') : '';
        $philhealth_number = isset($employeeData['philhealth_number']) ? validateInput($employeeData['philhealth_number'], 'Government Information: PhilHealth Number') : '';
        $pagibig_number = isset($employeeData['pagibig_number']) ? validateInput($employeeData['pagibig_number'], 'Government Information: Pag-IBIG Number') : '';


        $employeeRepository = new EmployeeRepository($employeeDao);
        $employeeService = new EmployeeService($employeeRepository);

        $newEmployee = new Employee(
            id: null,
            rfidUid: $rfid,
            firstName: $first_name,
            middleName: $middle_name,
            lastName: $last_name,
            dateOfBirth: $date_of_birth,
            gender: $gender,
            maritalStatus: $marital_status,
            nationality: $nationality,
            religion: $religion,
            phoneNumber: $phone,
            emailAddress: $email,
            address: $address,
            profilePicture: $profile_picture,
            emergencyContactName: $emergency_name,
            emergencyContactRelationship: $emergency_relationship,
            emergencyContactPhoneNumber: $emergency_phone,
            emergencyContactEmailAddress: $emergency_email,
            emergencyContactAddress: $emergency_address,
            employeeCode: "EMP-" . str_pad(($employeeService->countTotalRecords() + 1), 4, "0", STR_PAD_LEFT),
            jobTitleId: $job_title_id,
            departmentId: $department_id,
            employmentType: $employment_type,
            dateOfHire: $date_of_hire,
            supervisorId: $supervisor_id,
            accessRole: $access_role,
            payrollGroupId: $payroll_group_id,
            hourlyRate: $hourly_rate,
            tinNumber: $tin_number,
            sssNumber: $sss_number,
            philhealthNumber: $philhealth_number,
            pagibigFundNumber: $pagibig_number,
            bankName: $bank_name,
            bankBranchName: $bank_branch_name,
            bankAccountNumber: $bank_account_number,
            bankAccountType: $bank_account_type,
            username: $username,
            password: $password,
            notes: null,
            createdAt: '',
            updatedAt: '',
            deletedAt: null
        );

        $createResult = $employeeService->createEmployee($newEmployee);

        if ($createResult === ActionResult::SUCCESS) {
            echo "
            <script> 
            showSuccessCreate(); 
            </script>";
        } else if ($createResult === ActionResult::FAILURE){
            echo "
            <script> 
            //failedCreateUpdateTryAgain(); 
            </script>";
        }
        return;
    }

    if($action == 'update'){
        $hashed_id = $_POST['md5_id'] ?? null;
        if(!isset($_POST['employeeData'])){
            return;
        }
        // Retrieve employee data from POST request
        $employeeData = isset($_POST['employeeData']) ? $_POST['employeeData'] : [];

        // Validate and assign each field
        $first_name = isset($employeeData['first_name']) ? validateInput($employeeData['first_name'], 'Personal Information: First Name') : '';
        $middle_name = isset($employeeData['middle_name']) ? $employeeData['middle_name'] : null;
        $last_name = isset($employeeData['last_name']) ? validateInput($employeeData['last_name'], 'Personal Information:  Last Name') : '';
        $date_of_birth = isset($employeeData['date_of_birth']) ? validateInput($employeeData['date_of_birth'], 'Personal Information:  Date of Birth') : '';
        $gender = isset($employeeData['gender']) ? validateInput($employeeData['gender'], 'Personal Information: Gender') : '';
        $marital_status = isset($employeeData['marital_status']) ? validateInput($employeeData['marital_status'], 'Personal Information: Marital Status') : '';
        $nationality = isset($employeeData['nationality']) ? validateInput($employeeData['nationality'], 'Personal Information:  Nationality') : '';
        $religion = isset($employeeData['religion']) ? $employeeData['religion'] : '';
        $profile_picture = isset($employeeData['profile_picture']) ? $employeeData['profile_picture'] : null;


        $username = isset($employeeData['username']) ? validateInput($employeeData['username'], 'Username') : '';
        $password = isset($employeeData['password']) ? validateInput($employeeData['password'], 'Password') : '';


        $phone = isset($employeeData['phone']) ? validateInput($employeeData['phone'], 'Phone') : '';
        $email = isset($employeeData['email']) ? validateInput($employeeData['email'], 'Email') : '';
        $address = isset($employeeData['address']) ? validateInput($employeeData['address'], 'Address') : '';
        $emergency_name = isset($employeeData['emergency_name']) ? validateInput($employeeData['emergency_name'], 'Emergency Contact Name') : '';
        $emergency_relationship = isset($employeeData['emergency_relationship']) ? validateInput($employeeData['emergency_relationship'], 'Emergency Relationship') : '';
        $emergency_phone = isset($employeeData['emergency_phone']) ? validateInput($employeeData['emergency_phone'], 'Emergency Phone') : '';
        $emergency_email = isset($employeeData['emergency_email']) ? $employeeData['emergency_email'] : null;
        $emergency_address = isset($employeeData['emergency_address']) ? $employeeData['emergency_address'] : null;


        $rfid = isset($employeeData['rfid']) ? validateInput($employeeData['rfid'], 'RFID') : '';
        $employment_type = isset($employeeData['employment_type']) ? validateInput($employeeData['employment_type'], 'RFID') : '';
        $job_title_id = isset($employeeData['job_title_id']) ? $employeeData['job_title_id'] : null;
        $department_id = isset($employeeData['department_id']) ? $employeeData['department_id'] : null;
        $date_of_hire = isset($employeeData['date_of_hire']) ? validateInput($employeeData['date_of_hire'], 'Date of Hire') : '';
        $supervisor_id = isset($employeeData['supervisor']) && !empty($employeeData['supervisor']) ? (int) $employeeData['supervisor'] : null;
        $access_role = isset($employeeData['access_role']) ? validateInput($employeeData['access_role'], 'Access Role') : '';

        
        $payroll_group_id = isset($employeeData['payroll_group_id']) ? validateInput($employeeData['payroll_group_id'], 'Payroll Group ID') : '';
        $hourly_rate = isset($employeeData['hourly_rate']) ? validateInput($employeeData['hourly_rate'], 'Hourly Rate') : null;
        $bank_name = isset($employeeData['bank_name']) ? validateInput($employeeData['bank_name'], 'Bank Name') : '';
        $bank_branch_name = isset($employeeData['branch_name']) ? validateInput($employeeData['branch_name'], 'Bank Branch Name') : '';
        $bank_account_number = isset($employeeData['bank_account_number']) ? validateInput($employeeData['bank_account_number'], 'Bank Account Number') : '';
        $bank_account_type = isset($employeeData['bank_account_type']) ? validateInput($employeeData['bank_account_type'], 'Bank Account Type') : '';


        $tin_number = isset($employeeData['tin_number']) ? validateInput($employeeData['tin_number'], 'Government Information: TIN Number') : '';
        $sss_number = isset($employeeData['sss_number']) ? validateInput($employeeData['sss_number'], 'Government Information: SSS Number') : '';
        $philhealth_number = isset($employeeData['philhealth_number']) ? validateInput($employeeData['philhealth_number'], 'Government Information: PhilHealth Number') : '';
        $pagibig_number = isset($employeeData['pagibig_number']) ? validateInput($employeeData['pagibig_number'], 'Government Information: Pag-IBIG Number') : '';


        $employeeRepository = new EmployeeRepository($employeeDao);
        $employeeService = new EmployeeService($employeeRepository);

        $empCode = $employeeService->fetchAllEmployees(
            ['employee_code'], 
            [
                [
                "column" => "MD5(employee.id)",
                "operator" => "=",
                "value" => $hashed_id
                ]
            ], [], 1
        );
        $updatedEmployee = new Employee(
            id: $hashed_id,
            rfidUid: $rfid,
            firstName: $first_name,
            middleName: $middle_name,
            lastName: $last_name,
            dateOfBirth: $date_of_birth,
            gender: $gender,
            maritalStatus: $marital_status,
            nationality: $nationality,
            religion: $religion,
            phoneNumber: $phone,
            emailAddress: $email,
            address: $address,
            profilePicture: $profile_picture,
            emergencyContactName: $emergency_name,
            emergencyContactRelationship: $emergency_relationship,
            emergencyContactPhoneNumber: $emergency_phone,
            emergencyContactEmailAddress: $emergency_email,
            emergencyContactAddress: $emergency_address,
            employeeCode: $empCode['result_set'][0]['employee_code'],
            jobTitleId: $job_title_id,
            departmentId: $department_id,
            employmentType: $employment_type,
            dateOfHire: $date_of_hire,
            supervisorId: $supervisor_id,
            accessRole: $access_role,
            payrollGroupId: $payroll_group_id,
            hourlyRate: $hourly_rate,
            tinNumber: $tin_number,
            sssNumber: $sss_number,
            philhealthNumber: $philhealth_number,
            pagibigFundNumber: $pagibig_number,
            bankName: $bank_name,
            bankBranchName: $bank_branch_name,
            bankAccountNumber: $bank_account_number,
            bankAccountType: $bank_account_type,
            username: $username,
            password: $password,
            notes: null,
            createdAt: '',
            updatedAt: '',
            deletedAt: null
        );


        $updateResult = $employeeService->updateEmployee($updatedEmployee, true);

        if ($updateResult === ActionResult::SUCCESS) {
            echo "
            <script> 
                showSuccessUpdate('$hashed_id'); 
            </script>";
        } else if ($updateResult === ActionResult::FAILURE){
            echo "
            <script> 
                failedUpdateTryAgain('$hashed_id'); 
            </script>";
        }
        return;
    }


    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Function to validate and sanitize input
function validateInput($input, $fieldName) {
    // Trim the input to remove extra whitespaces
    $input = trim($input);
    
    // Check if input is empty after trimming
    if (empty($input)) {
        die("
        <script>
            missingFieldValues('{$fieldName}');
        </script>
        ");
    }
    
    // Additional validation can go here (e.g., regex for specific formats)
    
    return htmlspecialchars($input); // Sanitize to prevent XSS
}