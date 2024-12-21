<?php require_once __DIR__ . '/../../../includes/file-locations.php' ?>
<!-- Small Modal --> 
<?php if ($row['reason']): ?>
<div class="modal fade" id="R<?php echo htmlspecialchars($row['id']); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?php echo htmlspecialchars($row['employee_full_name']); ?>'s reason for leaving from
                    <span class="fw-bold"><?php echo htmlspecialchars($row['start_date']); ?></span> to 
                    <span class="fw-bold"><?php echo htmlspecialchars($row['end_date']); ?></span>.
                </h5>
                <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <h5>Reason:</h5>
                    <p><?php echo htmlspecialchars($row['reason']); ?></p>
                    <p>Below are the list of files that have been <strong>attached</strong> to the request: </p>
                    <?php 
                    $filterCriteria2 = [
                        [
                            "column" => "leave_request_attachment.leave_request_id",
                            "operator" => "=",
                            "value" => $row['id']
                        ]
                    ];
                    $leaveRequestAttachments = $leaveRequestService->fetchAllLeaveRequestAttachments([], $filterCriteria2);
                    $attachments = $leaveRequestAttachments['result_set'];
                    // Loop through each attachment and create a download button
                    foreach ($attachments as $attachment) {
                        $filePath = $attachment['file_path']; // Assuming file_path is the key in the attachment array
                        if ($filePath) {
                            // Assuming 'uploads/' is the folder accessible via URL
                            echo '<a href="'. $SMARTWAGE_LOCATION .'/uploads/' . basename($filePath) . '" class="btn btn-primary" download="'. $SMARTWAGE_LOCATION .'/uploads/' . basename($filePath) . '">Download</a>';
                        }
                    }
                    ?>
                </div>
                <div class="row mb-3">
                    <p>You are reviewing the request of this employee. Please review the details carefully and decide whether to approve or reject the request.</p>
                    <p><strong>Leave Current Status</strong>: <?php echo $row['status'] ?>
                
                </div>
                <label for="update_status" class="form-label">Status*</label>
                <select id="update_status" data-token="<?php echo htmlspecialchars($row['id']); ?>" class="form-select" required>
                    <option value="Pending" <?php echo $row['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Approved" <?php echo $row['status'] === 'Approved' ? 'selected' : ''; ?>>Approved</option>
                    <option value="Rejected" <?php echo $row['status'] === 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                    <option value="Canceled" <?php echo $row['status'] === 'Canceled' ? 'selected' : ''; ?>>Canceled</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save Review</button>
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