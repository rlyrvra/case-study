<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
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
        <a href="smartWage-index.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
        </a>
    </li>

    <!-- Departments -->
    <?php
    if($_SESSION['access_role'] == 'Admin'){
        echo '
    <li class="menu-item" id="departments-menu">
    <a href="departments.php" class="menu-link ">
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
    <a href="job-titles.php" class="menu-link">
    <i class="menu-icon tf-icons bx bx-vector"></i>
        <div data-i18n="Account Settings">Job Title </div>
    
    </a>
        
    </li>
    ';
    }
    ?>

    <!-- Employees -->
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Authentications">Employees</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="auth-login-basic.html" class="menu-link" target="_blank">
            <div data-i18n="Basic">Add Employee</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="auth-register-basic.html" class="menu-link" target="_blank">
            <div data-i18n="Basic">Manage Employee</div>
            </a>
        </li>
        
        </ul>
    </li>

    <!-- Attendance -->
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-calendar"></i>
        <div data-i18n="Misc">Attendance</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="pages-misc-error.html" class="menu-link">
            <div data-i18n="Error">My Attendance</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="pages-misc-under-maintenance.html" class="menu-link">
            <div data-i18n="Under Maintenance">Attendance</div>
            </a>
        </li>
        
        <li class="menu-item">
            <a href="pages-misc-under-maintenance.html" class="menu-link">
            <div data-i18n="Under Maintenance">Shift Schedules</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="pages-misc-under-maintenance.html" class="menu-link">
            <div data-i18n="Under Maintenance">Overtime Rates</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="pages-misc-under-maintenance.html" class="menu-link">
            <div data-i18n="Under Maintenance">Holidays</div>
            </a>
        </li>

        </ul>
    </li>

    
    

    <!-- Leaves -->
    <li class="menu-item" id="leaves-menu">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
        <div data-i18n="User interface">Leaves</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="ui-accordion.html" class="menu-link">
            <div data-i18n="Accordion">Leave Types</div>
            </a>
        </li>
        <li class="menu-item" id="apply-leave-menu">
            <a href="apply-leave.php" class="menu-link">
            <div data-i18n="Alerts">Apply Leave</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="ui-badges.html" class="menu-link">
            <div data-i18n="Badges">My Leaves</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="ui-buttons.html" class="menu-link">
            <div data-i18n="Buttons">Leave Request</div>
            </a>
        
        </li>
        </ul>
    </li>

    
    <!-- Payroll -->
    <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-money"></i>
        <div data-i18n="Form Elements">Payroll</div>
        </a>
        <ul class="menu-sub">
        <li class="menu-item">
            <a href="forms-basic-inputs.html" class="menu-link">
            <div data-i18n="Basic Inputs">My Payslips</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="forms-input-groups.html" class="menu-link">
            <div data-i18n="Input groups">Generate Payslips</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="forms-input-groups.html" class="menu-link">
            <div data-i18n="Input groups">Payroll Groups</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="forms-input-groups.html" class="menu-link">
            <div data-i18n="Input groups">Allowances</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="forms-input-groups.html" class="menu-link">
            <div data-i18n="Input groups">Deductions</div>
            </a>
        </li>
        
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
            <a href="form-layouts-vertical.html" class="menu-link">
            <div data-i18n="Vertical Form">Company Profile</div>
            </a>
            
        

        </li>

        <li class="menu-item" id="government-tables-menu">
            <a href="form-layouts-horizontal.html" class="menu-link menu-toggle">
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
        <a href="/case-study/requests/login/logout.php" class="menu-link">
        <i class="menu-icon tf-icons bx bx-log-out"></i>
        <div data-i18n="Tables">Log Out</div>
        </a>
    </li>
    </ul>
</aside>
<!-- / Menu -->