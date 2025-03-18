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
    Department Report | <?php echo date("F Y"); ?>
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
<h2 style='text-align:center;'>Department Report - Records</h2>
<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Department Head</th>
      <th>Description</th>
      <th>Status</th>
      <th>Date Created</th>
      <th>Date Updated</th>
      <?php if($status === 'Archived'):?><th>Deleted At</th><?php endif ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($departments as $index => $department): ?>
      <?php if ($index > 0 && $index % 30 === 0): ?>
        
      <?php endif; ?>


      <tr>
        <td><?= $index + 1 ?></td>
        <td><?= $department['name'] ?? '' ?></td>
        <td><?= !empty($department['department_head_full_name']) ? $department['department_head_full_name'] : 'UNASSIGNED' ?></td>
        <td><?= $department['description'] ?? '' ?></td>
        <td><?= $department['status'] ?? '' ?></td>
        <td><?= date("l, F j, Y, g:i A", strtotime($department['created_at'])) ?? '' ?></td>
        <td><?= date("l, F j, Y, g:i A", strtotime($department['updated_at'])) ?? '' ?></td>
        <?php if(!empty($department['deleted_at'])):?><td><?= date("l, F j, Y, g:i A", strtotime($department['deleted_at'])) ?? '' ?></td><?php endif ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Footer -->
<div class='pdf-footer'>
  <hr>
  <small class="footer-text">This is a system-generated report. No signature is required.</small> |
  <small class="footer-text">For inquiries, contact HR at <strong><?php echo htmlspecialchars($companyProfileData[0]['email']); ?></strong> or call <strong><?php echo htmlspecialchars($companyProfileData[0]['phone']); ?></strong>.</small> <br>
  <small>Report generated at <?php echo date('l, F j, Y, g:i A'); ?> using smartWage by <?php echo htmlspecialchars($_SESSION['full_name']); ?></small>
</div>