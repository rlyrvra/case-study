<table class="table table-bordered table-hover">
    <thead>
        <tr>
        <th scope="col">Allowance</th>
        <th scope="col">Amount</th>
        <th scope="col">Frequency</th>
        <!-- <th scope="col" style="width: 9%;">Actions</th> -->
        </tr>
    </thead>
    <tbody id="employee-leave-body">
    <?php if(!empty($employeeLeaves)): ?>
        <?php foreach ($employeeLeaves as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['amount']); ?></td>
            <td><?php echo htmlspecialchars($row['frequency']); ?></td>
            <!-- <td>
              <button class="btn btn-danger" title="Click to Delete" onclick="confirmDeleteEmployeeLeave(this)" data-id="<?php //echo htmlspecialchars($row['id']); ?>">
                <i class="bx bx-trash"></i>
              </button> 
            </td> -->
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" class="text-center">No Assigned Allowances</td>
        </tr>
    <?php endif ?>
    </tbody>
</table>