<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../company-profile/CompanyProfileDao.php';

session_start();
$companyProfileDao = new CompanyProfileDao($pdo);
$companyProfileData;
try {
    $selectedCompanyInfo = new CompanyInformation();
    $selectedCompanyInfo->setId(1);
    $selectedCompanyInfo->name = "s";
    $selectedCompanyInfo->date_established = "s";
    $selectedCompanyInfo->img_location = "s";
    $selectedCompanyInfo->business_type = "s";
    $selectedCompanyInfo->industry = "s";
    $selectedCompanyInfo->address = "s";
    $selectedCompanyInfo->phone = "s";
    $selectedCompanyInfo->email = "s";
    $selectedCompanyInfo->website = "s";
    $companyProfileFilterCriteria = [
        [
            "column" => "id", 
            "operator" => "=", 
            "value" => $selectedCompanyInfo->getId()
        ]
    ];
    $companyProfileData = $companyProfileDao->fetchCompanyInformation($selectedCompanyInfo, $companyProfileFilterCriteria);
    if ($companyProfileData === ActionResult::FAILURE){
        echo "Fail to fetch Company Information";
        return;
    }
} catch(Exception $e){
    echo "Error: " . $e->getMessage();
}

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'Helvetica');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

ob_start();
if(isset($type) && $type === 'Records') include __DIR__ . '/department-pdf-records-template.php';
else if(isset($type) && $type === 'Department + Job Title')  include __DIR__ . '/department-pdf-department_job_title-template.php';
else if(isset($type) && $type === 'Department + Job Title + Employees') include __DIR__ . '/department-pdf-department_job_title_employees-template.php';
$html = ob_get_clean();

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("department-records.pdf", ["Attachment" => false]);
exit;

