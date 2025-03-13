<!-- Modal -->
<div class="modal fade" id="WKR<?php echo htmlspecialchars($row['id']); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="WKR<?php echo htmlspecialchars($row['id']); ?>Title">Work Hours</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <hr />
                
                <?php 
                $work_hrs = json_decode($row['work_hours'], true); 
                ?>

                <!-- Work Hours Table -->
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Day Type</th>
                            <th>Holiday Type</th>
                            <th>Regular Hours</th>
                            <th>Overtime Hours</th>
                            <th>Night Differential</th>
                            <th>Night Diff. Overtime</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $index = 1;
                        if (!empty($work_hrs)): ?>
                            <?php foreach ($work_hrs as $day_type => $holidays): ?>
                                <?php foreach ($holidays as $holiday_type => $details): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($index++); ?></td>
                                        <td><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $day_type))); ?></td>
                                        <td><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $holiday_type))); ?></td>
                                        <td><?php echo htmlspecialchars($details['regular_hours'] ?? 0); ?></td>
                                        <td><?php echo htmlspecialchars($details['overtime_hours'] ?? 0); ?></td>
                                        <td><?php echo htmlspecialchars($details['night_differential'] ?? 0); ?></td>
                                        <td><?php echo htmlspecialchars($details['night_differential_overtime'] ?? 0); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="table-border-bottom-0">
                        <tr>
                            <th>#</th>
                            <th>Day Type</th>
                            <th>Holiday Type</th>
                            <th>Regular Hours</th>
                            <th>Overtime Hours</th>
                            <th>Night Differential</th>
                            <th>Night Diff. Overtime</th>
                        </tr>
                    </tfoot>
                </table>

                <hr />

                <!-- Non-Worked Paid Hours -->
                <h4>Non-Worked Paid Hours</h4>
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $index = 1; // Reset index for non-worked hours
                        if (!empty($work_hrs['non_worked_paid_hours'])): ?>
                            <?php foreach ($work_hrs['non_worked_paid_hours'] as $type => $hours): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($index++); ?></td>
                                    <td><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $type))); ?></td>
                                    <td><?php echo htmlspecialchars($hours); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="table-border-bottom-0">
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Hours</th>
                        </tr>
                    </tfoot>
                </table>

                <hr />
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back bx-xs"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>
