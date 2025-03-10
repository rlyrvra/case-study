<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../../payroll/PayslipService.php';
require_once __DIR__ . '/../../employees/EmployeeService.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';


try {
    $payslipDao = new PayslipDao($pdo);
    $employeeDao = new EmployeeDao($pdo);
    $action = $_POST['action'] ?? '';

    if ($action === 'fetchAll'){
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
            'payroll_frequency',
            'pay_date', 
            'pay_period_start_date', 
            'pay_period_end_date', 
            'basic_salary', 
            'basic_pay', 
            'gross_pay', 
            'sss_deduction', 
            'philhealth_deduction', 
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
        include __DIR__ . '/payslip-pdf.php';
        return;
    }


    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}