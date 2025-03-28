<?php
require_once __DIR__ . '/includes/Helper.php';
require_once __DIR__ . '/database/database.php';

require_once __DIR__ . '/employees/EmployeeService.php';

require_once __DIR__ . '/departments/DepartmentService.php';

require_once __DIR__ . '/attendance/AttendanceDao.php';

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
                <h3>Total Employees in the Department</h3>
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
                        $departmentDao = new DepartmentDao($pdo);
                        $departmentRepository = new DepartmentRepository($departmentDao);
                        $departmentService = new DepartmentService($departmentRepository);
                        $employeeDao = new EmployeeDao($pdo);
                        $employeeRepository = new EmployeeRepository($employeeDao);
                        $employeeService = new EmployeeService($employeeRepository);

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
                <h3>Total Supervisors in the Department</h3>
                <h2>
                <?php
                    function getTotalSupervisors(){
                        global $pdo;
                        $selectedColumns = ["id"];
                        $filterCriteria = [];
                        $filterCriteria[] = [
                            "column" => "employee.deleted_at",
                            "operator" => "IS NULL"
                        ];
                        $filterCriteria[] = [
                            "column" => "employee.access_role",
                            "operator" => "=",
                            "value" => "Supervisor"
                        ];
                        $departmentDao = new DepartmentDao($pdo);
                        $departmentRepository = new DepartmentRepository($departmentDao);
                        $departmentService = new DepartmentService($departmentRepository);
                        $employeeDao = new EmployeeDao($pdo);
                        $employeeRepository = new EmployeeRepository($employeeDao);
                        $employeeService = new EmployeeService($employeeRepository);

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

                        $result = $employeeService->fetchAllEmployees($selectedColumns, $filterCriteria);
                        $employees = [];
                        if ($result !== ActionResult::FAILURE) {
                            $employees = $result['result_set'];
                        }

                        $totalSupervisors = $result["total_row_count"];
                        return $totalSupervisors;
                    }
                    
                    echo getTotalSupervisors();
                ?>
                </h2>
            </div>
            <div class="dashboard-card">
                <h3>Total Managers in the Department</h3>
                <h2>
                <?php
                    function getTotalManagers(){
                        global $pdo;
                        $selectedColumns = ["id"];
                        $filterCriteria = [];
                        $filterCriteria[] = [
                            "column" => "employee.deleted_at",
                            "operator" => "IS NULL"
                        ];
                        $filterCriteria[] = [
                            "column" => "employee.access_role",
                            "operator" => "=",
                            "value" => "Manager"
                        ];
                        $departmentDao = new DepartmentDao($pdo);
                        $departmentRepository = new DepartmentRepository($departmentDao);
                        $departmentService = new DepartmentService($departmentRepository);
                        $employeeDao = new EmployeeDao($pdo);
                        $employeeRepository = new EmployeeRepository($employeeDao);
                        $employeeService = new EmployeeService($employeeRepository);

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

                        $result = $employeeService->fetchAllEmployees($selectedColumns, $filterCriteria);
                        $employees = [];
                        if ($result !== ActionResult::FAILURE) {
                            $employees = $result['result_set'];
                        }

                        $totalManagers = $result["total_row_count"];
                        return $totalManagers;
                    }
                    
                    echo getTotalManagers();
                ?>
                </h2>
            </div>
            <div class="dashboard-card">
                <h3>Total Staff in the Department</h3>
                <h2>
                <?php
                    function getTotalStaff(){
                        global $pdo;
                        $selectedColumns = ["id"];
                        $filterCriteria = [];
                        $filterCriteria[] = [
                            "column" => "employee.deleted_at",
                            "operator" => "IS NULL"
                        ];
                        $filterCriteria[] = [
                            "column" => "employee.access_role",
                            "operator" => "=",
                            "value" => "Staff"
                        ];
                        $departmentDao = new DepartmentDao($pdo);
                        $departmentRepository = new DepartmentRepository($departmentDao);
                        $departmentService = new DepartmentService($departmentRepository);
                        $employeeDao = new EmployeeDao($pdo);
                        $employeeRepository = new EmployeeRepository($employeeDao);
                        $employeeService = new EmployeeService($employeeRepository);

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

                        $result = $employeeService->fetchAllEmployees($selectedColumns, $filterCriteria);
                        $employees = [];
                        if ($result !== ActionResult::FAILURE) {
                            $employees = $result['result_set'];
                        }

                        $totalManagers = $result["total_row_count"];
                        return $totalManagers;
                    }

                    echo getTotalManagers();
                ?>
                    
                </h2>
            </div>
        </div>

        <div class="container">
            <?php
                $attendanceDao = new AttendanceDao($pdo);
                $originalCurrentDateTime = new DateTime();
                $result = $attendanceDao->fetchAll(
                    [
                        "check_in_time",
                        "check_out_time",
                        "total_hours_worked",
                        "work_schedule_snapshot_employee_id"
                    ], 
                    [
                        [
                            "column" => "attendance.deleted_at",
                            "operator" => "IS NULL"
                        ],
                        [
                            "column" => "work_schedule_snapshot.employee_id",
                            "operator" => "=",
                            "value" => $_SESSION['id']
                        ],
                        [
                            "column" => "attendance.date",
                            "operator" => "=",
                            "value" => $originalCurrentDateTime->format("Y-m-d")
                        ]
                    ], 
                    [
                        [
                            "column" => "attendance.date",
                            "direction" => "DESC"
                        ]
                    ], 5, 0);
                    
                    $myAttendance = $result['result_set'];
            ?>
            <h2 class="my-4">Work Hours Table (<?= htmlspecialchars($originalCurrentDateTime->format("l, F j, Y")); ?>)</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Total Hours Worked</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($myAttendance)): ?>
                    <?php $i = 1; foreach ($myAttendance as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($i); $i++;?></td>
                        <td><?php echo !empty($row['check_in_time']) ? htmlspecialchars(date("h:i:s A", strtotime($row['check_in_time']))) : ''; ?></td>
                        <td><?php echo !empty($row['check_out_time']) ? htmlspecialchars(date("h:i:s A", strtotime($row['check_out_time']))) : ''; ?></td>
                        <td><?php echo htmlspecialchars($row['total_hours_worked']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="4">No data available</td>
                </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- <div class="chart-container">
            <h3 class="text-center">Employee Distribution by Department</h3>
            <canvas id="barChart"></canvas>
        </div> -->


    </div>

    <script>
        // const barCtx = document.getElementById('barChart').getContext('2d');
        // new Chart(barCtx, {
        //     type: 'bar',
        //     data: {
        //         labels: ['Engineering', 'IT', 'Finance', 'HR', 'Housekeeping', 'Marketing'],
        //         datasets: [{
        //             label: 'Number of Employees per Department',
        //             data: [10, 15, 8, 12, 5, 10],
        //             backgroundColor: ['#28a745', '#ffc107', '#007bff', '#6f42c1', '#fd7e14', '#d63384'],
        //             borderColor: ['#28a745', '#ffc107', '#007bff', '#6f42c1', '#fd7e14', '#d63384'],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false,
        //         plugins: {
        //             legend: {
        //                 labels: {
        //                     font: {
        //                         family: "'Poppins', sans-serif",
        //                         size: 14,
        //                         weight: '500'
        //                     },
        //                     color: '#2f5932'
        //                 }
        //             }
        //         },
        //         scales: {
        //             y: {
        //                 beginAtZero: true,
        //                 ticks: {
        //                     font: {
        //                         family: "'Poppins', sans-serif",
        //                         size: 12
        //                     },
        //                     color: '#43634a'
        //                 },
        //                 title: {
        //                     display: true,
        //                     text: 'Number of Employees',
        //                     font: {
        //                         family: "'Poppins', sans-serif",
        //                         size: 14,
        //                         weight: '600'
        //                     }
        //                 }
        //             },
        //             x: {
        //                 ticks: {
        //                     font: {
        //                         family: "'Poppins', sans-serif",
        //                         size: 12
        //                     },
        //                     color: '#43634a'
        //                 },
        //                 title: {
        //                     display: true,
        //                     text: 'Departments',
        //                     font: {
        //                         family: "'Poppins', sans-serif",
        //                         size: 14,
        //                         weight: '600'
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // });
    </script>
</html>

