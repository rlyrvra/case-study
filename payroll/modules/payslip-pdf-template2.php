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
    top: 45%;
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
    <strong>Company Name</strong><br>
    Payslip Report | March 2025
</div>
<div id="payslip">
	<div id="scope">
		<div class="scope-entry">
			<div class="title">PAY RUN</div>
			<div class="value">Mar 15, 2015</div>
		</div>
		<div class="scope-entry">
			<div class="title">PAY PERIOD</div>
			<div class="value">Mar 1 - Mar 15, 2015</div>
		</div>
	</div>
	<div class="content">
		<div class="left-panel">
			<div id="employee">
				<div id="name">
					Piven El'Sync
				</div>
				<div id="email">
					mary.ann+Regr06@salarium.com
				</div>
			</div>
			<div class="details">
				<div class="entry">
					<div class="label">Employee ID</div>
					<div class="value">Reg-006</div>
				</div>
				<div class="entry">
					<div class="label">Tax Status</div>
					<div class="value">Married - 2 Dependents</div>
				</div>
				<div class="entry">
					<div class="label">Hourly Rate</div>
					<div class="value">1,023.68</div>
				</div>
				<div class="entry">
					<div class="label">Company Name</div>
					<div class="value">Not a Shady One</div>
				</div>
				<div class="entry">
					<div class="label">Date Hired</div>
					<div class="value">Dec 1, 1862</div>
				</div>
				<div class="entry">
					<div class="label">Position</div>
					<div class="value">Point Guard</div>
				</div>
				<div class="entry">
					<div class="label">Department</div>
					<div class="value">1st String</div>
				</div>
				<div class="entry">
					<div class="label">Rank</div>
					<div class="value">MVP</div>
				</div>
				<div class="entry">
					<div class="label">Payroll Cycle</div>
					<div class="value">Semi-Monthly</div>
				</div>
				<div class="entry">
					<div class="label">TIN</div>
					<div class="value">123-123-123-123</div>
				</div>
				<div class="entry">
					<div class="label">SSS</div>
					<div class="value">12-3123123-1</div>
				</div>
				<div class="entry">
					<div class="label">Philhealth</div>
					<div class="value">12-312312312-3</div>
				</div>
				<div class="entry">
					<div class="label">Generated by:</div>
					<div class="value">Piven Himself</div>
				</div>
			</div>
		</div>
		<div class="right-panel">
            <div class="details">
                <div class="basic-pay">
                    <div class="entry">
                        <div class="label" style="font-weight: bold;">Basic Pay</div>
                        <div class="detail"></div>
                        <div class="rate">45,000.00/Month</div>
                        <div class="amount">45,000.00</div>
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
						<div class="amount">581.30</div>
					</div>
					<div class="entry">
						<div class="label"></div>
						<div class="detail" style="font-weight: bold;">PhilHealth</div>
						<div class="rate"></div>
						<div class="amount">437.50</div>
					</div>
				</div>
                <div class="nti" style="font-size: 14px;
                                        font-weight: bold;
                                        margin-bottom: 1%;">
					<div class="entry">
						<div class="label" style="font-weight: bold;">TAXABLE INCOME</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount">(82,705.06)</div>
					</div>
				</div>
                <div class="withholding_tax">
					<div class="entry">
						<div class="label" style="font-weight: bold;">Withholding Tax</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount">3333.33</div>
					</div>
				</div>
                <div class="net_pay" style="font-size: 20px;
                                        font-weight: bold;
                                        margin-bottom: 1%;">
					<div class="entry">
						<div class="label">NET PAY</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount">(69,656.21)</div>
					</div>
				</div>
            </div>
		</div>
	</div>
</div>
<!-- Footer -->
<div class='pdf-footer'>
    <small>Page 1 of 1</small> <br>
    <small>Payslip generated at Monday, March 10, 2025, 11:08 PM using smartWage</small>
</div>
</body>
</html>