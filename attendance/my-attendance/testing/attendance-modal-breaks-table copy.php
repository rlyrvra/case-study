<!-- Modal -->
<div class="modal fade" id="A<?php echo htmlspecialchars($row['id']); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="A<?php echo htmlspecialchars($row['id']); ?>Title">Break Schedules</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">
                <hr/>
                <?php
                //print_r($myBreaks);
                //  $employeeBreakFilterCriteria = [
                //     [
                //         'column'   => 'employee_break.deleted_at',
                //         'operator' => 'IS NULL'
                //     ],
                //     [
                //         'column'   => 'break_schedule_snapshot.work_schedule_snapshot_id',
                //         'operator' => '='                                                ,
                //         'value'    => $row['work_schedule_snapshot_id']
                //     ],
                //     [
                //         'column'      => 'employee_break.created_at'                              ,
                //         'operator'    => 'BETWEEN'                                                ,
                //         'lower_bound' => htmlspecialchars(date("Y-m-d H:i:s", strtotime($row['work_schedule_snapshot_start_time']))),
                //         'upper_bound' => htmlspecialchars(date("Y-m-d H:i:s", strtotime($row['work_schedule_snapshot_end_time']))),
                //     ]
                // ];

                // $result = $employeeBreakDao->fetchAll([], $employeeBreakFilterCriteria);
                // $myBreaks;
                // if ($result !== ActionResult::FAILURE) {
                //     $myBreaks = $result['result_set'];
                // }
                ?>
                <style>
                </style>
                <!-- Table Rendering -->
                <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th style='width: 1%;'>#</th>
                        <th>Break Type</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Break Duration in Minutes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $myBreaks = $employeeBreakRecords[$row['work_schedule_snapshot_id']]; ?>
                    <?php print_r($myBreaks);if (!empty($myBreaks)): ?>
                    <?php $i = ($offset + 1); foreach ($myBreaks as $rowBreak): ?>
                        <tr>
                        <td><?php echo htmlspecialchars($i); $i++;?></td>
                        <td>
                            <?php echo htmlspecialchars($rowBreak['break_type_snapshot_name']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars(date("F j, Y", strtotime($row['date']))); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars(date("Y-m-d h:i:s A", strtotime($rowBreak['start_time']))); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars(date("Y-m-d h:i:s A", strtotime($rowBreak['end_time']))); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($rowBreak['break_duration_in_minutes']); ?>
                        </td>
                        
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7">No data available</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-border-bottom-0">
                    <th style='width: 1%;'>#</th>
                    <th>Break Type</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Break Duration in Minutes</th>
                </tfoot>
                </table>
                <hr/>

            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back bx-xs"></i>Close
                </button>
            </div>
                    
                
            
        </div>
    </div>
</div>