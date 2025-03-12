<?php
// table.php
// Expecting $data to be passed from api.php
?>
<style>
</style>
<!-- Table Rendering -->
<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th style='width: 1%;'>#</th>
            <th>Setting Key</th>
            <th>Setting Value</th>
            <th>Group Name</th>
            <th style='width: 14%'>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($settings)): ?>
            <?php $i = 1; foreach ($settings as $row): ?>
                <tr data-token="<?php echo htmlspecialchars($row['id']); ?>">
                    <td>
                        <?php echo htmlspecialchars($i); $i++; ?>
                    </td>
                    <td>
                        <?php echo ucwords(str_replace('_', ' ', htmlspecialchars($row['setting_key']))); ?>
                    </td>
                    <td>
                        <input type="number" class="form-control" value=<?php echo htmlspecialchars($row['setting_value']); ?> min=0 max=120 />
                    </td>
                    <td>
                    <?php echo ucwords(str_replace('_', ' ', htmlspecialchars($row['group_name']))); ?>
                    </td>
                    <td>
                        <button class="btn btn-info" title="Click to Edit" onclick="updateSetting(this)">
                            <i class="bx bx-edit-alt"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px; color: #888;">No data available</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>