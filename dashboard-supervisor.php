<?php
require_once __DIR__ . '/includes/Helper.php';
require_once __DIR__ . '/includes/enums/ErrorCode.php';
require_once __DIR__ . '/database/database.php';

require_once __DIR__ . '/employees/EmployeeDao.php';
require_once __DIR__ . '/employees/EmployeeService.php';
require_once __DIR__ . '/employees/EmployeeRepository.php';
require_once __DIR__ . '/employees/Employee.php';

require_once __DIR__ . '/leaves/LeaveRequest.php';
require_once __DIR__ . '/leaves/LeaveRequestDao.php';
require_once __DIR__ . '/leaves/LeaveRequestRepository.php';
require_once __DIR__ . '/leaves/LeaveRequestService.php';

require_once __DIR__ . '/leaves/LeaveEntitlement.php';
require_once __DIR__ . '/leaves/LeaveEntitlementDao.php';
require_once __DIR__ . '/leaves/LeaveEntitlementRepository.php';
require_once __DIR__ . '/leaves/LeaveEntitlementService.php';

require_once __DIR__ . '/leaves/LeaveRequestAttachment.php';
require_once __DIR__ . '/leaves/LeaveRequestAttachmentDao.php';
require_once __DIR__ . '/leaves/LeaveRequestAttachmentRepository.php';
?>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #ffffff, #e9f5e9);
    margin: 0;
    padding: 0;
    min-height: 100vh;
    color: #2f3e2f;
}

.dashboard-container {
    padding: 40px 20px;
    max-width: 1200px;
    margin: auto;
}

.dashboard-header {
    text-align: center;
    margin-bottom: 20px;
    font-size: 38px;
    font-weight: 700;
    color: #2f5932;
}

.welcome-label {
    text-align: center;
    font-size: 18px;
    margin-bottom: 40px;
    color: #43634a;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    padding: 20px;
}

.dashboard-card {
    background: #ffffff;
    color: #155724;
    border: 2px solid #28a745;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 40px 20px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.dashboard-card h3 {
    font-size: 18px;
    font-weight: 500;
    margin-bottom: 10px;
}

.dashboard-card h2 {
    font-size: 48px;
    font-weight: 700;
    margin: 0;
    color: #2f5932;
}

.dashboard-card:hover {
    background: #e9f5e9;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}

table {
    width: 100%; /* Ensure the table takes full width */
    border-collapse: collapse;
    margin-top: 40px;
}

thead th {
    padding: 15px; /* Consistent padding */
    text-align: center; /* Center text alignment */
    font-weight: 600; /* Font weight for header */
    background-color: #28a745; /* Background color for the header */
    color: white; /* Text color for the header */
    border-bottom: 1px solid #ddd; /* Border at the bottom for separation */
}

thead th:hover {
    background-color: #218838; /* Darker background on hover */
    cursor: pointer; /* Pointer cursor for interaction */
}

tbody td {
    text-align: center; /* Center align data cells */
    padding: 15px; /* Consistent padding */
    color: #2f3e2f; /* Text color for the data cells */
    font-size: 16px;
    border-bottom: 1px solid #ddd; /* Border at the bottom for separation */
}

tbody tr:hover {
    background-color: #f3faf3; /* Highlight background color on hover */
}

.chart-container {
    margin-top: 40px;
    background: #ffffff;
    border: 2px solid #28a745;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    padding: 30px;
}

.chart-container canvas {
    max-height: 300px;
    display: block;
}

footer {
    text-align: center;
    margin-top: 50px;
    padding: 20px;
    background-color: #2f5932;
    color: #ffffff;
    border-radius: 10px;
}

h2.my-4 {
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    font-weight: 600;
    color: #2f5932;
    text-align: center;
    margin-bottom: 20px;
}

</style>
<body>
    <div class="dashboard-container">
        <h1 class="dashboard-header">Team Performance Dashboard</h1>
        <p class="welcome-label">Welcome, <?php echo $_SESSION['full_name'];?>! Here’s an overview of your team's performance and distribution.</p>
        
        <div class="card-grid">
            <div class="dashboard-card">
                <h3>Total Supervisees</h3>
                <h2>
                    <?php
                        function getTotalEmployees(){
                            global $pdo;
                            $selectedColumns = ["id"];
                            $filterCriteria = [];
                            $filterCriteria[] = [
                                "column" => "employee.deleted_at",
                                "operator" => "IS NULL"
                            ];
                            $filterCriteria[] = [
                                "column" => "employee.supervisor_id",
                                "operator" => "=",
                                "value" => $_SESSION['id']
                            ];
                            $employeeDao = new EmployeeDao($pdo);
                            $employeeRepository = new EmployeeRepository($employeeDao);
                            $employeeService = new EmployeeService($employeeRepository);
                            $result = $employeeService->fetchAllEmployees($selectedColumns, $filterCriteria);
                            $employees = [];
                            if ($result !== ActionResult::FAILURE) {
                                $employees = $result['result_set'];
                            }

                            $totalEmployees = $result["total_row_count"];
                            return $totalEmployees;
                        }
                        

                        echo getTotalEmployees();
                    ?>
                </h2>
            </div>
            <div class="dashboard-card">
                <h3>Total Leave Requests</h3>
                <h2>
                    <?php
                        $filterCriteria = [];
                        $leaveRequestDao = new LeaveRequestDao($pdo);
                        $leaveRequestAttachmentDao = new LeaveRequestAttachmentDao($pdo);
                        $leaveEntitlementDao = new LeaveEntitlementDao($pdo);

                        $leaveRequestRepo = new LeaveRequestRepository($leaveRequestDao);
                        $leaveRequestAttachmentRepo = new LeaveRequestAttachmentRepository($leaveRequestAttachmentDao);
                        $leaveRequestService = new LeaveRequestService($leaveRequestRepo, $leaveRequestAttachmentRepo);
                        $result = $leaveRequestService->fetchAllLeaveRequests(["id"], $filterCriteria);

                        echo $result["total_row_count"];
                    ?>
                </h2>
            </div>
        </div>
        <div class="container">
            <h2 class="my-4">Work Hours Table</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Total Hours Worked</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>2024-12-20</td>
                        <td>9:00 AM</td>
                        <td>5:00 PM</td>
                        <td>8 hours</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>2024-12-19</td>
                        <td>9:30 AM</td>
                        <td>5:30 PM</td>
                        <td>8 hours</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>2024-12-18</td>
                        <td>10:00 AM</td>
                        <td>6:00 PM</td>
                        <td>8 hours</td>
                    </tr>
                </tbody>
            </table>
        </div>
</html>
