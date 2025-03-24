<table class="table table-bordered table-hover">
    <thead>
        <tr>
        <th scope="col">Deduction</th>
        <th scope="col">Amount</th>
        <th scope="col">Frequency</th>
        <th scope="col" style="width: 9%;">Actions</th>
        </tr>
    </thead>
    <tbody id="employee-leave-body">
    <?php if(!empty($employeeDeductions)): ?>
        <?php foreach ($employeeDeductions as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['deduction_name']); ?></td>
            <td><?php echo htmlspecialchars($row['amount']); ?></td>
            <td><?php echo htmlspecialchars($row['deduction_frequency']); ?></td>
            <td>
              <button class="btn btn-danger" title="Click to Delete" onclick="confirmDeleteAssignedDeduction(this)" data-id="<?php echo htmlspecialchars($row['id']); ?>">
                <i class="bx bx-trash"></i>
              </button> 
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" class="text-center">No Assigned Deductions</td>
        </tr>
    <?php endif ?>
    </tbody>
</table>