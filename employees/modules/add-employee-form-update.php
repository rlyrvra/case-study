<?php

require_once __DIR__ . '/../EmployeeDao.php';
require_once __DIR__ . '/../EmployeeService.php';
require_once __DIR__ . '/../EmployeeRepository.php';
require_once __DIR__ . '/../Employee.php';

require_once __DIR__ . '/../../includes/Helper.php';
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
<style>.label-danger{color:red !important;}</style>
<!-- Personal Information Form -->
<div class="tab-pane fade show active" id="navs-pills-personal-information" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-user-circle bx-lg"></i>  Personal Information: (1/6)</h3>
        <form onsubmit="event.preventDefault()" id="personal_information">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="firstName" class="form-label">First Name<span class="label-danger">(*)</span>:</label>
                    <input type="text" 
                           class="form-control" 
                           id="firstName" 
                           placeholder="John" 
                           required 
                           minlength="1" 
                           maxlength="30"
                           pattern="^[A-Za-z\s]+$" 
                           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                           title="Only letters and spaces allowed"
                           value='<?php echo $employees[0]['first_name'];?>'>
                </div>
                <div class="col-md-4">
                    <label for="middleName" class="form-label">Middle Name</label>
                    <input type="text" 
                           class="form-control" 
                           id="middleName" 
                           placeholder="Smith"
                           minlength="1"
                           maxlength="30"
                           pattern="^[A-Za-z\s]+$" 
                           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                           title="Only letters and spaces allowed"
                           value='<?php echo $employees[0]['middle_name'];?>'>
                </div>
                <div class="col-md-4">
                    <label for="lastName" class="form-label">Last Name<span class="label-danger">(*)</span>:</label>
                    <input type="text" 
                           class="form-control" 
                           id="lastName" 
                           placeholder="Doe" 
                           required 
                           minlength="1" 
                           maxlength="30"
                           pattern="^[A-Za-z\s]+$" 
                           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                           title="Only letters and spaces allowed"
                           value='<?php echo $employees[0]['last_name'];?>'>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dob" class="form-label">Date of Birth<span class="label-danger">(*)</span>:</label>
                    <input type="date" 
                           class="form-control" 
                           id="dob" 
                           required 
                           oninput="this.setAttribute('max', new Date().toISOString().split('T')[0])"
                           value='<?php echo $employees[0]['date_of_birth'];?>'>
                </div>
                <div class="col-md-4">
                    <label for="gender" class="form-label">Gender*</label>
                    <select id="gender" class="form-select" required>
                        <option value="" selected disabled>Choose...</option>
                        <option value="Male" <?php echo $employees[0]['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $employees[0]['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo $employees[0]['gender'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="maritalStatus" class="form-label">Marital Status<span class="label-danger">(*)</span>:</label>
                    <select id="maritalStatus" class="form-select" required>
                        <option value="" selected disabled>Choose...</option>
                        <option value="Single" <?php echo $employees[0]['marital_status'] === 'Single' ? 'selected' : ''; ?>>Single</option>
                        <option value="Married" <?php echo $employees[0]['marital_status'] === 'Married' ? 'selected' : ''; ?>>Married</option>
                        <option value="Divorced" <?php echo $employees[0]['marital_status'] === 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                        <option value="Widowed" <?php echo $employees[0]['marital_status'] === 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nationality" class="form-label">Nationality<span class="label-danger">(*)</span>:</label>
                    <input type="text" 
                           class="form-control" 
                           list="nationalityList" 
                           id="nationality" 
                           placeholder="Nationality" 
                           required
                           pattern="^[A-Za-z\s]+$" 
                           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                           title="Only letters and spaces allowed"
                           value='<?php echo $employees[0]['nationality'];?>'>
                    <datalist id="nationalityList">
                        <option value="American"></option>
                        <option value="British"></option>
                        <option value="Canadian"></option>
                        <option value="Filipino"></option>
                        <option value="Indian"></option>
                        <option value="Japanese"></option>
                        <option value="Mexican"></option>
                        <option value="Russian"></option>
                        <option value="Spanish"></option>
                        <option value="Other"></option>
                    </datalist>
                </div>
                <div class="col-md-6">
                    <label for="religion" class="form-label">Religion</label>
                    <input type="text" 
                           class="form-control" 
                           list="religionList" 
                           id="religion" 
                           placeholder="Religion"
                           pattern="^[A-Za-z\s]+$" 
                           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                           title="Only letters and spaces allowed"
                           value='<?php echo $employees[0]['religion'];?>'>
                    <datalist id="religionList">
                        <option value="Christianity"></option>
                        <option value="Islam"></option>
                        <option value="Hinduism"></option>
                        <option value="Buddhism"></option>
                        <option value="Judaism"></option>
                        <option value="Atheism"></option>
                        <option value="Other"></option>
                    </datalist>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="profilePicture" class="form-label">Profile Picture (MAX: 2MB)</label>
                    <input type="file" class="form-control" id="profilePicture" accept=".jpg" onchange="previewImage(event)">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 justify-content-end d-flex">
                    <button type="submit" class="btn btn-primary" id="personal_info_submit" onclick="nextForm(2, this)" data-form="personal_information">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /Personal Information Form -->
 <!-- Login Credentials Form -->
 <div class="tab-pane fade" id="navs-pills-login-credentials" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-lock-alt bx-lg"></i> Login Credentials: (2/6)</h3>
        <form onsubmit="event.preventDefault()" id="login_credentials">
            <div class="mb-3">
                <label for="username" class="form-label">Username<span class="label-danger">(*)</span>:</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="username" 
                    placeholder="Enter your username" 
                    value='<?php echo $employees[0]['username'];?>'
                    required 
                    title="Username must be 3-50 characters"
                    oninput="setCustomValidity('')"
                    oninvalid="setCustomValidity('Invalid username. Must be 3-50 characters, no consecutive special characters, and cannot start or end with . _ -')"
                />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password<span class="label-danger">(*)</span>:</label>
                <div class="input-group">
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password" 
                        placeholder="Enter your password" 
                        value='<?php echo $employees[0]['password'];?>'
                        required 
                        pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*\-+=]).{8,50}$"
                        title="Password must be 8 to 50 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character (!@#$%^&*()-+=)." 
                        oninput="setCustomValidity('')" 
                        oninvalid="setCustomValidity('Password must be 8 to 50 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character (!@#$%^&*()-+=).')"
                    >
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                        <i class="bx bx-show"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password<span class="label-danger">(*)</span>:</label>
                <div class="input-group">
                    <input 
                        type="password" 
                        class="form-control" 
                        id="confirmPassword" 
                        placeholder="Confirm your password" 
                        value='<?php echo $employees[0]['password'];?>'
                        required 
                        oninput="validateConfirmPassword();"
                    >
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                        <i class="bx bx-show"></i>
                    </button>
                </div>
                <div id="confirmPassError" class="text-danger mt-1" style="display: none;">Passwords do not match.</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 justify-content-end d-flex">
                    <button type="submit" class="btn btn-primary" id="login_credentials_submit" onclick="nextForm(3, this)" data-form="login_credentials">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /Login Credentials Form -->
