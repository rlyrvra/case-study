function updateEmployee(button){
    let employeeData = {};
    //form 1
    const row = button;  // Get the closest row
    const token = row.getAttribute('data-token');
    const firstName = document.getElementById("firstName").value;
    const middleName = document.getElementById("middleName").value;
    const lastName = document.getElementById("lastName").value;
    const dob = document.getElementById("dob").value;
    const gender = document.getElementById("gender").value;
    const maritalStatus = document.getElementById("maritalStatus").value;
    const nationality = document.getElementById("nationality").value;
    const religion = document.getElementById("religion").value;
    const profilePicture = document.getElementById("profilePicture");
    const profilePictureRaw = profilePicture.files[0];
    function getBase64Image(profilePictureRaw) {
        return new Promise((resolve, reject) => {
            if (profilePictureRaw) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    resolve(e.target.result.split(',')[1]); // Return base64 string
                };
                reader.onerror = reject; // Handle any errors
                reader.readAsDataURL(profilePictureRaw); // Start reading file
            } else {
                resolve(null); // Return null if no file is provided
            }
        });
    }

    //form 2
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;


    //form 3
    const phone = document.getElementById("phone").value;
    const email = document.getElementById("email").value;
    const address = document.getElementById("address").value;
    const emergencyName = document.getElementById("emergency-name").value;
    const relationship = document.getElementById("relationship").value;
    const emergencyPhone = document.getElementById("emergency-phone").value;
    const emergencyEmail = document.getElementById("emergency-email").value;
    const emergencyAddress = document.getElementById("emergency-address").value;

    //form 4
    const rfid = document.getElementById("rfid").value;
    const employmentType = document.getElementById("employment-type").value;
    const jobTitle = document.getElementById("job-title").value;
    const department = document.getElementById("department").value;
    const dateOfHire = document.getElementById("date-of-hire").value;
    const supervisor = document.getElementById("supervisor").value;
    var accessRole;
    document.querySelectorAll('input[name="role"]').forEach((radio) => {
        accessRole = document.querySelector('input[name="role"]:checked').value;
    });

    //form 5
    const payrollGroup = document.getElementById("payrollGroup").value;
    const hourlyRate = document.getElementById("hourlyRate").value;
    const bankName = document.getElementById("bankName").value;
    const branchName = document.getElementById("branchName").value;
    const bankAccountNumber = document.getElementById("accountNumber").value;
    const bankAccountType = document.getElementById("accountType").value;

    //form 6
    const tinNumber = document.getElementById("tinNumber").value;
    const SSSNumber = document.getElementById("SSSNumber").value;
    const PhilHealthNumber = document.getElementById("PhilHealthNumber").value;
    const PagIBIGNumber = document.getElementById("PagIBIGNumber").value;

    async function handleData() {
        let imageData;
        if (profilePictureRaw) {
            imageData = await getBase64Image(profilePictureRaw); // Wait for base64 conversion
        } else if (!profilePictureRaw && document.getElementById("profileImage").getAttribute('data-img') !== null) {
            imageData = document.getElementById("profileImage").getAttribute('data-img');
        }
    
        // After imageData is set, construct employeeData
        const employeeData = {
            //form 1
            token: token,
            first_name: firstName,
            middle_name: middleName,
            last_name: lastName,
            date_of_birth: dob,
            gender: gender,
            marital_status: maritalStatus,
            nationality: nationality,
            religion: religion,
            profile_picture: imageData,
            //form 2
            username: username,
            password: password,
            //form 3
            phone: phone,
            email: email,
            address: address,
            emergency_name: emergencyName,
            emergency_relationship: relationship,
            emergency_phone: emergencyPhone,
            emergency_email: emergencyEmail,
            emergency_address: emergencyAddress,
            //form 4
            rfid: rfid,
            employment_type: employmentType,
            job_title_id: jobTitle,
            department_id: department,
            date_of_hire: dateOfHire,
            supervisor: supervisor,
            access_role: accessRole,
            //form 5
            payroll_group_id: payrollGroup,
            hourly_rate: hourlyRate,
            branch_name: branchName,
            bank_name: bankName,
            bank_account_number: bankAccountNumber,
            bank_account_type: bankAccountType,
            //form 6
            tin_number: tinNumber,
            sss_number: SSSNumber,
            philhealth_number: PhilHealthNumber,
            pagibig_number: PagIBIGNumber
        };
        
        console.log(employeeData);
    
        
        // const employeeData1 = {
        //     username: username,
        //     password: password,
        // };

        // console.log(employeeData1);
    
        // const employeeData2 = {
        //     phone: phone,
        //     email: email,
        //     address: address,
        //     emergency_name: emergencyName,
        //     emergency_relationship: relationship,
        //     emergency_phone: emergencyPhone,
        //     emergency_email: emergencyEmail,
        //     emergency_address: emergencyAddress,
        // };
        
        // console.log(employeeData2);
    
        // const employeeData3 = {
        //     rfid: rfid,
        //     job_title_id: jobTitle,
        //     department_id: department,
        //     date_of_hire: dateOfHire,
        //     supervisor: supervisor,
        //     access_role: accessRole
        // };
        
        // console.log(employeeData3);
    
    
        // const employeeData4 = {
        //     payroll_group_id: payrollGroup,
        //     hourly_rate: hourlyRate,
        //     bank_name: bankName,
        //     bank_account_number: bankAccountNumber,
        //     bank_account_type: bankAccountType
        // };
    
        // console.log(employeeData4);
    
    
        // const employeeData5 = {
        //     tin_number: tinNumber,
        //     sss_number: SSSNumber,
        //     philhealth_number: PhilHealthNumber,
        //     pagibig_number: PagIBIGNumber
        // };
    
        // console.log(employeeData5);
        
        

        $.ajax({
            url: 'employees/modules/add-employee-api',
            type: 'POST',
            data: {
                action: 'update',
                employeeData: employeeData,
                md5_id: employeeData.token
            },
            success: function(response) {
                $('#response-test').html(response);
                //showSuccessUpdate(employeeData.token);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX Error: " + textStatus + ": " + errorThrown);
            }
        });
    }
    handleData();
    
    return;
    
    
}

