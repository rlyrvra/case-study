<!DOCTYPE html>
<html xml:lang="en" lang="en"><head><meta http-equiv="content-type" content="text/html; charset=UTF-8">
<style type="text/css">
@page { 
    size: A4 landscape; 
    margin: 20px;
}

body {
    background: #fff;
    font-family: Arial, sans-serif;
    font-size: 12px;
    color: #444;
    margin: 0;
    padding: 0;
}

#payslip {
    width: 270mm;  /* Adjusted for A4 landscape */
    padding: 20px;
    background: #fff;
    border: 1px solid #ccc;
    margin: auto;
    position: absolute;
    top: 47.5%;
    left: 47.5%;
    transform: translate(-50%, -47.5%);
}

#title {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 15px;
}

#scope {
    border-top: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    padding: 10px 0;
    text-align: center;
}

#scope .scope-entry {
    display: inline-block;
    width: 45%;
    vertical-align: top;
    text-align: center;
    font-weight: bold;
}

.content {
    border-bottom: 1px solid #ccc;
    padding: 10px 0;
}

.left-panel, .right-panel {
    display: inline-block;
    vertical-align: top;
}

.left-panel {
    float: left;
    border-right: 1px solid #ccc;
    width: 35%;
    padding-right: 15px;
}

.right-panel {
    float: left;
    width: 65%;
    padding-left: 15px;
}

.right-panel .details {
	width: 100%;
}

#employee {
	text-align: center;
	margin-bottom: 20px;
}
#employee #name {
	font-size: 15px;
	font-weight: 700;
}

#employee #email {
	font-size: 11px;
}

.details, .contributions, .ytd, .gross, .salary, .leaves, .taxable_allowance, .taxable_bonus, .contributions, .nti, .withholding_tax, .non_taxable_allowance, .non_taxable_bonus {
    margin-bottom: 2%;
}

.entry {
    width: 100%;
    padding-bottom: 1%;
}

.entry .label {
    width: 40%;
    text-align: left;
    display: inline-block;
}

.entry .value {
    font-weight: bold;
    text-align: right;
    width: 58%;
    display: inline-block;
}

.gross .entry .value {
    font-size: 14px;
    font-weight: bold;
    text-align: right;
}

.contributions .title, .ytd .title, .gross .title, .salary .title, .leaves .title, .taxable_allowance .title, .taxable_bonus .title, .contributions .title, .nti .title, .withholding_tax .title, .non_taxable_allowance .title, .non_taxable_bonus .title {
    font-size: 14px;
    font-weight: bold;
    border-bottom: 1px solid #ccc;
    padding-bottom: 1%;
    margin-bottom: 1%;
    background: rgba(0, 0, 0, 0.04);
}

/** 
<div class="label">Basic Pay</div>
<div class="detail"></div>
<div class="rate">45,000.00/Month</div>
<div class="amount">45,000.00</div>
*/

.right-panel .detail{
    width: 15%;
    display: inline-block;
}

.right-panel .rate {
    width: 20%;
    text-align: right;
    font-style: italic;
    letter-spacing: 1px;
    display: inline-block;
}

.right-panel .amount {
    width: 15%;
    text-align: right;
    display: inline-block;
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
    width: 100px; /* Adjust size as needed */
    height: auto;
    border-radius: 50%; /* Circular image */
}

