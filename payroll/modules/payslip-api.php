<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../../payroll/PayslipService.php';
require_once __DIR__ . '/../../departments/DepartmentService.php';
require_once __DIR__ . '/../../employees/EmployeeService.php';
require_once __DIR__ . '/../../company-profile/CompanyProfileDao.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../database/database.php';


try {
    $payslipDao = new PayslipDao($pdo);
    $employeeDao = new EmployeeDao($pdo);
    $employeeRepo = new EmployeeRepository($employeeDao);
    $employeeService = new EmployeeService($employeeRepo);
    $departmentDao = new DepartmentDao($pdo);
    $departmentRepo = new DepartmentRepository($departmentDao);
    $departmentService = new DepartmentService($departmentRepo);
    $companyProfileDao = new CompanyProfileDao($pdo);
    $action = $_POST['action'] ?? '';

    if ($action === 'fetchAll'){
        $mode = isset($_SESSION['payslip_mode']) ? $_SESSION['payslip_mode'] : null;
        $employeeId = isset($_POST['employee_id']) && $_POST['employee_id'] !== "0" ? $_POST['employee_id'] : null;
        $dateFilterColumn = isset($_POST['filter_date_column']) ? $_POST['filter_date_column'] : null;
        $dateStart = isset($_POST['filter_startDate']) && $dateFilterColumn !== "none" ? $_POST['filter_startDate'] : 0;
        $dateEnd = isset($_POST['filter_endDate']) && $dateFilterColumn !== "none" ? $_POST['filter_endDate'] : 0;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 10;
        $offset = ($page - 1) * $limit;
        
        $filterCriteria = [];

        if(!empty($employeeId)){
            $filterCriteria[] = [
                "column" => "payslip.employee_id",
                "operator" => "=",
                "value" => $employeeId
            ];
        }

        if($_SESSION['access_role'] === 'Admin'){
            //do nothing
        }
    
        if($_SESSION['access_role'] === 'Manager' && $mode !== "viewOnly"){
            if(!$departmentService->isEmployeeDepartmentHead($_SESSION['id'])){
                return;
            }
            $departmentId = $employeeService->fetchAllEmployees(
                ['department_id'],
                [
                    [
                        "column" => "employee.id",
                        "operator" => "=",
                        "value" => $_SESSION['id']
                    ]
                ],
                [],
                1
            )['result_set'][0]['department_id'];
            $filterCriteria[] = [
                "column" => "employee.department_id",
                "operator" => "=",
                "value" => $departmentId
            ];
        }
    
        if($_SESSION['access_role'] === 'Supervisor' && $mode !== "viewOnly"){
            $filterCriteria[] = [
                "column" => "employee.supervisor_id",
                "operator" => "=",
                "value" => $_SESSION['id']
            ];
        }

        if($mode === "viewOnly"){
            $filterCriteria[] = [
                "column" => "payslip.employee_id",
                "operator" => "=",
                "value" => $_SESSION['id']
            ];
        }

        $filterCriteria[] = [
            "column" => "payslip.deleted_at",
            "operator" => "IS NULL"
        ];
        

        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "payslip." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
            ];
        }

        $sortCriteria = [
            [
                "column" => "payslip." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];
        $result = $payslipDao->fetchAll(
            ['id',
            'employee_full_name', 
            'employee_code', 
            'employee_department_name',
            'employee_job_title',
            'employee_employment_type', 
            'employee_basic_salary', 
            'employee_bank_name', 
            'employee_bank_account_number', 
            'employee_bank_account_type', 
            'payroll_frequency',
            'pay_date', 
            'pay_period_start_date', 
            'pay_period_end_date', 
            'basic_salary', 
            'basic_pay', 
            'gross_pay', 
            'sss_deduction', 
            'philhealth_deduction', 
            'pagibig_fund_deduction', 
            'withholding_tax'], 
            $filterCriteria, 
            $sortCriteria, 
            $limit,
            $offset);
        $payslips;
        // print_r($filterCriteria);
        // print_r($sortCriteria);
        if ($result !== ActionResult::FAILURE){
            $payslips = $result['result_set'];
        }
        $totalPayslips = $result["total_row_count"];
        $totalPages = ceil($totalPayslips / $limit);
        if(isset($_POST['view_mode']) && $_POST['view_mode'] === 'table'){
            
        }else{

        }
        include __DIR__ . '/payslip-table-card.php';
        return;

    }

    if ($action === 'downloadPDF'){
        $token = isset($_POST['token']) ? $_POST['token'] : null;
        if(!$token){
            return;
        }
        $selectedColumns = [
            'employee_full_name', 
            'employee_code', 
            'employee_department_name',
            'employee_job_title',
            'employee_employment_type', 
            'employee_basic_salary', 
            'employee_bank_name', 
            'employee_bank_account_number', 
            'employee_bank_account_type', 
            'employee_date_of_hire',
            'tin_number',
            'sss_number',
            'philhealth_number',
            'pagibig_fund_number',
            'employee_email_address',
            'employee_access_role',
            'payroll_frequency',
            'pay_date', 
            'pay_period_start_date', 
            'pay_period_end_date', 
            'basic_salary', 
            'basic_pay', 
            'gross_pay', 
            'sss_deduction', 
            'philhealth_deduction', 
            'pagibig_fund_deduction',
            'withholding_tax'
        ];
        $filterCriteria = [
            [
                "column" => "SHA2(payslip.id, 256)",
                "operator" => "=",
                "value" => $token
            ]
        ];

        $result = $payslipDao->fetchAll($selectedColumns, $filterCriteria, [], 1);
        $payslipData;
        if ($result !== ActionResult::FAILURE){
            $payslipData = $result['result_set'];
        }
        $totalPayslips = $result["total_row_count"];

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
        include __DIR__ . '/payslip-pdf.php';
        return;
    }


    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}