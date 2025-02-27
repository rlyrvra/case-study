<!-- Menu -->
<script src="requests/login/logout.js"></script>
<?php ob_start(); ?>
<!-- <aside id="layout-menu" class="position-sticky layout-menu menu-vertical menu bg-menu-theme top-0 vh-100"> -->
<aside id="layout-menu" class="position-sticky layout-menu menu-vertical menu bg-menu-theme top-0 vh-100">
    <div class="app-brand demo">
    <a href="index.php" class="app-brand-link">
        <span class="app-brand-logo demo">
        
        </span>
        <span class="app-brand-text demo menu-text fw-bolder ms-2">smartWAGE</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item" id="dashboard-menu">
        <a href="smartWage-index" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    <!-- Departments -->
    <?php
    if($_SESSION['access_role'] == 'Admin'){
        echo '
    <li class="menu-item" id="departments-menu">
    <a href="department" class="menu-link ">
    <i class="menu-icon tf-icons bx bx-layout"></i>
    <div data-i18n="Layouts">Departments</div>
    </a>

    </li>
        ';
    }
    ?>

    <!-- Job Title -->
    <?php
    if($_SESSION['access_role'] == 'Admin'){
        echo '
    <li class="menu-item" id="job-titles-menu">
    <a href="job-title" class="menu-link">
    <i class="menu-icon tf-icons bx bx-vector"></i>
        <div>Job Titles </div>
    
    </a>
        
    </li>
    ';
    }
    ?>

    <!-- Employees -->
    <?php
    if($_SESSION['access_role'] == 'Admin' || $_SESSION['access_role'] == 'Manager'){
        echo '
    <li class="menu-item" id="employees-menu">

        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div>Employees</div>
        </a>
        
        <ul class="menu-sub">
        <li class="menu-item" id="add-employees-menu">
            <a href="add-employee" class="menu-link">
            <div>Add Employee</div>
            </a>
        </li>
        <li class="menu-item" id="manage-employees-menu">
            <a href="manage-employee" class="menu-link">
            <div>Manage Employee</div>
            </a>
        </li>
        
        </ul>
    </li>';
    }
    ?>

    <!-- Attendance -->
    <li class="menu-item" id="attendance-menu">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-calendar"></i>
        <div data-i18n="Misc">Attendance</div>
        </a>
        <ul class="menu-sub">
        <?php
        if($_SESSION['access_role'] != 'Admin'){
        echo '
        <li class="menu-item" id="my-attendance-menu">
            <a href="my-attendance" class="menu-link">
            <div>My Attendance</div>
            </a>
        </li>';
        }
        ?>
        <li class="menu-item">
            <a href="maintenance-login" class="menu-link">
            <div data-i18n="Under Maintenance">Attendance</div>
            </a>
        </li>
        
        <li class="menu-item" id="work-schedules-menu">
            <a href="work-schedule.php" class="menu-link">
            <div>Work Schedules</div>
            </a>
        </li>

        <li class="menu-item" id="overtime-rate-menu">
            <a href="overtime-rate.php" class="menu-link">
            <div>Overtime Rates</div>
            </a>
        </li>
        <?php
        if($_SESSION['access_role'] == 'Admin' || $_SESSION['access_role'] == 'Manager'){
        echo '
        <li class="menu-item" id="holiday-menu">
            <a href="holiday" class="menu-link">
            <div>Holidays</div>
            </a>
        </li>';
        }
        ?>

        </ul>
    </li>

    
    

    <!-- Leaves -->
    <li class="menu-item" id="leaves-menu">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
        <div data-i18n="User interface">Leaves</div>
        </a>
        <ul class="menu-sub">
        <?php
        if($_SESSION['access_role'] == 'Admin'){
        echo '
        <li class="menu-item" id="leave-types-menu">
            <a href="leave-types" class="menu-link">
            <div data-i18n="Accordion">Leave Types</div>
            </a>
        </li>
        ';
        }
        ?>
        <?php
        if($_SESSION['access_role'] != 'Admin'){
        echo '
        <li class="menu-item" id="apply-leave-menu">
            <a href="apply-leave" class="menu-link">
            <div data-i18n="Alerts">Apply Leave</div>
            </a>
        </li>
        <li class="menu-item" id="leave-requests-menu">
            <a href="leave-requests" class="menu-link">
            <div data-i18n="Buttons">Leave Requests</div>
            </a>
        
        </li>';
        }
        ?>
        </ul>
    </li>

    
    <!-- Payroll -->
    <li class="menu-item" id="payroll-menu">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-money"></i>
        <div>Payroll</div>
        </a>
        <ul class="menu-sub">
        <?php
        if($_SESSION['access_role'] != 'Admin'){
        echo '
        <li class="menu-item">
            <a href="maintenance-login" class="menu-link">
            <div data-i18n="Basic Inputs">My Payslips</div>
            </a>
        </li>
        ';
        }
        ?>
        <?php
        if($_SESSION['access_role'] == 'Admin' || $_SESSION['access_role'] == 'Manager'){
        echo '
        <li class="menu-item" id="payrollGroup-menu">
            <a href="payroll-group" class="menu-link">
            <div>Payroll Groups</div>
            </a>
        </li>
        
        <li class="menu-item" id="allowances-menu">
            <a href="allowance" class="menu-link">
            <div>Allowances</div>
            </a>
        </li>

        <li class="menu-item" id="deductions-menu">
            <a href="deduction" class="menu-link">
            <div data-i18n="Input groups">Deductions</div>
            </a>
        </li>
        ';
        }
        ?>
        </ul>
    </li>

    <!-- Settings -->
    <li class="menu-item" id="settings-menu">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Form Layouts">Settings</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="companyprofile" class="menu-link">
            <div>Company Profile</div>
            </a>
            
        

        </li>

        <li class="menu-item" id="government-tables-menu">
            <a class="menu-link menu-toggle">
            <div data-i18n="Horizontal Form">Government Tables</div>
            
            </a>
            
            <ul class="menu-sub">
        <li class="menu-item" id="sss-menu">
            <a href="table-sss.php" class="menu-link">
            <div data-i18n="Vertical Form">SSS</div>
            </a>
            </ul>
            
            <ul class="menu-sub">
        <li class="menu-item" id="pagibig-menu">
            <a href="table-pagibig.php" class="menu-link">
            <div data-i18n="Vertical Form">Pag-IBIG Fund</div>
            </a>
            </ul>

            <ul class="menu-sub">
        <li class="menu-item" id="philhealth-menu">
            <a href="table-philhealth.php" class="menu-link">
            <div data-i18n="Vertical Form">Philhealth</div>
            </a>
            </ul>

            <ul class="menu-sub">
        <li class="menu-item" id="withholding-tax-menu">
            <a href="table-withholding-tax.php" class="menu-link">
            <div data-i18n="Vertical Form">Withholding Tax</div>
            </a>
            </ul>

        </li>
        </ul>
    </li>

    <!-- Log Out -->
    <li class="menu-item">
        <a href="#" class="menu-link" onclick="confirmLogout();">
        <i class="menu-icon tf-icons bx bx-log-out"></i>
        <div>Log Out</div>
        </a>
    </li>
    </ul>
</aside>
<!-- / Menu -->