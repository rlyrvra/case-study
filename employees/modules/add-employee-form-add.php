<style>.label-danger{color:red !important;}</style>
<!-- Personal Information Form -->
<div class="card shadow-sm border-0 tab-pane fade show active" id="navs-pills-personal-information" role="tabpanel">
    <div class="form-container p-4">
        <h3 class="form-title"><i class="bx bx-user-circle bx-lg"></i>  Personal Information: (1/6)</h3>
        <form onsubmit="event.preventDefault()" id="personal_information">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="firstName" class="form-label">First Name<span class="label-danger">*</span>:</label>
                    <input type="text" 
                    class="form-control" 
                    id="firstName" 
                    placeholder="John" 
                    required 
                    minlength="1" 
                    maxlength="30"
                    pattern="^[A-Za-z\s]+$" 
                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                    title="Only letters and spaces allowed">
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
                    title="Only letters and spaces allowed">
                </div>
                <div class="col-md-4">
                    <label for="lastName" class="form-label">Last Name<span class="label-danger">*</span>:</label>
                    <input type="text" 
                    class="form-control" 
                    id="lastName" 
                    placeholder="Doe" 
                    required 
                    minlength="1" 
                    maxlength="30"
                    pattern="^[A-Za-z\s]+$" 
                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                    title="Only letters and spaces allowed">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="dob" class="form-label">Date of Birth<span class="label-danger">*</span>:</label>
                    <input type="date" class="form-control" id="dob" required 
                    oninput="this.setAttribute('max', new Date().toISOString().split('T')[0])">
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
                    <label for="maritalStatus" class="form-label">Marital Status<span class="label-danger">*</span>:</label>
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
                    <label for="nationality" class="form-label">Nationality<span class="label-danger">*</span>:</label>
                    <input type="text" 
                    class="form-control" 
                    list="nationalityList" 
                    id="nationality" 
                    placeholder="Nationality" 
                    required
                    pattern="^[A-Za-z\s]+$" 
                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                    title="Only letters and spaces allowed">
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
                    title="Only letters and spaces allowed">
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
                        required 
                        oninput="validateConfirmPassword()"
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
                    maxlength="15">
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
                    maxlength="255">
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
                maxlength="255"></textarea>
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
                    title="Only letters and spaces allowed">
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
                    maxlength="30">
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
                    title="Only numbers, dashes, and plus sign allowed">
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
                    maxlength="255">
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
                maxlength="255"></textarea>
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
                        <input 
                        type="text" 
                        class="form-control" 
                        id="rfid" 
                        placeholder="Scan your RFID tag" 
                        required 
                        readonly>
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
                    <input 
                    type="text" 
                    class="form-control" 
                    id="employee-code" 
                    placeholder="Enter Employee Code" 
                    readonly 
                    value="Auto-generated">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="job-title" class="form-label">Job Title<span class="label-danger">(*)</span>:</label>
                    <select 
                    class="form-select selectize_job_title" 
                    id="job-title" 
                    name="job-title"
                    required>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="department" class="form-label">Department<span class="label-danger">(*)</span>:</label>
                    <select 
                    class="form-select selectize_department" 
                    id="department" 
                    name="departments"
                    required>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="employment-type" class="form-label">Employment Type<span class="label-danger">(*)</span>:</label>
                    <select 
                    class="form-select" 
                    id="employment-type" 
                    required>
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
                    <label for="date-of-hire" class="form-label">Date of Hire<span class="label-danger">(*)</span>:</label>
                    <input 
                    type="date" 
                    class="form-control" 
                    id="date-of-hire" 
                    required>
                </div>
                <div class="col-md-6">
                    <label for="supervisor" class="form-label">Supervisor</label>
                    <select 
                    class="form-select selectize_supervisors" 
                    id="supervisor">
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="btn-group">
                    <label class="display-5 pe-4">Role*:</label>
                    <input class="btn-check" type="radio" name="role" id="role-staff" value="Staff" required>
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
                        <option value="" disabled selected>Select payroll group...</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="hourlyRate" class="form-label">Basic Salary (per month)<span class="label-danger">(*)</span>:</label>
                    <input 
                    type="number" 
                    id="hourlyRate" 
                    list="wageOptions2025" 
                    class="form-control no-spinners" 
                    placeholder="Enter basic salary" 
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
                        required 
                        minlength="10" maxlength="16"
                        pattern="\d{10,16}" 
                        title="Account number must be between 10 to 16 digits" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    <div class="col-md-6">
                        <label for="accountType" class="form-label">Account Type<span class="label-danger">(*)</span>:</label>
                        <select id="accountType" class="form-control" placeholder="Enter account type" value="" required>
                            <option value="" disabled selected>Select Account Type...</option>
                            <option value="Payroll Account">Payroll Account</option>
                            <option value="Current Account">Current Account</option>
                            <option value="Checking Account">Checking Account</option>
                            <option value="Savings Account">Savings Account</option>
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
                    oninput="this.value = this.value.replace(/[^0-9-]/g, '')">
                </div>
                <div class="col-md-6">
                    <label for="SSSNumber" class="form-label">SSS Number<span class="label-danger">(*)</span>:</label>
                    <input 
                    type="text" 
                    id="SSSNumber" 
                    class="form-control"
                    placeholder="1234-5678901-2" 
                    required 
                    minlength="14" 
                    maxlength="14" 
                    pattern="\d{4}-\d{7}-\d{1}"
                    title="Format: 1234-5678901-2 (14 digits with dashes)"
                    oninput="this.value = this.value.replace(/[^0-9-]/g, '')">
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
                    oninput="this.value = this.value.replace(/[^0-9-]/g, '')">
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
                    oninput="this.value = this.value.replace(/[^0-9-]/g, '')">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 justify-content-end d-flex">
                    <button 
                    type="submit" 
                    class="btn btn-primary" 
                    id="contact_information_submit" 
                    onclick="createEmployee()">Finish</button>
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