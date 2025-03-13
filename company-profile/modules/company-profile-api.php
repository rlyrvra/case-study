<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../CompanyProfileDao.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

try {
    $companyProfileDao = new CompanyProfileDao($pdo);
    $action = $_POST['action'] ?? '';
    if($action === 'fetchAll'){
        $selectedCompanyInformation = new CompanyInformation();
        $selectedCompanyInformation->setId(1);
        $filterCriteria = [
            [
                "column" => "id", 
                "operator" => "=", 
                "value" => $selectedCompanyInformation->getId()
            ]
        ];
        $result = $companyProfileDao->fetchCompanyInformation([], $filterCriteria);
        if($result === ActionResult::FAILURE){
            die("Failed retrieving data.");
            return;
        }
        return;
    }

    if($action === 'update'){
        $companyData = $_POST['company_profile'] ?? null;
        if (!isset($_POST['company_profile'])) {
            echo "company_profile is not set.";
            return;
        }
        
        
        $companyData = json_decode($_POST['company_profile'], true);
        
        if ($companyData === null && json_last_error() !== JSON_ERROR_NONE) {
            echo "JSON Decode Error: " . json_last_error_msg();
        } else {

        }
        $updatedCompanyInformation = new CompanyInformation();
        // Call function with the file array
        $uploadedFilePath = uploadImgToServer($_FILES['company_logo']);
        
        $updatedCompanyInformation->img_location = !empty($uploadedFilePath) ? $uploadedFilePath : ($companyData['img_location'] ?? null);

        switch($updatedCompanyInformation->img_location){
            case "error":
                $errorMessage = "An error has occurred. Please try again.";
                die("
                <script>
                    showImageError($errorMessage);
                </script>
                ");
                return;
                break;
            case "invalid":
                $errorMessage = "File is invalid. Allowed extensions are (.jpg, .jpeg) only.";
                die("
                <script>
                    showImageError($errorMessage);
                </script>
                ");
                return;
                break;
            case "size_limit":
                $errorMessage = "File is above size limit. (Up to 2MB)";
                die("
                <script>
                    showImageError($errorMessage);
                </script>
                ");
                return;
                break;
            case "upload_fail":
                $errorMessage = "Uploading failed. Please try again.";
                die("
                <script>
                    showImageError($errorMessage);
                </script>
                ");
                return;
                break;
            default:
                //do nothing
                break;
        }

        $updatedCompanyInformation->setId(1);
        $updatedCompanyInformation->name = isset($companyData['name']) && $companyData['name'] !== '' ? $companyData['name'] : null;
        $updatedCompanyInformation->date_established = isset($companyData['date_established']) && $companyData['date_established'] !== '' ? $companyData['date_established'] : null;
        $updatedCompanyInformation->history = isset($companyData['history']) && $companyData['history'] !== '' ? $companyData['history'] : null;
        $updatedCompanyInformation->industry = isset($companyData['industry']) && $companyData['industry'] !== '' ? $companyData['industry'] : null;
        $updatedCompanyInformation->business_type = isset($companyData['business_type']) && $companyData['business_type'] !== '' ? $companyData['business_type'] : null;
        $updatedCompanyInformation->size = isset($companyData['company_size']) && $companyData['company_size'] !== '' ? $companyData['company_size'] : null;
        $updatedCompanyInformation->employee_count = isset($companyData['employee_count']) && $companyData['employee_count'] !== '' ? $companyData['employee_count'] : null;
        $updatedCompanyInformation->address = isset($companyData['address']) && $companyData['address'] !== '' ? $companyData['address'] : null;
        $updatedCompanyInformation->phone = isset($companyData['phone']) && $companyData['phone'] !== '' ? $companyData['phone'] : null;
        $updatedCompanyInformation->email = isset($companyData['email']) && $companyData['email'] !== '' ? $companyData['email'] : null;
        $updatedCompanyInformation->website = isset($companyData['website']) && $companyData['website'] !== '' ? $companyData['website'] : null;
        $updatedCompanyInformation->mission = isset($companyData['mission']) && $companyData['mission'] !== '' ? $companyData['mission'] : null;
        $updatedCompanyInformation->vision = isset($companyData['vision']) && $companyData['vision'] !== '' ? $companyData['vision'] : null;
        $updatedCompanyInformation->company_values = isset($companyData['company_values']) && $companyData['company_values'] !== '' ? $companyData['company_values'] : null;
        $updatedCompanyInformation->policies = isset($companyData['policies']) && $companyData['policies'] !== '' ? $companyData['policies'] : null;
        $updatedCompanyInformation->compliance = isset($companyData['compliance']) && $companyData['compliance'] !== '' ? $companyData['compliance'] : null;
        $updatedCompanyInformation->notes = isset($companyData['notes']) && $companyData['notes'] !== '' ? $companyData['notes'] : null;



        $filterCriteria = [
            [
                "column" => "id", 
                "operator" => "=", 
                "value" => $updatedCompanyInformation->getId()
            ]
        ];
        $result = $companyProfileDao->updateCompanyInformation($updatedCompanyInformation, $filterCriteria);
        if($result === ActionResult::FAILURE){
            die("Failed updating data.");
            return;
        }
        if($result === ActionResult::SUCCESS){
            die("
            <script>
                showSuccessUpdate();
            </script>
            ");
            return;
        }
        return;
    }

    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

function uploadImgToServer(array $file): string {
    $uploadDir = realpath(__DIR__ . '/../../uploads') . DIRECTORY_SEPARATOR; 

    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Allowed file extensions
    $allowedExtensions = ['jpg', 'jpeg'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB

    // Check if file is provided and valid
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return "error"; // Return empty string if no file uploaded or an error occurred
    }

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validate file extension
    if (!in_array($fileExtension, $allowedExtensions)) {
        return "invalid"; // Return empty string on invalid file type
    }

    // Validate file size
    if ($fileSize > $maxFileSize) {
        return "size_limit"; // Return empty string if file size exceeds limit
    }

    // Define new filename
    $newFileName = "company_logo." . $fileExtension;
    $uploadFilePath = $uploadDir . $newFileName;

    // Delete any existing company logo files
    foreach (glob($uploadDir . "company_logo.*") as $existingFile) {
        unlink($existingFile);
    }

    // Move uploaded file to the destination
    if (move_uploaded_file($fileTmpName, $uploadFilePath)) {
        return $uploadFilePath; // Return the uploaded file path
    }

    return "upload_fail"; // Return empty string if file upload fails
}


// $companyData = [
//     'name' => 'Tech Innovators Inc.',
//     'date_established' => '2005-08-15',
//     'history' => 'Founded in 2005, Tech Innovators Inc. started as a small startup focused on AI development.',
//     'industry' => 'Technology',
//     'business_type' => 'Private',
//     'size' => 'Medium',
//     'employee_count' => 250,
//     'address' => '123 Innovation Drive, Silicon Valley, CA',
//     'phone' => '+1 (415) 555-1234',
//     'email' => 'info@techinnovators.com',
//     'website' => 'https://www.techinnovators.com',
//     'mission' => 'To revolutionize AI solutions for businesses worldwide.',
//     'vision' => 'A future where AI enhances human potential in every industry.',
//     'company_values' => 'Innovation, Integrity, Collaboration',
//     'policies' => 'Remote Work Policy, Data Privacy Policy, Ethical AI Policy',
//     'compliance' => 'ISO 27001, GDPR, HIPAA',
//     'notes' => 'Recently expanded operations to Europe and Asia.',
// ];