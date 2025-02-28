<style>
.green{
    background-color: rgb(22, 66, 60) !important;
}
.no-shadow{
    box-shadow: none !important;
}
.transparent{
    background-color: transparent !important;
    backdrop-filter: none !important;
}
</style>
<!-- Navbar -->
<div class="container-fluid green pb-3">
    <nav
    class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme transparent no-shadow"
    >
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" style="color: #F3F4F6;">
            <i class="bx bx-menu bx-lg"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <!-- <div class="navbar-nav align-items-center w-100">
                <div class="input-group nav-item d-flex align-items-center w-100">
                <span class="input-group-text"><i class="bx bx-search fs-4 lh-0"></i></span>
                <input
                    type="text"
                    class="form-control border-0 shadow-none text-center"
                    placeholder="Search..."
                    aria-label="Search..."
                />
                </div>
            </div> -->
            <!-- /Search -->
             
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                    <?php 
                        if(!isset($_SESSION['profile_picture'])){
                            echo "<img src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=200' alt='Profile Picture' class='w-px-35 h-auto rounded-circle' />";
                            return;
                        }
                        // Render the image
                        $imageData = $_SESSION['profile_picture'];

                        echo "<img src='data:image/jpg;base64,$imageData' alt='Profile Picture' class='w-px-35 h-auto rounded-circle' />";
                    ?>
                    </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <div class="p-1 d-flex">
                            <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                            <?php 
                                if(!isset($_SESSION['profile_picture'])){
                                    echo "<img src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=200' alt='Profile Picture' class='w-px-35 h-auto rounded-circle' />";
                                    return;
                                }
                                // Render the image
                                $imageData = $_SESSION['profile_picture'];

                                echo "<img src='data:image/jpg;base64,$imageData' alt='Profile Picture' class='w-px-35 h-auto rounded-circle' />";
                            ?>
                            </div>
                            </div>
                            <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?php echo htmlspecialchars($_SESSION['full_name'])?></span>
                            <small class="text-muted"><?php echo htmlspecialchars($_SESSION['access_role'])?></small>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="window.location.href='add-employee?m=v&token=<?php echo htmlspecialchars(hash('sha256', ($_SESSION['id']))); ?>'">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">My Profile</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" class="menu-link" onclick="confirmLogout();">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                    </ul>
                </li>
            <!--/ User -->
            </ul>
        </div>
    </nav>
</div>

<?php ob_end_flush(); ?>