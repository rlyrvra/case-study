<?php require_once __DIR__ . '/../../../includes/file-locations.php' ?>
<!-- Leave Requests Reason Modal --> 
<?php if ($row['reason']): ?>
<div class="modal fade" id="R<?php echo htmlspecialchars($row['id']); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header text-white border-bottom">
                <h5 class="modal-title fs-5 text-primary">
                    <i class="bx bx-calendar-exclamation"></i> Leave Request: 
                    <span class="fw-semibold"><?php echo htmlspecialchars($row['employee_full_name']); ?></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p class="text-muted mb-1">
                    <strong>Leave Duration:</strong> 
                    <i class="bx bx-calendar-plus"></i><?php echo htmlspecialchars($row['start_date']); ?> 
                    to 
                    <i class="bx bx-calendar-minus"></i><?php echo htmlspecialchars($row['end_date']); ?>
                </p>

                <div class="mb-3">
                    <h5 class="fw-semibold">Reason:</h5>
                    <p class="border p-3 bg-light rounded shadow-sm"><?php echo nl2br(htmlspecialchars($row['reason'])); ?></p>
                </div>

                <?php 
                $filterCriteria2 = [
                    ["column" => "leave_request_attachment.leave_request_id", "operator" => "=", "value" => $row['id']]
                ];
                $leaveRequestAttachments = $leaveRequestService->fetchAllLeaveRequestAttachments([], $filterCriteria2);
                $attachments = $leaveRequestAttachments['result_set'];
                if (!empty($attachments)): ?>
                    <div class="mb-3">
                        <h5 class="fw-semibold">Attachments:</h5>
                        <ul class="list-group">
                            <?php foreach ($attachments as $attachment): ?>
                                <?php if ($attachment['file_path']): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center shadow-sm">
                                        <?php 
                                        $fileName = basename($attachment['file_path']);
                                        $shortFileName = (strlen($fileName) > 20) ? substr($fileName, 0, 17) . '...' : $fileName;
                                        ?>
                                        <span title="<?php echo htmlspecialchars($fileName); ?>" class="text-truncate d-inline-block" style="max-width: 70%;">
                                            <?php echo htmlspecialchars($shortFileName); ?>
                                        </span>
                                        <a href="<?php echo $SMARTWAGE_LOCATION; ?>/uploads/<?php echo htmlspecialchars($fileName); ?>" 
                                        class="btn btn-sm btn-outline-primary" 
                                        download>
                                            Download
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <p class="text-muted">
                        Please review the request details carefully and decide whether to approve or reject.
                    </p>
                    <p><strong>Current Status:</strong> 
                        <span class="badge bg-secondary"><?php echo htmlspecialchars($row['status']); ?></span>
                    </p>
                </div>

                <label for="update_status<?php echo htmlspecialchars($row['id']); ?>" class="form-label">Update Status</label>
                <select id="update_status<?php echo htmlspecialchars($row['id']); ?>" class="form-select shadow-sm" required>
                    <option value="Pending" <?php echo $row['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Approved" <?php echo $row['status'] === 'Approved' ? 'selected' : ''; ?>>Approved</option>
                    <option value="Rejected" <?php echo $row['status'] === 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                    <option value="Canceled" <?php echo $row['status'] === 'Canceled' ? 'selected' : ''; ?>>Canceled</option>
                </select>
            </div>

            <div class="modal-footer border-top">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" data-bs-dismiss="modal" data-token="<?php echo htmlspecialchars($row['id']); ?>" onclick="reviewStatus(this)">
                    Save Review
                </button>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
<div class="modal fade" id="defaultReason" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">No Reason Provided</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="text-muted">No reason has been submitted for this leave request.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
