<table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>Day Type</th>
            <th>Holiday Type</th>
            <th>Regular Hour</th>
            <th>Overtime</th>
            <th>Night Differential</th>
            <th>Night Differential Overtime</th>
        </tr>
    </thead>
    <tbody id="overtime_rates_table_body" data-token="<?php echo htmlspecialchars($overtimeRates[0]['overtime_rate_assignment_id']); ?>">
        <?php if (!empty($overtimeRates)): ?>
            <?php foreach ($overtimeRates as $row): ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($row['day_type']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['holiday_type']); ?>
                    </td>
                    <td>
                        <input type="number" step="0.001" value="<?php echo htmlspecialchars($row['regular_time_rate']); ?>">
                    </td>
                    <td>
                        <input type="number" step="0.001" value="<?php echo htmlspecialchars($row['overtime_rate']); ?>">
                    </td>
                    <td>
                        <input type="number" step="0.001" value="<?php echo htmlspecialchars($row['night_differential_rate']); ?>">
                    </td>
                    <td>
                        <input type="number" step="0.001" value="<?php echo htmlspecialchars($row['night_differential_and_overtime_rate']); ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td>Regular</td>
                <td><input type="number" step="0.001" placeholder="0.00"></td>
                <td><input type="number" step="0.001" placeholder="1.350"></td>
                <td><input type="number" step="0.001" placeholder="0.100"></td>
                <td><input type="number" step="0.001" placeholder="1.375"></td>
            </tr>
            <tr>
                <td>Special Holiday</td>
                <td><input type="number" step="0.001" placeholder="0.300"></td>
                <td><input type="number" step="0.001" placeholder="1.690"></td>
                <td><input type="number" step="0.001" placeholder="0.430"></td>
                <td><input type="number" step="0.001" placeholder="1.859"></td>
            </tr>
            <tr>
                <td>Regular Holiday</td>
                <td><input type="number" step="0.001" placeholder="1.000"></td>
                <td><input type="number" step="0.001" placeholder="2.600"></td>
                <td><input type="number" step="0.001" placeholder="1.200"></td>
                <td><input type="number" step="0.001" placeholder="2.860"></td>
            </tr>
            <tr>
                <td>Double Holiday</td>
                <td><input type="number" step="0.001" placeholder="1.600"></td>
                <td><input type="number" step="0.001" placeholder="3.380"></td>
                <td><input type="number" step="0.001" placeholder="1.860"></td>
                <td><input type="number" step="0.001" placeholder="3.718"></td>
            </tr>
            <tr>
                <td>Rest Day</td>
                <td><input type="number" step="0.001" placeholder="1.300"></td>
                <td><input type="number" step="0.001" placeholder="1.690"></td>
                <td><input type="number" step="0.001" placeholder="1.430"></td>
                <td><input type="number" step="0.001" placeholder="1.859"></td>
            </tr>
            <tr>
                <td>Rest Day Special Holiday</td>
                <td><input type="number" step="0.001" placeholder="1.500"></td>
                <td><input type="number" step="0.001" placeholder="1.950"></td>
                <td><input type="number" step="0.001" placeholder="1.650"></td>
                <td><input type="number" step="0.001" placeholder="2.145"></td>
            </tr>
            <tr>
                <td>Rest Day Regular Holiday</td>
                <td><input type="number" step="0.001" placeholder="2.600"></td>
                <td><input type="number" step="0.001" placeholder="3.380"></td>
                <td><input type="number" step="0.001" placeholder="2.860"></td>
                <td><input type="number" step="0.001" placeholder="3.719"></td>
            </tr>
            <tr>
                <td>Rest Day Double Holiday</td>
                <td><input type="number" step="0.001" placeholder="3.000"></td>
                <td><input type="number" step="0.001" placeholder="3.900"></td>
                <td><input type="number" step="0.001" placeholder="3.300"></td>
                <td><input type="number" step="0.001" placeholder="4.290"></td>
            </tr>

        <?php endif; ?>
    </tbody>
</table>






<script>
var currentRates = getCurrentRates();

function getCurrentRates(){
    const values = <?php 

        echo json_encode($overtimeRates); 
        ?>;
    return values;
}
</script>