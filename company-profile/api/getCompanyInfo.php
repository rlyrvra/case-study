<?php
require_once __DIR__ . '/../../includes/enums/ActionResult.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php' ;
require __DIR__ . '/../aggregates/CompanyInformation.php';
require __DIR__ . '/../CompanyProfile.php';



require __DIR__ . '/../../database/database.php';
// api.php
if (!isset($_POST['action'])) {
    return;
}
$action = $_POST['action'];
if ($action === 'updateInfo') {

    // data to be passed to companyProfile
    $companyInfo = new CompanyInformation(
        $_POST['company_info']['location'], 
        $_POST['company_info']['industry'],
        $_POST['company_info']['business_type'],
        $_POST['company_info']['size'],
        $_POST['company_info']['history']
    );

    $companyProfile = new CompanyProfile($pdo);
    if(!$companyProfile->updateCompanyInformation($companyInfo) == ActionResult::SUCCESS){
        return;
    }
    
}
