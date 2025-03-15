<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Lobster&display=swap" rel="stylesheet">

    <title>Welcome to smartWage - Simplify Your Payroll Today</title>
    <link rel="icon" type="image/x-icon" href="img/logo-files/logo1.ico" />

    <script src="https://kit.fontawesome.com/e82c3ed260.js" crossorigin="anonymous"></script>
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- SimpleMDE for text editors -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css"/>
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js" defer></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: #2f4f4f;
        }

        /* Sticky Navigation Bar */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #052a06;
            padding: 10px 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 100px;
        }

        .nav-link:hover {
            color: rgba(88, 232, 119, 1) !important;
            background: rgba(88, 232, 119, 0.1) !important;
            border-radius: 10px;
        }

        .navbar-nav {
            --bs-nav-link-hover-color: rgba(88, 232, 119, 1) !important;
        }



        .hero {
            background: url('img/ezgif.com-animated-gif-maker.gif') no-repeat center center/cover;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 50px 20px;
            height: 100vh;
            position: relative;
        }

        .hero::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero-text {
            max-width: 50%;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .hero img {
            max-width: 40%;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background-color: #052a06;
            border: none;
        }

        .btn-primary:hover {
            background-color: #052a06;
        }

        .about-us,
        .principles,
        .compliance {
            padding: 60px 20px;
        }

        .about-us {
            padding: 60px 0;
            background-color: #dbe1dc;
        }

        .about-us h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .about-us p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 40px;
        }

        .about-us .card {
            border: none;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .about-us .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .about-us .card img {
            border-radius: 10px;
            max-height: 150px;
            object-fit: cover;
        }

        .about-us .card h5 {
            font-size: 1.4rem;
            font-weight: bold;
            margin: 15px 0;
        }

        .about-us .card p {
            font-size: 1rem;
            color: #555;
        }

        @media (max-width: 768px) {
            .about-us .card {
                margin-bottom: 20px;
            }
        }





        .slide-in {
            transform: translateX(100%);
            opacity: 0;
            transition: transform 1s ease, opacity 1s ease;
        }




        .principles {
            background-color: #f1f8f5;
        }

        .compliance {
            background-color: #e8f5e9;
        }

        h2,
        h3,
        h4 {
            color: #052a06;
        }

        .card {
            border: none;
            transition: transform 0.2s ease, opacity 0.3s ease, background-color 0.3s;
            opacity: 0;
            transform: translateY(50px);
        }

        .btn-light {
            --bs-btn-color: #631212;
            --bs-btn-bg: #052a06;
            --bs-btn-border-color: #f8f9fa;
            --bs-btn-hover-color: #212529;
            --bs-btn-hover-bg: #d3d4d5;
            --bs-btn-hover-border-color: #c6c7c8;
            --bs-btn-focus-shadow-rgb: 211, 212, 213;
            --bs-btn-active-color: #000;
            --bs-btn-active-bg: #c6c7c8;
            --bs-btn-active-border-color: #babbbc;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #000;
            --bs-btn-disabled-bg: #f8f9fa;
            --bs-btn-disabled-border-color: #f8f9fa;
        }

        .card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .card:hover {
            background-color: #d7ffd9;
            transform: scale(1.05);
        }

        footer {
            background-color: #052a06;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        footer a {
            color: #a5d6a7;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                text-align: center;
            }

            .hero-text {
                max-width: 100%;
            }

            .hero img {
                max-width: 100%;
                margin-top: 20px;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
            }
        }

        #contact-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        #contact-links a {
            color: #052a06;
            font-size: 1.5rem;
        }

        #contact-links a:hover {
            color: #2d6a4f;
        }

        .header {
            display: flex;
            justify-content: flex-end;
            padding: 10px;
            background-color: #f3f3f3;
            /* Example background */
        }

        .login-button {
            padding: 10px 20px;
            background-color: #052a06;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-button:hover {
            background-color: #052a06;
        }

        .animated-card {
            transform: translateX(-50px);
            opacity: 0;
            transition: all 0.8s ease-in-out;
        }

        .animated-card.visible {
            transform: translateX(0);
            opacity: 1;
        }

        .CodeMirror {
            display: none !important;
        }
    </style>
    <?php
    require_once __DIR__ . '/company-profile/CompanyProfileDao.php';

    require_once __DIR__ . '/includes/Helper.php';
    require_once __DIR__ . '/database/database.php';

    try {
        $companyProfileDao = new CompanyProfileDao($pdo);
        $selectedCompanyInformation = new CompanyInformation();
        $selectedCompanyInformation->setId(1);
        $filterCriteria = [
            [
                "column" => "id",
                "operator" => "=",
                "value" => $selectedCompanyInformation->getId()
            ]
        ];
        $companyProfile = $companyProfileDao->fetchCompanyInformation([], $filterCriteria);
        if ($companyProfile === ActionResult::FAILURE) {
            $companyProfile = null;
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        die();
    }


    ?>
</head>

<body>
    <style>
        .space{
            display: flex;
            justify-content: space-between;
        }
        .start{
            display: flex;
        justify-content: flex-start;
        }
        .end{
            display:flex;
        justify-content: flex-end;
        }
    </style>
    <!-- Sticky Navigation Bar -->
    <nav class="navbar navbar-expand-lg d-flex flex-fill col-auto">
        <div class="container space">
            <div class="collapse navbar-collapse start">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#smart">Smart Wage</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#principles">Principles</a></li>
                    <li class="nav-item"><a class="nav-link" href="#compliance">Compliance</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact-us">Contact</a></li>
                </ul>
            </div>
        </div>
        <button class="login-button end" onclick="window.location.href='login.php'">Log In</button>
    </nav>


    <!-- Hero Section -->
    <header class="hero" id="smart">
        <div class="hero-text">
            <h1>Empowering Work, Simplifying Wages, Ensuring Trust.</h1>
            <p> Experience the power of seamless payroll, where exclusive benefits meet effortless convenience. </p>
            <a href="attendances-rfid" class="btn btn-outline-light btn-lg ms-2">Check Attendance</a> <!--pwede to gawin yung sa attendance part-->
        </div>
    </header>



    <!-- About Us Section -->
    <section id="about" class="about-us">
        <div class="container">
            <h2 class="text-center mb-4">About Us</h2>
            <p class="text-center mb-5">
                Smart Wage Management System provides a simple and efficient solution for managing payroll. We focus on accuracy, transparency, and ease of use for businesses and employees.
            </p>

            <div class="row">
                <div class="col-md-3">
                    <div class="card p-4 shadow text-center">
                        <img src="img/1.webp" alt="Payroll Processing" class="img-fluid mb-3" loading="lazy">
                        <h5>Payroll Processing</h5>
                        <p>Save time with automated calculations and payments.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-4 shadow text-center">
                        <img src="img/2.1.webp" alt="Wage Calculations" class="img-fluid mb-3" loading="lazy">
                        <h5>Wage Calculations</h5>
                        <p>Eliminate errors with precision-based calculations.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-4 shadow text-center">
                        <img src="img/3.jpg" alt="Employee Self-Service" class="img-fluid mb-3" loading="lazy">
                        <h5>Employee Self-Service</h5>
                        <p>Empower your team with full transparency.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-4 shadow text-center">
                        <img src="img/4.webp" alt="Compliance Made Easy" class="img-fluid mb-3" loading="lazy">
                        <h5>Simplified Compliance</h5>
                        <p>Accurate reporting and legal adherence made simple.</p>

                    </div>
                </div>
            </div>

            <!-- History Section -->
            <div class="history-section mt-5 d-flex justify-content-center">
                <div class="card p-4 shadow-lg animated-card">
                    <h3 class="text-center mb-3">Our History</h3>
                    <p class="text-center">
                        <?php if ($companyProfile !== null && isset($companyProfile[0]['history'])): ?>
                            <textarea id="historyInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['history']); ?></textarea>
                    <div class="text-center" id="historyValue"><?php echo htmlspecialchars($companyProfile[0]['history']); ?></div>
                    <script>
                        $(document).ready(function () {
                        if (typeof SimpleMDE === "undefined") {
                            console.error("SimpleMDE is not loaded.");
                            return;
                        }

                        var simplemde = new SimpleMDE({ 
                            element: document.getElementById("historyInput"), 
                            toolbar: false, 
                            status: false 
                        });

                        // Set the content and render Markdown
                        simplemde.value('<?php echo htmlspecialchars($companyProfile[0]['history']); ?>'); 
                        var missionText = simplemde.value();
                        document.getElementById("historyValue").innerHTML = simplemde.markdown(missionText);

                        });
                    </script>
                <?php else: ?>
                    Smart Wage Management System was established with the vision of simplifying payroll processing for businesses of all sizes. From our humble beginnings as a small startup, we’ve grown into a trusted platform that serves organizations across multiple industries. Our journey is fueled by our commitment to innovation, precision, and customer satisfaction.
                <?php endif ?>
                </p>
                <h3 class="text-center mb-3">Details</h3>
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <i class="fas fa-map-marker-alt fa-2x mb-2" style="color: #2d6a4f;"></i>
                        <h5>Address</h5>
                        <p>
                            <?php if ($companyProfile !== null && isset($companyProfile[0]['address'])): ?>
                                <?php echo htmlspecialchars($companyProfile[0]['address']); ?>
                            <?php else: ?>
                                Manila, Philippines
                            <?php endif ?>
                        </p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <i class="fas fa-phone fa-2x mb-2" style="color: #2d6a4f;"></i>
                        <h5>Phone</h5>
                        <p>
                            <?php if ($companyProfile !== null && isset($companyProfile[0]['phone'])): ?>
                                <?php echo htmlspecialchars($companyProfile[0]['phone']); ?>
                            <?php else: ?>
                                123 Main Street, Suite 400
                            <?php endif ?>
                        </p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <i class="fas fa-laptop-code fa-2x mb-2" style="color: #2d6a4f;"></i>
                        <h5>Industry</h5>
                        <p>
                            <?php if ($companyProfile !== null && isset($companyProfile[0]['industry'])): ?>
                                <?php echo htmlspecialchars($companyProfile[0]['industry']); ?>
                            <?php else: ?>
                                Information Technology
                            <?php endif ?>
                        </p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <i class="fas fa-users fa-2x mb-2" style="color: #2d6a4f;"></i>
                        <h5>Employee Count</h5>
                        <p>
                            <?php if ($companyProfile !== null && isset($companyProfile[0]['employee_count'])): ?>
                                <?php echo htmlspecialchars($companyProfile[0]['employee_count']); ?>+
                            <?php else: ?>
                                5+
                            <?php endif ?>
                        </p>
                    </div>
                </div>
                </div>
            </div>
    </section>









    <!-- Principles Section -->
    <section id="principles" class="principles">
        <div class="container">
            <h2 class="text-center mb-5">Company Principles</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card p-3 shadow">
                        <h4><i class="fas fa-bullseye mb-3"></i> Mission</h4>

                        <?php if ($companyProfile !== null && isset($companyProfile[0]['mission'])): ?>
                            <textarea id="missionInput" style="visibility:hidden; height: 0; width: 0; display: none;"></textarea>
                            <div class="text-center" id="missionValue"></div>

                            <script>
                                $(document).ready(function () {
                                    if (typeof SimpleMDE === "undefined") {
                                        console.error("SimpleMDE is not loaded.");
                                        return;
                                    }

                                    var simplemde = new SimpleMDE({ 
                                        element: document.getElementById("missionInput"), 
                                        toolbar: false, 
                                        status: false 
                                    });

                                    // Set the content and render Markdown
                                    simplemde.value('<?php echo htmlspecialchars($companyProfile[0]['mission']); ?>'); 
                                    var missionText = simplemde.value();
                                    document.getElementById("missionValue").innerHTML = simplemde.markdown(missionText);

                                });
                            </script>

                        <?php else: ?>
                            <p class="text-center">
                                To simplify payroll management through accurate, transparent, and efficient solutions.
                            </p>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow">
                        <h4><i class="fas fa-lightbulb mb-3"></i> Vision</h4>
                        <p>
                            <?php if ($companyProfile !== null && isset($companyProfile[0]['vision'])): ?>
                                <textarea id="visionInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['vision']); ?></textarea>
                        <div class="text-center" id="visionValue"></div>
                        <script>
                            $(document).ready(function () {
                                if (typeof SimpleMDE === "undefined") {
                                    console.error("SimpleMDE is not loaded.");
                                    return;
                                }

                                var simplemde = new SimpleMDE({ 
                                    element: document.getElementById("visionInput"), 
                                    toolbar: false, 
                                    status: false 
                                });

                                // Set the content and render Markdown
                                simplemde.value('<?php echo htmlspecialchars($companyProfile[0]['vision']); ?>'); 
                                var missionText = simplemde.value();
                                document.getElementById("visionValue").innerHTML = simplemde.markdown(missionText);

                            });
                        </script>
                    <?php else: ?>
                        To be the go-to platform for reliable and seamless wage management.
                    <?php endif ?>
                    </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow">
                        <h4><i class="fas fa-handshake mb-3"></i> Values</h4>
                        <p>
                            <?php if ($companyProfile !== null && isset($companyProfile[0]['company_values'])): ?>
                                <textarea id="valuesInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['company_values']); ?></textarea>
                        <div class="text-center" id="valuesValue"></div>
                        <script>
                            $(document).ready(function () {
                                if (typeof SimpleMDE === "undefined") {
                                    console.error("SimpleMDE is not loaded.");
                                    return;
                                }

                                var simplemde = new SimpleMDE({ 
                                    element: document.getElementById("valuesInput"), 
                                    toolbar: false, 
                                    status: false 
                                });

                                // Set the content and render Markdown
                                simplemde.value('<?php echo htmlspecialchars($companyProfile[0]['company_values']); ?>'); 
                                var missionText = simplemde.value();
                                document.getElementById("valuesValue").innerHTML = simplemde.markdown(missionText);

                            });
                        </script>
                    <?php else: ?>
                        We are committed to ensuring precise payroll processing, building trust through transparency, saving time with efficient solutions, and prioritizing user-friendly experiences.
                    <?php endif ?>
                    </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Compliance Section -->
    <section id="compliance" class="compliance">
        <div class="container">
            <h2 class="text-center mb-5">Compliance and Policies</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card p-3 shadow">
                        <h4><i class="fas fa-user-check mb-3"></i> HR Policies</h4>
                        <p>
                            <?php if ($companyProfile !== null && isset($companyProfile[0]['policies'])): ?>
                                <textarea id="policiesInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['policies']); ?></textarea>
                        <div class="text-center" id="policiesValue"></div>
                        <script>
                            $(document).ready(function () {
                                if (typeof SimpleMDE === "undefined") {
                                    console.error("SimpleMDE is not loaded.");
                                    return;
                                }

                                var simplemde = new SimpleMDE({ 
                                    element: document.getElementById("policiesInput"), 
                                    toolbar: false, 
                                    status: false 
                                });

                                // Set the content and render Markdown
                                simplemde.value('<?php echo htmlspecialchars($companyProfile[0]['policies']); ?>'); 
                                var missionText = simplemde.value();
                                document.getElementById("policiesValue").innerHTML = simplemde.markdown(missionText);

                            });
                        </script>
                    <?php else: ?>
                        We uphold fairness, transparency, confidentiality, and compliance in all HR practices.
                    <?php endif ?>
                    </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow">
                        <h4><i class="fas fa-balance-scale mb-3"></i> Compliance Requirements</h4>
                        <p>
                            <?php if ($companyProfile !== null && isset($companyProfile[0]['compliance'])): ?>
                                <textarea id="complianceInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['policies']); ?></textarea>
                        <div class="text-center" id="complianceValue"></div>
                        <script>
                            $(document).ready(function () {
                                if (typeof SimpleMDE === "undefined") {
                                    console.error("SimpleMDE is not loaded.");
                                    return;
                                }

                                var simplemde = new SimpleMDE({ 
                                    element: document.getElementById("complianceInput"), 
                                    toolbar: false, 
                                    status: false 
                                });

                                // Set the content and render Markdown
                                simplemde.value('<?php echo htmlspecialchars($companyProfile[0]['compliance']); ?>'); 
                                var missionText = simplemde.value();
                                document.getElementById("complianceValue").innerHTML = simplemde.markdown(missionText);

                            });
                        </script>
                    <?php else: ?>
                        We ensure strict adherence to labor laws, tax regulations, and data protection standards.
                    <?php endif ?>
                    </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-3 shadow">
                        <h4><i class="fas fa-file-contract mb-3"></i>Notes</h4>
                        <p>
                            <?php if ($companyProfile !== null && isset($companyProfile[0]['notes'])): ?>
                                <textarea id="notesInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['notes']); ?></textarea>
                        <div class="text-center" id="notesValue"></div>
                        <script>
                            $(document).ready(function () {
                                if (typeof SimpleMDE === "undefined") {
                                    console.error("SimpleMDE is not loaded.");
                                    return;
                                }

                                var simplemde = new SimpleMDE({ 
                                    element: document.getElementById("notesInput"), 
                                    toolbar: false, 
                                    status: false 
                                });

                                // Set the content and render Markdown
                                simplemde.value('<?php echo htmlspecialchars($companyProfile[0]['notes']); ?>'); 
                                var missionText = simplemde.value();
                                document.getElementById("notesValue").innerHTML = simplemde.markdown(missionText);

                            });
                        </script>
                    <?php else: ?>
                        We maintain fair practices, data security, and compliance with all applicable laws and regulations.
                    <?php endif ?>

                    </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="contact-us" style="background-color: #f4f4f4; padding: 50px 0;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #2d6a4f;">Contact Us</h2>
            <p style="color: #6b8e23;">We'd love to hear from you! Reach out with any questions, comments, or feedback.</p>
        </div>

        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
            <form action="#" method="POST" style="max-width: 600px; width: 100%; background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                <div style="margin-bottom: 20px;">
                    <label for="name" style="color: #2d6a4f; font-weight: bold;">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;" />
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="email" style="color: #2d6a4f; font-weight: bold;">Your Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px;" />
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="message" style="color: #2d6a4f; font-weight: bold;">Your Message</label>
                    <textarea id="message" name="message" placeholder="Write your message here" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; height: 150px;"></textarea>
                </div>

                <div style="text-align: center;">
                    <button type="submit" style="background-color: #2d6a4f; color: white; padding: 15px 30px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">
                        Send Message
                    </button>
                </div>
            </form>
            <div id="contact-links">
                <a href="#"><i class="fab fa-twitter" title="Twitter"></i></a>
                <a href="#"><i class="fab fa-facebook" title="Facebook"></i></a>
                <a href="#"><i class="fab fa-instagram" title="Instagram"></i></a>
                <a href="mailto:example@example.com"><i class="fas fa-envelope" title="Email"></i></a>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer>
        <p>&copy; 2025 <a href="index">smartWage</a> | Designed with Sneats Bootstrap Template</p>
        <div>
            <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        });

        document.querySelectorAll('.card').forEach((card) => {
            observer.observe(card);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const animatedCard = document.querySelector('.animated-card');

            const observer = new IntersectionObserver(
                ([entry]) => {
                    if (entry.isIntersecting) {
                        animatedCard.classList.add('visible');
                    }
                }, {
                    threshold: 0.1
                }
            );

            observer.observe(animatedCard);
        });

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".nav-link").forEach(anchor => {
                anchor.addEventListener("click", function(event) {
                    if (this.getAttribute("href").startsWith("#")) {
                        event.preventDefault();
                        const targetId = this.getAttribute("href").substring(1);
                        const targetElement = document.getElementById(targetId);
                        if (targetElement) {
                            window.scrollTo({
                                top: targetElement.offsetTop - 50,
                                behavior: "smooth"
                            });
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>