<!-- Contact Information Form -->
<div class="tab-pane fade" id="navs-pills-contact-information" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-phone bx-lg"></i> Contact Information: (3/6)</h3>
        <form onsubmit="event.preventDefault()" id="contact_information">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone Number<span class="label-danger">(*)</span>:</label>
                    <input type="text" 
                    class="form-control" 
                    id="phone" 
                    placeholder="+63 958 999 3454" 
                    list="phone-options" 
                    required 
                    title="Enter a valid phone number..."
                    minlength="1"
                    maxlength="15"
                    value='<?php echo $employees[0]['phone_number'];?>'>
                    <datalist id="phone-options">
                        <option value="123-456-7890">
                        <option value="(555) 987-6543">
                        <option value="+1-800-555-1234">
                    </datalist>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email Address<span class="label-danger">(*)</span>:</label>
                    <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    placeholder="john.doe@example.com" 
                    list="email-options" 
                    required 
                    minlength="1" 
                    maxlength="255"
                    value='<?php echo $employees[0]['email_address'];?>'>
                    <datalist id="email-options">
                        <option value="example@email.com">
                        <option value="user123@mailservice.com">
                        <option value="john.doe@company.org">
                    </datalist>
                </div>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address<span class="label-danger">(*)</span>:</label>
                <textarea 
                class="form-control" 
                id="address" 
                placeholder="123 Main St, Springfield, IL 62704" 
                list="address-options" 
                required 
                minlength="1" 
                maxlength="255"><?php echo $employees[0]['address'];?></textarea>
                <datalist id="address-options">
                    <option value="123 Main St, Springfield, IL 62704">
                    <option value="456 Elm Avenue, Apt 2B, Los Angeles, CA 90001">
                    <option value="789 Pine Road, Suite 300, New York, NY 10001">
                </datalist>
            </div>

            <h3 class="form-title">Emergency Contact Information:</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="emergency-name" class="form-label">Name<span class="label-danger">(*)</span>:</label>
                    <input type="text" 
                    class="form-control" 
                    id="emergency-name" 
                    placeholder="Jane Doe" 
                    list="emergency-name-options" 
                    required 
                    minlength="1" 
                    maxlength="90"
                    pattern="^[A-Za-z\s]+$" 
                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                    title="Only letters and spaces allowed"
                    value='<?php echo $employees[0]['emergency_contact_name'];?>'>
                    <datalist id="emergency-name-options">
                        <option value="Jane Doe">
                        <option value="Michael Smith">
                        <option value="Emily Johnson">
                    </datalist>
                </div>
                <div class="col-md-6">
                    <label for="relationship" class="form-label">Relationship<span class="label-danger">(*)</span>:</label>
                    <input 
                    type="text" 
                    class="form-control" 
                    id="relationship" 
                    placeholder="Mother" 
                    list="relationship-options" 
                    required 
                    minlength="1" 
                    maxlength="30"
                    value='<?php echo $employees[0]['emergency_contact_relationship'];?>'>
                    <datalist id="relationship-options">
                        <option value="Mother">
                        <option value="Brother">
                        <option value="Close Friend">
                    </datalist>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="emergency-phone" class="form-label">Phone Number<span class="label-danger">(*)</span>:</label>
                    <input type="text" 
                    class="form-control" 
                    id="emergency-phone" 
                    placeholder="321-654-0987" 
                    list="emergency-phone-options" 
                    required 
                    minlength="1" 
                    maxlength="15"
                    pattern="^[0-9+\-]+$" 
                    oninput="this.value = this.value.replace(/[^0-9+-]/g, '')" 
                    title="Only numbers, dashes, and plus sign allowed"
                    value='<?php echo $employees[0]['emergency_contact_phone_number'];?>'>
                    <datalist id="emergency-phone-options">
                        <option value="321-654-0987">
                        <option value="(777) 222-3344">
                        <option value="+1-888-999-5678">
                    </datalist>
                </div>
                <div class="col-md-6">
                    <label for="emergency-email" class="form-label">Email Address</label>
                    <input type="email" 
                    class="form-control" 
                    id="emergency-email" 
                    placeholder="jane.doe@email.com" 
                    list="emergency-email-options" 
                    minlength="1" 
                    maxlength="255"
                    value='<?php echo $employees[0]['emergency_contact_email_address'];?>'>
                    <datalist id="emergency-email-options">
                        <option value="jane.doe@email.com">
                        <option value="michael.smith@mailprovider.net">
                        <option value="emily.johnson@workplace.org">
                    </datalist>
                </div>
            </div>
            <div class="mb-3">
                <label for="emergency-address" class="form-label">Address</label>
                <textarea 
                class="form-control" 
                id="emergency-address" 
                placeholder="123 Main St, Springfield, IL 62704" 
                list="emergency-address-options" 
                required 
                minlength="1" 
                maxlength="255"><?php echo $employees[0]['emergency_contact_address'];?></textarea>
                <datalist id="emergency-address-options">
                    <option value="456 Oak Street, Chicago, IL 60616">
                    <option value="789 Birch Blvd, San Diego, CA 92101">
                    <option value="234 Cedar Lane, Miami, FL 33101">
                </datalist>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 justify-content-end d-flex">
                    <button type="button" class="btn btn-outline-primary" id="contact_information_quick" onclick="fillContactInfo()">Quick Fill</button>
                    <button type="submit" class="btn btn-primary mx-2" id="contact_information_submit" onclick="nextForm(4, this)" data-form="contact_information">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /Contact Information Form -->
