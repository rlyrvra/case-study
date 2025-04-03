<style>
  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 10px;
  }
  
  th,
  td {
    border: 1px solid black;
    padding: 3px;
    text-align: center;
  }

  th {
    background-color: #f2f2f2;
  }

  h2 {
    font-size: 16px;
  }

  /* Custom Header/Footer */
  .pdf-header {
    position: fixed;
    top: -10px;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 12px;
    color: #6c757d;
  }

  .pdf-footer {
    position: fixed;
    bottom: -10px;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 12px;
    color: #6c757d;
  }

  /* General Styling for the Header */
  .company-header {
    font-family: Arial, sans-serif;
    margin: 20px 0;
    padding: 10px;
    border-bottom: 2px solid #000;
  }

  .company-logo {
    display: inline-block;
    vertical-align: top;
    margin-right: 20px;
  }

  .logo-img {
    width: 100px;
    /* Adjust size as needed */
    height: auto;
    border-radius: 50%;
    /* Circular image */
  }

  .company-info {
    display: inline-block;
    vertical-align: top;
    max-width: 500px;
    /* Adjust width if necessary */
  }

  .company-name {
    font-size: 18px;
    font-weight: bold;
  }

  .industry-info {
    font-size: 14px;
    color: #555;
    margin-top: 5px;
  }

  .address {
    font-size: 12px;
    margin-top: 5px;
  }

  .contact-info {
    font-size: 12px;
    color: #555;
    margin-top: 5px;
  }

  .contact-info a {
    color: #1a73e8;
    text-decoration: none;
  }
</style>
<!-- Header -->
<div class='pdf-header'>
  <strong><?php echo htmlspecialchars($companyProfileData[0]['name']); ?></strong><br>
  Attendance Report | <?php echo htmlspecialchars(date("F Y", strtotime($myAttendance[0]['date']))); ?>
</div>
<!-- Company Info Header -->
<div class="company-header">
  <?php
  $imagePath = 'C:/xampp/htdocs/case-study/uploads/company_logo.jpg';
  $encodedPath = urlencode($imagePath);
  $absolutePath = $companyProfileData[0]['img_location'];
  $fileUrl = 'file:///' . str_replace('\\', '/', $absolutePath); // Make sure to use forward slashes for paths in DOMPDF
  //echo $fileUrl;
  $imageData = base64_encode(file_get_contents($absolutePath));
  $src = 'data:image/jpg;base64,' . $imageData;
  ?>
  <div class="company-logo">
    <img src="<?php echo $src; ?>" class="logo-img">
  </div>
  <div class="company-info">
    <div class="company-name">
      <strong><?php echo htmlspecialchars($companyProfileData[0]['name']); ?></strong>,
      <?php echo htmlspecialchars($companyProfileData[0]['business_type']); ?>
    </div>
    <div class="industry-info">
      <?php echo htmlspecialchars($companyProfileData[0]['industry']); ?> |
      <?php echo date("Y", strtotime($companyProfileData[0]['date_established'])); ?> -
      <?php echo date("F Y"); ?>
    </div>
    <div class="address">
      <?php echo htmlspecialchars($companyProfileData[0]['address']); ?>
    </div>
    <div class="contact-info">
      <?php echo htmlspecialchars($companyProfileData[0]['phone']); ?> |
      <?php echo htmlspecialchars($companyProfileData[0]['email']); ?> |
      <?php echo htmlspecialchars($companyProfileData[0]['website']); ?>
    </div>
  </div>
