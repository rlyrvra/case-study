<table class="table table-bordered table-hover" id="break_table">
<thead>
    <th>Name</th>
    <th style="width: 20% !important;">Paid</th>
    <th>Time (in minutes)</th>
    <th style="width: 30% !important;">Action</th>
</thead>
<tbody id="break_table_body">
<?php if(!empty($breakTypes)): ?>
    <?php foreach ($breakTypes as $row): ?>
    <tr>
        <td>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" id="update_name">
        </td>
        <td>
            <select class="form-select" id="update_paid">
                <option <?php echo ($row['is_paid'] == 1) ? 'selected' : ''; ?>>Paid</option>
                <option <?php echo ($row['is_paid'] == 0) ? 'selected' : ''; ?>>Unpaid</option>
            </select>
        </td>
        <td>
            <select class="form-select" id="update_duration">
                <option value="" selected disabled><?php echo htmlspecialchars($row['duration_in_minutes']); ?></option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
                <option value="60">60</option>
            </select>
        </td>
        <td>
            <button class="btn btn-info" title="Click to Update" onclick="updateBreakType(this)" data-token="<?php echo htmlspecialchars($row['id']); ?>"> 
                <i class="bx bx-edit-alt"></i>
            </button> 
            <button class="btn btn-danger" title="Click to Delete" onclick="confirmDeleteBreakType(this)" data-token="<?php echo htmlspecialchars($row['id']); ?>">
                <i class="bx bx-trash"></i>
            </button> 
        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="4" class="text-center">No Break Types</td>
    </tr>
<?php endif ?>
</tbody>
</table>