<!-- Employment Information Form -->
<div class="tab-pane fade" id="navs-pills-employment-information" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-briefcase bx-lg"></i> Employment Information: (4/6)</h3>
        <form onsubmit="event.preventDefault()" id="employment_information">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="rfid" class="form-label">RFID Tag<span class="label-danger">(*)</span>:</label>
                    <div class="input-group" name="rfid">
                        <button type="button" class="input-group-text button btn-primary" data-bs-toggle="modal" data-bs-target="#rfid_modal" onclick="turnOnScanning();"><i class="bx bx-card fs-4 lh-0"></i></button>
                        <input type="text" class="form-control" id="rfid" placeholder="Scan your RFID tag" required readonly value='<?php echo $employees[0]['rfid_uid'];?>'>
                    </div>
                </div>
                <!-- RFID Modal -->
                <div class="modal fade" id="rfid_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rfid_modalLabel">Scan your RFID</h5>
                                <!-- Remove this button if you don't want a close button -->
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeRFIDModal()"></button>
                            </div>
                            <div class="modal-body">
                                <img src="img/tap.webp" alt="tap-your-rfid" class='h-auto card-img mb-3'></img>
                                <h1 class="display-1 text-center visually-hidden" id="rfid-label">XXXXXXXXXXXX</h1>
                                <h2 class="display-2 text-center mb-3" id="rfid-label-output">XXXXXXXXXXXX</h2>
                                <h6 class="text-muted">Make sure you click on the website to be able to capture the card.</h6>
                            </div>
                            <div class="modal-footer">
                                <!-- Provide a controlled way to close it, like a confirmation button -->
                                <button type="button" class="col btn btn-success" onclick="confirmRFID()">Confirm</button>
                                <button type="button" class="col btn btn-danger" onclick="closeRFIDModal()">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="employee-code" class="form-label">Employee Code<span class="label-danger">(*)</span>:</label>
                    <input type="text" class="form-control" id="employee-code" placeholder="Enter Employee Code" readonly value='<?php echo $employees[0]['employee_code'];?>'>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="job-title" class="form-label">Job Title<span class="label-danger">(*)</span>:</label>
                    <select class="form-select selectize_job_title" id="job-title" name="job-title" required>
                        <option value="<?php echo $employees[0]['job_title_id']; ?>" selected><?php echo $employees[0]['job_title']; ?></option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="department" class="form-label">Department<span class="label-danger">(*)</span>:</label>
                    <select class="form-select selectize_department" id="department" name="departments" required>
                        <option value="<?php echo $employees[0]['department_id']; ?>" selected><?php echo $employees[0]['department_name']; ?></option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="employment-type" class="form-label">Employment Type<span class="label-danger">(*)</span>:</label>
                    <select class="form-select" id="employment-type" required>
                        <option value="" disabled>Select Type</option>
                        <option value="Regular" <?php echo $employees[0]['employment_type'] === 'Regular' ? 'selected' : ''; ?>>Regular</option>
                        <option value="Regular Permanent" <?php echo $employees[0]['employment_type'] === 'Regular Permanent' ? 'selected' : ''; ?>>Regular Permanent</option>
                        <option value="Casual" <?php echo $employees[0]['employment_type'] === 'Casual' ? 'selected' : ''; ?>>Casual</option>
                        <option value="Contractual" <?php echo $employees[0]['employment_type'] === 'Contractual' ? 'selected' : ''; ?>>Contractual</option>
                        <option value="Project-Based" <?php echo $employees[0]['employment_type'] === 'Project-Based' ? 'selected' : ''; ?>>Project-Based</option>
                        <option value="Seasonal" <?php echo $employees[0]['employment_type'] === 'Seasonal' ? 'selected' : ''; ?>>Seasonal</option>
                        <option value="Fixed-Term" <?php echo $employees[0]['employment_type'] === 'Fixed-Term' ? 'selected' : ''; ?>>Fixed-Term</option>
                        <option value="Probationary" <?php echo $employees[0]['employment_type'] === 'Probationary' ? 'selected' : ''; ?>>Probationary</option>
                        <option value="Part-Time" <?php echo $employees[0]['employment_type'] === 'Part-Time' ? 'selected' : ''; ?>>Part-Time</option>
                        <option value="Regular Part-Time" <?php echo $employees[0]['employment_type'] === 'Regular Part-Time' ? 'selected' : ''; ?>>Regular Part-Time</option>
                        <option value="Part-Time Permanent" <?php echo $employees[0]['employment_type'] === 'Part-Time Permanent' ? 'selected' : ''; ?>>Part-Time Permanent</option>
                        <option value="Self-Employment" <?php echo $employees[0]['employment_type'] === 'Self-Employment' ? 'selected' : ''; ?>>Self-Employment</option>
                        <option value="Freelance" <?php echo $employees[0]['employment_type'] === 'Freelance' ? 'selected' : ''; ?>>Freelance</option>
                        <option value="Internship" <?php echo $employees[0]['employment_type'] === 'Internship' ? 'selected' : ''; ?>>Internship</option>
                        <option value="Consultancy" <?php echo $employees[0]['employment_type'] === 'Consultancy' ? 'selected' : ''; ?>>Consultancy</option>
                        <option value="Apprenticeship" <?php echo $employees[0]['employment_type'] === 'Apprenticeship' ? 'selected' : ''; ?>>Apprenticeship</option>
                        <option value="Traineeship" <?php echo $employees[0]['employment_type'] === 'Traineeship' ? 'selected' : ''; ?>>Traineeship</option>
                        <option value="Gig" <?php echo $employees[0]['employment_type'] === 'Gig' ? 'selected' : ''; ?>>Gig</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date-of-hire" class="form-label">Date of Hire<span class="label-danger">(*)</span>:</label>
                    <input type="date" class="form-control" id="date-of-hire" required value='<?php echo $employees[0]['date_of_hire'];?>'>
                </div>
                <div class="col-md-6">
                    <label for="supervisor" class="form-label">Supervisor</label>
                    <select class="form-select selectize_supervisors" id="supervisor">
                        <option value="<?php
                        if(isset($employees[0]['supervisor_id'])){
                            echo $employees[0]['supervisor_id']; 
                        }
                        ?>" selected><?php 
                        if(isset($employees[0]['supervisor_id'])){
                            echo $employees[0]['supervisor_first_name'] . " " . $employees[0]['supervisor_last_name'];
                        }
                        ?> </option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="btn-group">
                    <label class="display-5 pe-4">Role*:</label>
                    <input class="btn-check" type="radio" name="role" id="role-staff" value="Staff" required <?php echo ($employees[0]['access_role'] == 'Staff') ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-primary" for="role-staff">Staff</label>
                    <input class="btn-check" type="radio" name="role" id="role-supervisor" value="Supervisor" <?php echo ($employees[0]['access_role'] == 'Supervisor') ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-primary" for="role-supervisor">Supervisor</label>
                    <input class="btn-check" type="radio" name="role" id="role-manager" value="Manager" <?php echo ($employees[0]['access_role'] == 'Manager') ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-primary" for="role-manager">Manager</label>
                    <input class="btn-check" type="radio" name="role" id="role-admin" value="Admin" <?php echo ($employees[0]['access_role'] == 'Admin') ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-primary" for="role-admin">Admin</label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 justify-content-end d-flex">
                    <button type="submit" class="btn btn-primary" id="contact_information_submit" onclick="nextForm(5, this)" data-form="employment_information">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /Employment Information Form -->