</div>
<h2 style='text-align:center;'>Attendance Report - Attendance</h2>
<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Date</th>
      <th>Day of Week</th>
      <th>Check In Time</th>
      <th>Check Out Time</th>
      <th>Total Break Duration</th>
      <th>Total Hours Worked</th>
      <th>Late Check In</th>
      <th>Early Check Out</th>
      <th>Overtime Hours</th>
      <th>Overtime Approval</th>
      <th>Status</th>
      <th>Remarks</th>
    </tr>
  </thead>
  <tbody>
  <?php if(!empty($myAttendance)): ?>
    <?php foreach ($myAttendance as $index => $attendance): ?>
      <?php if ($index > 0 && $index % 30 === 0): ?>
        <!-- </tbody></table>
        <div style="page-break-after: always;"></div>
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Date</th>
              <th>Day of Week</th>
              <th>Check In Time</th>
              <th>Check Out Time</th>
              <th>Total Break Duration</th>
              <th>Total Hours Worked</th>
              <th>Late Check In</th>
              <th>Early Check Out</th>
              <th>Overtime Hours</th>
              <th>Overtime Approval</th>
              <th>Status</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody> -->
      <?php endif; ?>


      <tr>
        <td><?= $index + 1 ?></td>
        <td><?= htmlspecialchars(date("F j, Y", strtotime($attendance['date']))) ?? '' ?></td>
        <td><?= isset($attendance['date']) ? date('l', strtotime($attendance['date'])) : '' ?></td>
        <td><?= !empty($attendance['check_in_time']) ? htmlspecialchars(date("h:i:s A", strtotime($attendance['check_in_time']))) : '' ?></td>
        <td><?= !empty($attendance['check_out_time']) ? htmlspecialchars(date("h:i:s A", strtotime($attendance['check_out_time']))) : '' ?></td>
        <td><?= $attendance['total_break_duration_in_minutes'] ?? '' ?></td>
        <td><?= $attendance['total_hours_worked'] ?? '' ?></td>
        <td><?= $attendance['late_check_in'] ?? '' ?></td>
        <td><?= $attendance['early_check_out'] ?? '' ?></td>
        <td><?= $attendance['overtime_hours'] ?? '' ?></td>
        <td><?= isset($attendance['is_overtime_approved']) ? ($attendance['is_overtime_approved'] ? 'Yes' : 'No') : '' ?></td>
        <td><?= $attendance['attendance_status'] ?? '' ?></td>
        <td><?= $attendance['remarks'] ?? '' ?></td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="12">No Data Available</td>
    </tr>
  <?php endif ?>
  </tbody>
</table>

<!-- Footer -->
<div class='pdf-footer'>
  <hr>
  <small class="footer-text">This is a system-generated attendance card. No signature is required.</small> |
  <small class="footer-text">For inquiries, contact HR at <strong><?php echo htmlspecialchars($companyProfileData[0]['email']); ?></strong> or call <strong><?php echo htmlspecialchars($companyProfileData[0]['phone']); ?></strong>.</small> <br>
  <small>Page <?php $c = 1;
              echo $c;
              $c++ ?> of 2</small> <br>
  <small>Attendance card generated at <?php echo date('l, F j, Y, g:i A'); ?> using smartWage</small>
</div>

<div style="page-break-after: always;"></div>
<br>
<h2 style='text-align:center;'>Attendance Report - Breaks</h2>
<table>
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
    <?php foreach ($myBreaks as $index => $rowBreak): ?>
      <?php if ($index > 0 && $index % 30 === 0): ?>
        </tbody></table>
        <div style="page-break-after: always;"></div>
        <table>
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
      <?php endif; ?>


      <tr>
        <?php if (empty($rowBreak['start_time'])) {
          continue;
        } ?>
        <td><?= $index + 1 ?></td>
        <td>
          <?php echo htmlspecialchars($rowBreak['break_type_snapshot_name']); ?>
        </td>
        <td>
          <?php echo htmlspecialchars(date("F j, Y", strtotime($rowBreak['start_time']))); ?>
        </td>
        <td>
          <?php echo !empty($rowBreak['start_time']) ? htmlspecialchars(date("h:i:s A", strtotime($rowBreak['start_time']))) : ''; ?>
        </td>
        <td>
          <?php echo !empty($rowBreak['end_time']) ? htmlspecialchars(date("h:i:s A", strtotime($rowBreak['end_time']))) : ''; ?>
        </td>
        <td>
          <?php echo htmlspecialchars($rowBreak['break_duration_in_minutes']); ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>