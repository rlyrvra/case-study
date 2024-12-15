<table class="table table-bordered table-hover">
    <thead>
        <tr>
        <th scope="col">Leave Type</th>
        <th scope="col">Allowed</th>
        <th scope="col">Days Taken</th>
        <th scope="col">Available</th>
        <th scope="col" style="width: 9%;">Actions</th>
        </tr>
    </thead>
    <tbody id="employee-leave-body">
    <?php if(!empty($employeeLeaves)): ?>
        <?php foreach ($employeeLeaves as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['leave_type_name']); ?></td>
            <td><?php echo htmlspecialchars($row['number_of_entitled_days']); ?></td>
            <td><?php echo htmlspecialchars($row['number_of_days_taken']); ?></td>
            <td><?php echo htmlspecialchars($row['remaining_days']); ?></td>
            <td>
              <button class="btn btn-danger" title="Click to Delete" onclick="confirmDeleteEmployeeLeave(this)" data-id="<?php echo htmlspecialchars($row['id']); ?>">
                <i class="bx bx-trash"></i>
              </button> 
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" class="text-center">No Assigned Leaves</td>
        </tr>
    <?php endif ?>
    </tbody>
</table>