<!-- Pay Information Form -->
<div class="tab-pane fade" id="navs-pills-pay-information" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-credit-card bx-lg"></i>  Pay Information: (5/6)</h3>
        <form onsubmit="event.preventDefault()" id="pay_information">
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="payrollGroup" class="form-label">Select Payroll Group<span class="label-danger">(*)</span>:</label>
                    <select class="form-select" id="payrollGroup" required>
                        <option value="<?php echo $employees[0]['payroll_group_id']; ?>" selected>Select payroll group...</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="hourlyRate" class="form-label">Basic Salary (per month)<span class="label-danger">(*)</span>:</label>
                    <input 
                    type="number" 
                    id="hourlyRate" 
                    list="wageOptions2025" 
                    class="form-control no-spinners" 
                    placeholder="Enter hourly wage" 
                    value="<?php echo $employees[0]['basic_salary']; ?>" 
                    required 
                    onchange="samplePayroll()" 
                    min="1">
                    <datalist id="wageOptions2025">
                        <option value="14190">National Capital Region (₱14,190)</option>
                        <option value="10201">Cordillera Administrative Region (₱10,201)</option>
                        <option value="9421">Ilocos Region - Lower Range (₱9,421)</option>
                        <option value="10138">Ilocos Region - Upper Range (₱10,138)</option>
                        <option value="9938">Cagayan Valley - Lower Range (₱9,938)</option>
                        <option value="10368">Cagayan Valley - Upper Range (₱10,368)</option>
                        <option value="9913">Central Luzon - Lower Range (₱9,913)</option>
                        <option value="10000">Central Luzon - Upper Range (₱10,000)</option>
                        <option value="10201">CALABARZON - Lower Range (₱10,201)</option>
                        <option value="11273">CALABARZON - Upper Range (₱11,273)</option>
                        <option value="7116">MIMAROPA - Lower Range (₱7,116)</option>
                        <option value="7678">MIMAROPA - Upper Range (₱7,678)</option>
                        <option value="7905">Bicol Region (₱7,905)</option>
                        <option value="9773">Western Visayas - Lower Range (₱9,773)</option>
                        <option value="10833">Western Visayas - Upper Range (₱10,833)</option>
                        <option value="8753">Central Visayas - Lower Range (₱8,753)</option>
                        <option value="9421">Central Visayas - Upper Range (₱9,421)</option>
                        <option value="7478">Eastern Visayas - Lower Range (₱7,478)</option>
                        <option value="8125">Eastern Visayas - Upper Range (₱8,125)</option>
                        <option value="7329">Zamboanga Peninsula - Lower Range (₱7,329)</option>
                        <option value="7615">Zamboanga Peninsula - Upper Range (₱7,615)</option>
                        <option value="8385">Northern Mindanao - Lower Range (₱8,385)</option>
                        <option value="8708">Northern Mindanao - Upper Range (₱8,708)</option>
                        <option value="9468">Davao Region - Lower Range (₱9,468)</option>
                        <option value="9577">Davao Region - Upper Range (₱9,577)</option>
                        <option value="7973">SOCCSKSARGEN - Lower Range (₱7,973)</option>
                        <option value="8708">SOCCSKSARGEN - Upper Range (₱8,708)</option>
                        <option value="7583">Caraga - Lower Range (₱7,583)</option>
                        <option value="8708">Caraga - Upper Range (₱8,708)</option>
                        <option value="6844">Bangsamoro (₱6,844)</option>
                    </datalist>
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
                        <label for="bankName" class="form-label">Bank Name<span class="label-danger">(*)</span>:</label>
                        <input 
                        type="text" 
                        id="bankName" 
                        class="form-control" 
                        placeholder="Bank of the Philippine Islands (BPI)" 
                        value="<?php echo $employees[0]['bank_name']; ?>" 
                        required 
                        minlength="1" 
                        maxlength="50">
                    </div>
                    <div class="col-md-6">
                        <label for="branchName" class="form-label">Branch Name<span class="label-danger">(*)</span>:</label>
                        <input 
                        type="text" 
                        id="branchName" 
                        class="form-control" 
                        placeholder="Makati Main Branch" 
                        value="<?php echo $employees[0]['bank_branch_name']; ?>" 
                        required  
                        minlength="1" 
                        maxlength="50">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="accountNumber" class="form-label">Account Number<span class="label-danger">(*)</span>:</label>
                        <input 
                        type="text" 
                        id="accountNumber" 
                        class="form-control no-spinners" 
                        placeholder="Enter account number" 
                        value="<?php echo $employees[0]['bank_account_number']; ?>" 
                        required 
                        minlength="10" maxlength="16"
                        pattern="\d{10,16}" 
                        title="Account number must be between 10 to 16 digits" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="col-md-6">
                        <label for="accountType" class="form-label">Account Type<span class="label-danger">(*)</span>:</label>
                        <select id="accountType" class="form-control" placeholder="Enter account type" required>
                            <option value="" disabled>Select Account Type...</option>
                            <option value="Payroll Account" <?php echo ($employees[0]['bank_account_type'] == 'Payroll Account') ? 'selected' : ''; ?>>Payroll Account</option>
                            <option value="Current Account" <?php echo ($employees[0]['bank_account_type'] == 'Current Account') ? 'selected' : ''; ?>>Current Account</option>
                            <option value="Checking Account" <?php echo ($employees[0]['bank_account_type'] == 'Checking Account') ? 'selected' : ''; ?>>Checking Account</option>
                            <option value="Savings Account" <?php echo ($employees[0]['bank_account_type'] == 'Savings Account') ? 'selected' : ''; ?>>Savings Account</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 justify-content-end d-flex">
                        <button type="submit" class="btn btn-primary" id="pay_information_submit" onclick="nextForm(6, this)" data-form="pay_information">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /Pay Information Form -->
