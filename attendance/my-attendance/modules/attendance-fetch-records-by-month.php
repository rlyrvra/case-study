<?php
require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../database/database.php';
require_once __DIR__ . '/../../../includes/session.php';

function getAttendanceRecordsByMonth() {
    global $pdo, $hosted;

    try {
        $sql = "SELECT DISTINCT DATE_FORMAT(attendance.date, '%M %Y') AS month_year 
                    FROM attendance AS attendance
                    ORDER BY attendance.date DESC";
        if($hosted){
            $sql = "SELECT DISTINCT DATE_FORMAT(attendance.created_at, '%M %Y') AS month_year 
                FROM attendance AS attendance
                ORDER BY attendance.created_at DESC";
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $attendanceRecords = $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch as an array of month_year values
        
        return $attendanceRecords;
    } catch (PDOException $e) {
        return ['error' => $e->getMessage()]; // Return an error if something goes wrong
    }
}
?>

<script>
function clearAttendanceRecords(select){
    select.innerHTML = `
    <li><a class="dropdown-item selected" href="#" data-group="by_record" data-value="">None</a></li>
    `;
}

var attendanceRecords = getAttendanceRecords();
function getAttendanceRecords(){
    const values = <?php 
        $attendanceRecords = getAttendanceRecordsByMonth();
        echo json_encode($attendanceRecords); 
        ?>;
    return values;
}

function populateAttendanceRecords(select){
    clearAttendanceRecords(select);
    attendanceRecords.forEach(attendanceRecord => {
        select.innerHTML += `
        <li><a class="dropdown-item" href="#" data-group="by_record" data-value="${attendanceRecord}">${attendanceRecord}</a></li>
        `;
    });
    const dropdownItems = document.querySelectorAll('.byRecords .dropdown-item');
    addItemListener(dropdownItems);
}

</script>