.company-info {
    display: inline-block;
    vertical-align: top;
    max-width: 500px; /* Adjust width if necessary */
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

/* To prevent collapsing due to float */
.content::after {
    content: "";
    display: table;
    clear: both;
}
</style></head>
<body>
<!-- Header -->
<div class='pdf-header'>
    <strong><?php echo htmlspecialchars($companyProfileData[0]['name']); ?></strong><br>
    Payslip Report | <?php echo date("F Y", strtotime($row['pay_date'])); ?>
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
            <?php echo date("Y", strtotime($row['pay_date'])); ?>
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
<div id="payslip">
	<div id="scope">
		<div class="scope-entry">
			<div class="title">PAY DATE</div>
			<div class="value"><?php echo date("M j, Y", strtotime($row['pay_date'])); ?></div>
		</div>
		<div class="scope-entry">
			<div class="title">PAY PERIOD</div>
			<div class="value"><?php echo date("M j, Y", strtotime($row['pay_period_start_date'])); ?> - <?php echo date("M j, Y", strtotime($row['pay_period_end_date'])); ?></div>
		</div>
	</div>
	<div class="content">
		<div class="left-panel">
			<div id="employee">
				<div id="name">
					<?php echo htmlspecialchars($row['full_name']); ?>
				</div>
				<div id="email">
					<?php echo htmlspecialchars($row['email_address']); ?>
				</div>
			</div>
			<div class="details">
				<div class="entry">
					<div class="label">Employee Code</div>
					<div class="value"><?php echo htmlspecialchars($row['employee_code']); ?></div>
				</div>
				<div class="entry">
					<div class="label">Employment Type</div>
					<div class="value"><?php echo htmlspecialchars($row['employment_type']); ?></div>
				</div>
				<div class="entry">
					<div class="label">Company Name</div>
					<div class="value"><?php echo htmlspecialchars($companyProfileData[0]['name']); ?></div>
				</div>
				<div class="entry">
					<div class="label">Date Hired</div>
					<div class="value"><?php echo date("M j, Y", strtotime($row['date_of_hire'])); ?></div>
				</div>
				<div class="entry">
					<div class="label">Department</div>
					<div class="value"><?php echo htmlspecialchars($row['department_name']); ?></div>
				</div>
				<div class="entry">
					<div class="label">Position</div>
					<div class="value"><?php echo htmlspecialchars($row['job_title_title']); ?></div>
				</div>
				<div class="entry">
					<div class="label">Rank</div>
					<div class="value"><?php echo htmlspecialchars($row['access_role']); ?></div>
				</div>
				<div class="entry">
					<div class="label">Payroll Cycle</div>
					<div class="value"><?php echo htmlspecialchars($row['payroll_frequency']); ?></div>
				</div>
				<div class="entry">
					<div class="label">TIN</div>
					<div class="value"><?php echo htmlspecialchars($row['tin_number']); ?></div>
				</div>
				<div class="entry">
					<div class="label">SSS</div>
					<div class="value"><?php echo htmlspecialchars($row['sss_number']); ?></div>
				</div>
				<div class="entry">
					<div class="label">Philhealth</div>
					<div class="value"><?php echo htmlspecialchars($row['philhealth_number']); ?></div>
				</div>
				<div class="entry">
					<div class="label">Pag-IBIG</div>
					<div class="value"><?php echo htmlspecialchars($row['pagibig_fund_number']); ?></div>
				</div>
				<div class="entry">
					<div class="label">Generated by:</div>
					<div class="value"><?php echo htmlspecialchars($_SESSION['full_name']); ?></div>
				</div>
			</div>
		</div>
		<div class="right-panel">
            <div class="details">
                <div class="basic-pay">
                    <div class="entry">
                        <div class="label" style="font-weight: bold;">Basic Pay</div>
                        <div class="detail"></div>
                        <div class="rate"><?php echo number_format($row['basic_salary'], 2); ?>/Month</div>
                        <div class="amount"><?php echo number_format($row['basic_salary'], 2); ?></div>
                    </div>
                </div>
                <div class="salary">
					<div class="entry">
						<div class="label" style="font-weight: bold;">Salary</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"></div>
					</div>
                </div>
                <div class="contributions">
					<div class="entry">
						<div class="label" style="font-weight: bold;">Contributions</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"></div>
					</div>
					<div class="entry">
						<div class="label"></div>
						<div class="detail" style="font-weight: bold;">SSS</div>
						<div class="rate"></div>
						<div class="amount"><?php echo number_format($row['sss_deduction'], 2); ?></div>
					</div>
					<div class="entry">
						<div class="label"></div>
						<div class="detail" style="font-weight: bold;">PhilHealth</div>
						<div class="rate"></div>
						<div class="amount"><?php echo number_format($row['philhealth_deduction'], 2); ?></div>
					</div>
					<div class="entry">
						<div class="label"></div>
						<div class="detail" style="font-weight: bold;">Pag-IBIG</div>
						<div class="rate"></div>
						<div class="amount"><?php echo number_format($row['pagibig_fund_deduction'], 2); ?></div>
					</div>
				</div>
                <div class="nti" style="font-size: 14px;
                                        font-weight: bold;
                                        margin-bottom: 1%;">
					<div class="entry">
						<div class="label" style="font-weight: bold;">TAXABLE INCOME</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"></div>
					</div>
				</div>
                <div class="withholding_tax">
					<div class="entry">
						<div class="label" style="font-weight: bold;">Withholding Tax</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?php echo number_format($row['withholding_tax'], 2); ?></div>
					</div>
				</div>
                <div class="net_pay" style="font-size: 20px;
                                        font-weight: bold;
                                        margin-bottom: 1%;">
					<div class="entry">
						<div class="label">NET PAY</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount">(<?php echo number_format($row['gross_pay'], 2); ?>)</div>
					</div>
				</div>
            </div>
		</div>
	</div>
</div>
<!-- Footer -->
<div class='pdf-footer'>
	<hr>
	<p class="footer-text">This is a system-generated payslip. No signature is required.</p>
    <p class="footer-text">For inquiries, contact HR at <strong><?php echo htmlspecialchars($companyProfileData[0]['email']); ?></strong> or call <strong><?php echo htmlspecialchars($companyProfileData[0]['phone']); ?></strong>.</p>
    <p class="footer-company">© <?php echo date('Y'); ?> <?php echo htmlspecialchars($companyProfileData[0]['name']); ?> | Confidential</p>
    <small>Page 1 of 1</small> <br>
    <small>Payslip generated at <?php echo date('l, F j, Y, g:i A'); ?> using smartWage</small>
</div>
</body>
</html>