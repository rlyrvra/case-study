<table class="table table-bordered table-striped text-center">
    <thead class="thead-dark">
        <tr>
            <th colspan="5">Attendance</th>
        </tr>
        <tr>
            <!-- <th>Photo</th> -->
            <th>Employee ID</th>
            <th>Time in</th>
            <th>Time out</th>
            <th>Date logged</th>
        </tr>
    </thead>
    <tbody style="height: 250px;">
    <?php if (!empty($attendanceRecords)): ?>
        <?php foreach ($attendanceRecords as $row): ?>
            <tr>
                <!-- <td></td> -->
                <?php if(empty($row['check_in_time'])){
                    continue;
                }?>
                <td><?php echo htmlspecialchars($row['employee_code']); ?></td>
                <td>
                    <?php echo !empty($row['check_in_time']) ? htmlspecialchars(date("h:i:s A", strtotime($row['check_in_time']))) : ''; ?>
                </td>
                <td>
                    <?php echo !empty($row['check_out_time']) ? htmlspecialchars(date("h:i:s A", strtotime($row['check_out_time']))) : ''; ?>
                </td>
                <td>
                    <?php echo !empty($row['date']) ? htmlspecialchars(date("F j, Y", strtotime($row['date']))) : ''; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="5">No data available</td>
      </tr>
    <?php endif; ?>
    </tbody>
</table>