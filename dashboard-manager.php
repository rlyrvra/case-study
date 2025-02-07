<?php
require_once __DIR__ . '/includes/Helper.php';
require_once __DIR__ . '/database/database.php';

require_once __DIR__ . '/employees/EmployeeDao.php';
require_once __DIR__ . '/employees/EmployeeService.php';
require_once __DIR__ . '/employees/EmployeeRepository.php';
require_once __DIR__ . '/employees/Employee.php';

require_once __DIR__ . '/departments/DepartmentDao.php';
require_once __DIR__ . '/departments/DepartmentService.php';
require_once __DIR__ . '/departments/DepartmentRepository.php';
require_once __DIR__ . '/departments/Department.php';

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
                
                </h2>
            </div>
            <div class="dashboard-card">
                <h3>Total Supervisors in the Department</h3>
                <h2>143</h2>
            </div>
            <div class="dashboard-card">
                <h3>Total Managers in the Department</h3>
                <h2>154</h2>
            </div>
            <div class="dashboard-card">
                <h3>Total Staff in the Department</h3>
                <h2>165</h2>
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

        <div class="chart-container">
            <h3 class="text-center">Employee Distribution by Department</h3>
            <canvas id="barChart"></canvas>
        </div>


    </div>

    <script>
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Engineering', 'IT', 'Finance', 'HR', 'Housekeeping', 'Marketing'],
                datasets: [{
                    label: 'Number of Employees per Department',
                    data: [10, 15, 8, 12, 5, 10],
                    backgroundColor: ['#28a745', '#ffc107', '#007bff', '#6f42c1', '#fd7e14', '#d63384'],
                    borderColor: ['#28a745', '#ffc107', '#007bff', '#6f42c1', '#fd7e14', '#d63384'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 14,
                                weight: '500'
                            },
                            color: '#2f5932'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 12
                            },
                            color: '#43634a'
                        },
                        title: {
                            display: true,
                            text: 'Number of Employees',
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 14,
                                weight: '600'
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 12
                            },
                            color: '#43634a'
                        },
                        title: {
                            display: true,
                            text: 'Departments',
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 14,
                                weight: '600'
                            }
                        }
                    }
                }
            }
        });
    </script>
</html>

