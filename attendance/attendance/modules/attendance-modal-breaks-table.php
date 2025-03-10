<!-- Modal -->
<div class="modal fade" id="A<?php echo htmlspecialchars($row['id']); ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="A<?php echo htmlspecialchars($row['id']); ?>Title">Break Records</h2>
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
                ?>
                <style>
                </style>
                <!-- Table Rendering -->
                <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th style='width: 1%;'>#</th>
                        <th>Break Type</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Break Duration in Minutes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $workScheduleStartDatetime = htmlspecialchars(date("Y-m-d H:i:s", strtotime($row['date'] . ' ' . $row['work_schedule_snapshot_start_time'] . ' -1 hour')));
                    $workScheduleEndDateTime = htmlspecialchars(date("Y-m-d H:i:s", strtotime($row['date'] . ' ' . $row['work_schedule_snapshot_end_time'] . ' +1 hour')));
                    if ($workScheduleEndDateTime <= $workScheduleStartDatetime) {
                        $workScheduleEndDateTime = htmlspecialchars(date("Y-m-d H:i:s", strtotime($row['date'] . ' ' . $row['work_schedule_snapshot_end_time'] . ' +1 day')));
                    }
                    $employeeBreakFilterCriteria = [
                        [
                            'column'   => 'employee_break.deleted_at',
                            'operator' => 'IS NULL'
                        ],
                        [
                            'column'   => 'break_schedule_snapshot.work_schedule_snapshot_id',
                            'operator' => '='                                                ,
                            'value'    => $row['work_schedule_snapshot_id']
                        ],
                        [
                            'column'      => 'employee_break.created_at'                              ,
                            'operator'    => 'BETWEEN'                                                ,
                            'lower_bound' => $workScheduleStartDatetime,
                            'upper_bound' => $workScheduleEndDateTime
                        ]
                    ];

                    //print_r($employeeBreakFilterCriteria);
    
                    $result = $employeeBreakDao->fetchAll(
                    [
                        'break_type_snapshot_name',
                        'start_time',
                        'end_time',
                        'break_duration_in_minutes',
                        'id'
                    ], 
                    $employeeBreakFilterCriteria);
                    $myBreaks;
                    if ($result !== ActionResult::FAILURE) {
                        $myBreaks = $result['result_set'];
                    }
                    //print_r($myBreaks);
                    ?>
                   
                    <?php if (!empty($myBreaks)): ?>
                    <?php $d = 1; foreach ($myBreaks as $rowBreak): ?>
                        <?php if(empty($rowBreak['start_time'])){
                                continue;
                        }?>
                        <tr>
                            <td><?php echo htmlspecialchars($d); $d++;?></td>
                            <td>
                                <?php echo htmlspecialchars($rowBreak['break_type_snapshot_name']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars(date("F j, Y", strtotime($row['date']))); ?>
                            </td>
                            <td>
                                <?php echo !empty($row['start_time']) ? htmlspecialchars(date("h:i:s A", strtotime($row['start_time']))) : ''; ?>
                            </td>
                            <td>
                            <?php echo !empty($row['end_time']) ? htmlspecialchars(date("h:i:s A", strtotime($row['end_time']))) : ''; ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($rowBreak['break_duration_in_minutes']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($d === 1): ?>
                        <tr>
                            <td colspan="7" class="text-center">No data available</td>
                        </tr>
                    <?php endif; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No data available</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-border-bottom-0">
                        <th style='width: 1%;'>#</th>
                        <th>Break Type</th>
                        <th>Date</th>
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