<div class="tab-pane fade show active" id="navs-pills-personal-information" role="tabpanel">
    <!-- Form -->
    <div class="form-container p-4">
    <h3 class="form-title">Personal Information: (1/6)</h3>
    <form onsubmit="event.preventDefault()" id="personal_information">
        <div class="row mb-3">
        <div class="col-md-4">
            <label for="firstName" class="form-label">First Name*</label>
            <input type="text" class="form-control" id="firstName" placeholder="First Name" required>
        </div>
        <div class="col-md-4">
            <label for="middleName" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middleName" placeholder="Middle Name" required>
        </div>
        <div class="col-md-4">
            <label for="lastName" class="form-label">Last Name*</label>
            <input type="text" class="form-control" id="lastName" placeholder="Last Name" required>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-4">
            <label for="dob" class="form-label">Date of Birth*</label>
            <input type="date" class="form-control" id="dob" required>
        </div>
        <div class="col-md-4">
            <label for="gender" class="form-label">Gender*</label>
            <select id="gender" class="form-select" required>
                <option value="" selected disabled>Choose...</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="maritalStatus" class="form-label">Marital Status*</label>
            <select id="maritalStatus" class="form-select" required>
                <option value="" selected disabled>Choose...</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Divorced">Divorced</option>
                <option value="Widowed">Widowed</option>
            </select>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="nationality" class="form-label">Nationality*</label>
            <input type="text" class="form-control" id="nationality" placeholder="Nationality" required>
        </div>
        <div class="col-md-6">
            <label for="religion" class="form-label">Religion</label>
            <input type="text" class="form-control" id="religion" placeholder="Religion">
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
<div class="tab-pane fade" id="navs-pills-login-credentials" role="tabpanel">
    <div class="form-container p-4">
    <h3 class="form-title">Login Credentials: (2/6)</h3>
    <form onsubmit="event.preventDefault()" id="login_credentials">
        <div class="mb-3">
        <label for="username" class="form-label">Username*:</label>
        <input type="text" class="form-control" id="username" placeholder="Enter your username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password*:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
        </div>
        <div class="row mb-3">
        <div class="col-md-12 justify-content-end d-flex">
            <button type="submit" class="btn btn-primary" id="login_credentials_submit" onclick="nextForm(3, this)" data-form="login_credentials">Submit</button>
        </div>
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
            <input type="text" class="form-control" id="phone" placeholder="Enter phone number" required>
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Email Address*</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email address" required>
        </div>
        </div>
        <div class="mb-3">
        <label for="address" class="form-label">Address*</label>
        <textarea class="form-control" id="address" placeholder="Enter address" required></textarea>
        </div>

        <h3 class="form-title">Emergency Contact Information:</h3>
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="emergency-name" class="form-label">Name*</label>
            <input type="text" class="form-control" id="emergency-name" placeholder="Enter name" required>
        </div>
        <div class="col-md-6">
            <label for="relationship" class="form-label">Relationship*</label>
            <input type="text" class="form-control" id="relationship" placeholder="Enter relationship" required>
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-6">
            <label for="emergency-phone" class="form-label">Phone Number*</label>
            <input type="text" class="form-control" id="emergency-phone" placeholder="Enter phone number" required>
        </div>
        <div class="col-md-6">
            <label for="emergency-email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="emergency-email" placeholder="Enter email address">
        </div>
        </div>
        <div class="mb-3">
        <label for="emergency-address" class="form-label">Address</label>
        <input type="text" class="form-control" id="emergency-address" placeholder="Enter address">
        </div>
        <div class="row mb-3">
        <div class="col-md-12 justify-content-end d-flex">
            <button type="submit" class="btn btn-primary" id="contact_information_submit" onclick="nextForm(4, this)" data-form="contact_information">Submit</button>
        </div>
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
            <input type="text" class="form-control" id="rfid" placeholder="Enter RFID Tag" required>
        </div>
        <div class="col-md-6">
            <label for="employee-code" class="form-label">Employee Code*</label>
            <input type="text" class="form-control" id="employee-code" placeholder="Enter Employee Code" readonly value="Auto-generated">
        </div>
        </div>
        <div class="row mb-3">
        <div class="col-md-4">
            <label for="job-title" class="form-label">Job Title*</label>
            <select class="form-select selectize_job_title" id="job-title" name="job-title">
            </select>
        </div>
        <div class="col-md-4">
            <label for="department" class="form-label">Department*</label>
            <select class="form-select selectize_department" id="department" name="departments">
            </select>
        </div>
        <div class="col-md-4">
            <label for="employment-type" class="form-label">Employment Type*</label>
            <select class="form-select" id="employment-type" required>
                <option value="" selected disabled>Select Type</option>
                <option value="Regular">Regular</option>
                <option value="Regular Permanent">Regular Permanent</option>
                <option value="Casual">Casual</option>
                <option value="Contractual">Contractual</option>
                <option value="Project-Based">Project-Based</option>
                <option value="Seasonal">Seasonal</option>
                <option value="Fixed-Term">Fixed-Term</option>
                <option value="Probationary">Probationary</option>
                <option value="Part-Time">Part-Time</option>
                <option value="Regular Part-Time">Regular Part-Time</option>
                <option value="Part-Time Permanent">Part-Time Permanent</option>
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
            <input type="date" class="form-control" id="date-of-hire" required>
        </div>
        <div class="col-md-6">
            <label for="supervisor" class="form-label">Supervisor</label>
            <select class="form-select selectize_supervisors" id="supervisor">
            </select>
        </div>
        </div>
        <div class="row mb-3">
            <div class="btn-group">
                <label class="display-5 pe-4">Role*:</label>
                <input class="btn-check" type="radio" name="role" id="role-staff" value="Staff">
                <label class="btn btn-outline-primary" for="role-staff">Staff</label>
                <input class="btn-check" type="radio" name="role" id="role-supervisor" value="Supervisor">
                <label class="btn btn-outline-primary" for="role-supervisor">Supervisor</label>
                <input class="btn-check" type="radio" name="role" id="role-manager" value="Manager">
                <label class="btn btn-outline-primary" for="role-manager">Manager</label>
                <input class="btn-check" type="radio" name="role" id="role-admin" value="Admin">
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
<div class="tab-pane fade" id="navs-pills-pay-information" role="tabpanel">
    <div class="form-container p-4">
    <h3 class="form-title">Pay Information: (5/6)</h3>
    <form onsubmit="event.preventDefault()" id="pay_information">
        <div class="row mb-4">
        <div class="col-md-4">
            <label for="payrollGroup" class="form-label">Select Payroll Group*:</label>
            <select class="form-select" id="payrollGroup" required>
                <option value="" disabled selected>Select payroll group...</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="hourlyRate" class="form-label">Basic Salary (per month)*:</label>
            <input type="number" id="hourlyRate" class="form-control" placeholder="Enter hourly wage" required onchange="samplePayroll()">
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
                <input type="text" id="bankName" class="form-control" placeholder="Enter bank name" required>
            </div>
            <div class="col-md-6">
                <label for="branchName" class="form-label">Branch Name*:</label>
                <input type="text" id="branchName" class="form-control" placeholder="Enter branch name" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="accountNumber" class="form-label">Account Number*:</label>
                <input type="number" id="accountNumber" class="form-select" placeholder="Enter account number" required>
            </div>
            <div class="col-md-6">
                <label for="accountType" class="form-label">Account Type*:</label>
                <select id="accountType" class="form-control" placeholder="Enter account type" value="">
                    <option value="" disabled selected>Select Payroll Account</option>
                    <option value="Payroll Account">Payroll Account</option>
                    <option value="Current Account">Current Account</option>
                    <option value="Checking Account">Checking Account</option>
                    <option value="Savings Account">Savings Account</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 justify-content-end d-flex">
                <button type="submit" class="btn btn-primary" id="contact_information_submit" onclick="nextForm(6, this)" data-form="pay_information">Submit</button>
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
            <input type="number" id="tinNumber" class="form-control no-spinners" placeholder="Enter TIN Number" required>
            </div>
            <div class="col-md-6">
            <label for="SSSNumber" class="form-label">SSS Number*:</label>
            <input type="number" id="SSSNumber" class="form-control no-spinners" placeholder="Enter SSS Number" required>
            </div>
            
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
            <label for="PhilHealthNumber" class="form-label">PhilHealth Number*:</label>
            <input type="number" id="PhilHealthNumber" class="form-control no-spinners" placeholder="Enter PhilHealth Number" required>
            </div>
            <div class="col-md-6">
            <label for="PagIBIGNumber" class="form-label">Pag-IBIG Number*:</label>
            <input type="number" id="PagIBIGNumber" class="form-control no-spinners" placeholder="Enter Pag-IBIG Number" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 justify-content-end d-flex">
                <button type="submit" class="btn btn-primary" id="contact_information_submit" onclick="createEmployee()">Finish</button>
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
    </style>
</div>