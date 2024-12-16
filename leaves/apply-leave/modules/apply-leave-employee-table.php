<table id="leavesTable" class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($employeeLeaveRequests)): ?>
        <?php foreach ($employeeLeaveRequests as $row): ?>
        <tr>
            <td><?php $i++; echo $i;?></td>
            <td><?php echo htmlspecialchars($row['leave_type_name']); ?></td>
            <td><?php echo htmlspecialchars($row['start_date']); ?></td>
            <td><?php echo htmlspecialchars($row['end_date']); ?></td>
            <td><?php echo htmlspecialchars($row['reason']); ?></td>
            <td><span class="badge 
            <?php 
            if($row['status'] === "Approved"){
                echo "bg-success";
            }else if($row['status'] === "Pending"){
                echo "bg-label-warning";
            }else if($row['status'] === "Rejected"){
                echo "bg-label-danger";
            }else if($row['status'] === "Canceled"){
                echo "bg-label-secondary";
            }else{

            }
            ?>"><?php echo htmlspecialchars($row['reason']); ?></span></td>
            <td><button 
            class="btn btn-primary dropdown-toggle" 
            type="button" 
            data-bs-toggle="dropdown" 
            aria-expanded="false">
                Actions
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#"><i class="bx bx-edit-alt"></i>Edit</a></li>
            </ul></td>
        </tr>
        <!-- Additional rows can be added dynamically from the database -->
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" class="text-center">No data available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>