function createEmployee(){
    let employeeData = {};
    //form 1
    const firstName = document.getElementById("firstName").value;
    const middleName = document.getElementById("middleName").value;
    const lastName = document.getElementById("lastName").value;
    const dob = document.getElementById("dob").value;
    const gender = document.getElementById("gender").value;
    const maritalStatus = document.getElementById("maritalStatus").value;
    const nationality = document.getElementById("nationality").value;
    const religion = document.getElementById("religion").value;
    const profilePicture = document.getElementById("profilePicture");
    const profilePictureRaw = profilePicture.files[0];
    function getBase64Image(profilePictureRaw) {
        return new Promise((resolve, reject) => {
            if (profilePictureRaw) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    resolve(e.target.result.split(',')[1]); // Return base64 string
                };
                reader.onerror = reject; // Handle any errors
                reader.readAsDataURL(profilePictureRaw); // Start reading file
            } else {
                resolve(null); // Return null if no file is provided
            }
        });
    }

    //form 2
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;


    //form 3
    const phone = document.getElementById("phone").value;
    const email = document.getElementById("email").value;
    const address = document.getElementById("address").value;
    const emergencyName = document.getElementById("emergency-name").value;
    const relationship = document.getElementById("relationship").value;
    const emergencyPhone = document.getElementById("emergency-phone").value;
    const emergencyEmail = document.getElementById("emergency-email").value;
    const emergencyAddress = document.getElementById("emergency-address").value;

    //form 4
    const rfid = document.getElementById("rfid").value;
    const employmentType = document.getElementById("employment-type").value;
    const jobTitle = document.getElementById("job-title").value;
    const department = document.getElementById("department").value;
    const dateOfHire = document.getElementById("date-of-hire").value;
    const supervisor = document.getElementById("supervisor").value;
    var accessRole;
    document.querySelectorAll('input[name="role"]').forEach((radio) => {
        accessRole = document.querySelector('input[name="role"]:checked').value;
    });

    //form 5
    const payrollGroup = document.getElementById("payrollGroup").value;
    const hourlyRate = document.getElementById("hourlyRate").value;
    const bankName = document.getElementById("bankName").value;
    const branchName = document.getElementById("branchName").value;
    const bankAccountNumber = document.getElementById("accountNumber").value;
    const bankAccountType = document.getElementById("accountType").value;

    //form 6
    const tinNumber = document.getElementById("tinNumber").value;
    const SSSNumber = document.getElementById("SSSNumber").value;
    const PhilHealthNumber = document.getElementById("PhilHealthNumber").value;
    const PagIBIGNumber = document.getElementById("PagIBIGNumber").value;

    async function handleData() {
        let imageData;
        if (profilePictureRaw) {
            imageData = await getBase64Image(profilePictureRaw); // Wait for base64 conversion
        } else if (!profilePictureRaw && document.getElementById("profileImage").getAttribute('data-img') !== null) {
            imageData = document.getElementById("profileImage").getAttribute('data-img');
        }
    
        // After imageData is set, construct employeeData
        const employeeData = {
            //form 1
            first_name: firstName,
            middle_name: middleName,
            last_name: lastName,
            date_of_birth: dob,
            gender: gender,
            marital_status: maritalStatus,
            nationality: nationality,
            religion: religion,
            profile_picture: imageData,
            //form 2
            username: username,
            password: password,
            //form 3
            phone: phone,
            email: email,
            address: address,
            emergency_name: emergencyName,
            emergency_relationship: relationship,
            emergency_phone: emergencyPhone,
            emergency_email: emergencyEmail,
            emergency_address: emergencyAddress,
            //form 4
            rfid: rfid,
            employment_type: employmentType,
            job_title_id: jobTitle,
            department_id: department,
            date_of_hire: dateOfHire,
            supervisor: supervisor,
            access_role: accessRole,
            //form 5
            payroll_group_id: payrollGroup,
            hourly_rate: hourlyRate,
            branch_name: branchName,
            bank_name: bankName,
            bank_account_number: bankAccountNumber,
            bank_account_type: bankAccountType,
            //form 6
            tin_number: tinNumber,
            sss_number: SSSNumber,
            philhealth_number: PhilHealthNumber,
            pagibig_number: PagIBIGNumber
        };
        
        //console.log(employeeData);
    
        
        // const employeeData1 = {
        //     username: username,
        //     password: password,
        // };

        // console.log(employeeData1);
    
        // const employeeData2 = {
        //     phone: phone,
        //     email: email,
        //     address: address,
        //     emergency_name: emergencyName,
        //     emergency_relationship: relationship,
        //     emergency_phone: emergencyPhone,
        //     emergency_email: emergencyEmail,
        //     emergency_address: emergencyAddress,
        // };
        
        // console.log(employeeData2);
    
        // const employeeData3 = {
        //     rfid: rfid,
        //     job_title_id: jobTitle,
        //     department_id: department,
        //     date_of_hire: dateOfHire,
        //     supervisor: supervisor,
        //     access_role: accessRole
        // };
        
        // console.log(employeeData3);
    
    
        // const employeeData4 = {
        //     payroll_group_id: payrollGroup,
        //     hourly_rate: hourlyRate,
        //     bank_name: bankName,
        //     bank_account_number: bankAccountNumber,
        //     bank_account_type: bankAccountType
        // };
    
        // console.log(employeeData4);
    
    
        // const employeeData5 = {
        //     tin_number: tinNumber,
        //     sss_number: SSSNumber,
        //     philhealth_number: PhilHealthNumber,
        //     pagibig_number: PagIBIGNumber
        // };
    
        // console.log(employeeData5);
        

        $.ajax({
            url: 'employees/modules/add-employee-api',
            type: 'POST',
            data: {
                action: 'create',
                employeeData: employeeData,
            },
            success: function(response) {
                $('#response-test').html(response);
                //showSuccessUpdate(employeeData.token);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX Error: " + textStatus + ": " + errorThrown);
            }
        });
    }
    handleData();
    
    return;
    
    
}