<!-- Government Information Form -->
<div class="tab-pane fade" id="navs-pills-government-information" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-id-card bx-lg"></i> Government Information: (6/6)</h3>
        <form onsubmit="event.preventDefault()" id="government-information">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tinNumber" class="form-label">TIN Number<span class="label-danger">(*)</span>:</label>
                    <input type="text" 
                    id="tinNumber" 
                    class="form-control" 
                    placeholder="123-456-789-000" 
                    required 
                    minlength="15" 
                    maxlength="15" 
                    pattern="\d{3}-\d{3}-\d{3}-\d{3}"
                    title="Format: 123-456-789-000 (15 digits with dashes)"
                    oninput="this.value = this.value.replace(/[^0-9-]/g, '')"
                    value="<?php echo $employees[0]['tin_number']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="SSSNumber" class="form-label">SSS Number<span class="label-danger">(*)</span>:</label>
                    <input 
                    type="text" 
                    id="SSSNumber" 
                    class="form-control"
                    placeholder="1234-5678901-2" 
                    required 
                    minlength="15" 
                    maxlength="15" 
                    pattern="\d{4}-\d{7}-\d{1}"
                    title="Format: 1234-5678901-2 (14 digits with dashes)"
                    oninput="this.value = this.value.replace(/[^0-9-]/g, '')"
                    value="<?php echo $employees[0]['sss_number']; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="PhilHealthNumber" class="form-label">PhilHealth Number<span class="label-danger">(*)</span>:</label>
                    <input 
                    type="text" 
                    id="PhilHealthNumber" 
                    class="form-control" 
                    placeholder="12-345678901-2" 
                    required 
                    minlength="14" 
                    maxlength="14" 
                    pattern="\d{2}-\d{9}-\d{1}"
                    title="Format: 12-345678901-2 (14 digits with dashes)"
                    oninput="this.value = this.value.replace(/[^0-9-]/g, '')"
                    value="<?php echo $employees[0]['philhealth_number']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="PagIBIGNumber" class="form-label">Pag-IBIG Number<span class="label-danger">(*)</span>:</label>
                    <input type="text" 
                    id="PagIBIGNumber" 
                    class="form-control" 
                    placeholder="1234-5678-9012" 
                    required 
                    minlength="14" 
                    maxlength="14" 
                    pattern="\d{4}-\d{4}-\d{4}"
                    title="Format: 1234-5678-9012 (14 digits with dashes)"
                    oninput="this.value = this.value.replace(/[^0-9-]/g, '')"
                    value="<?php echo $employees[0]['pagibig_fund_number']; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 justify-content-end d-flex">
                    <button 
                    type="submit" 
                    class="btn btn-primary" 
                    id="contact_information_submit" 
                    onclick="updateEmployee(this)" 
                    data-token="<?php echo $token; ?>">Finish</button>
                </div>
            </div>
        </form>
    </div>
    <style>
        .no-spinners::-webkit-outer-spin-button,
        .no-spinners::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .label-danger {
            color: red;
        }
    </style>
</div>
<!-- /Government Information Form -->

<div class="row mt-3">
    <div class="col-md-12 justify-content-end d-flex">
        <button type="button" class="btn btn-info" id="personal_info_submit" onclick="updateEmployee(this)" data-token="<?php echo $token; ?>"><i class="bx bx-edit-alt"></i>Update</button>
    </div>
</div>
