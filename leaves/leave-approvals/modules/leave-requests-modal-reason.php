<!-- Small Modal --> 
<?php if ($row['reason']): ?>
<div class="modal fade" id="R<?php echo htmlspecialchars($row['id']); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?php echo htmlspecialchars($row['employee_full_name']); ?>'s reason for leaving from
                    <span class="fw-bold"><?php echo htmlspecialchars($row['start_date']); ?></span> to 
                    <span class="fw-bold"><?php echo htmlspecialchars($row['end_date']); ?></span> to 
                </h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <h5>Reason:</h5>
                <?php echo htmlspecialchars($row['reason']); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="modal fade" id="defaultReason" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Close
            </div>
        </div>
    </div>
</div>
<?php endif; ?>