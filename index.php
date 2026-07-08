<?php
include("admin/conf/config.php");
/* Persist System Settings On Brand */
$ret = "SELECT * FROM `iB_SystemSettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Secure, fast, and modern digital banking portal for Bank of India.">
        <title><?php echo $sys->sys_name; ?> - <?php echo $sys->sys_tagline; ?></title>
        
        <!-- Robust Theme CSS (Includes Bootstrap 4 framework layout and components) -->
        <link href="dist/css/robust.css" rel="stylesheet">
        
        <!-- Modern Custom Banking Theme Overrides -->
        <link href="dist/css/custom-banking.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="client/plugins/fontawesome-free/css/all.min.css">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Theme Switching Script -->
        <script src="dist/js/custom-banking.js" defer></script>

        <style>
            /* Landing Page UI Polish overrides on top of robust.css */
            :root {
                --boi-blue: #0c4a60;
                --boi-orange: #f15a24;
                --boi-orange-hover: #d03e10;
                --shadow-premium: 0 20px 40px -15px rgba(12, 74, 96, 0.08), 0 15px 20px -15px rgba(0,0,0,0.05);
            }
            .theme-dark {
                --boi-blue: #38bdf8;
                --boi-orange: #fb923c;
                --boi-orange-hover: #f97316;
                --shadow-premium: 0 20px 40px -15px rgba(0, 0, 0, 0.4);
            }

            body {
                background-color: var(--bg-color) !important;
                color: var(--text-color) !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Top Announcement/Header Bar */
            .top-bar {
                background-color: var(--boi-blue) !important;
                color: #ffffff !important;
                font-size: 0.82rem;
                padding: 8px 0;
                font-weight: 500;
                border-bottom: 1px solid rgba(255,255,255,0.08);
            }
            .top-bar a {
                color: rgba(255,255,255,0.85) !important;
                text-decoration: none;
                margin-right: 15px;
                transition: color 0.2s ease;
            }
            .top-bar a:hover {
                color: var(--boi-orange) !important;
            }

            /* Navbar Layout */
            .navbar-bank {
                background-color: var(--card-bg) !important;
                border-bottom: 1px solid var(--border-color) !important;
                padding: 15px 0 !important;
                box-shadow: 0 2px 10px rgba(0,0,0,0.02) !important;
            }
            .navbar-brand {
                font-size: 1.5rem;
                font-weight: 800;
                color: var(--primary-color) !important;
                display: flex;
                align-items: center;
                gap: 12px;
                text-decoration: none;
            }
            .navbar-brand img {
                height: 38px;
                width: auto;
                object-fit: contain;
            }
            .nav-link-custom {
                color: var(--text-color) !important;
                font-weight: 600;
                font-size: 0.95rem;
                text-decoration: none;
                padding: 8px 15px;
                transition: color 0.2s ease;
            }
            .nav-link-custom:hover {
                color: var(--boi-orange) !important;
            }

            /* Hero Banner */
            .hero-section {
                padding: 60px 0 !important;
                position: relative;
                overflow: hidden;
                border-bottom: 1px solid var(--border-color) !important;
                background: linear-gradient(135deg, var(--bg-color) 0%, rgba(241, 90, 36, 0.01) 100%) !important;
            }
            .hero-section::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 45%;
                height: 100%;
                background: radial-gradient(circle at 60% 30%, rgba(241, 90, 36, 0.03) 0%, transparent 70%);
                pointer-events: none;
            }

            .hero-title {
                font-size: 2.8rem !important;
                font-weight: 800 !important;
                line-height: 1.2 !important;
                letter-spacing: -1px;
                margin-bottom: 1.25rem;
                color: var(--text-color) !important;
            }
            .hero-title span {
                color: var(--boi-orange) !important;
            }
            .hero-subtitle {
                font-size: 1.1rem !important;
                color: var(--text-muted) !important;
                line-height: 1.6 !important;
                margin-bottom: 2rem;
            }

            /* Portal login card styling on landing page */
            .login-card-hub {
                border: 1px solid var(--border-color) !important;
                border-radius: var(--radius-lg) !important;
                background-color: var(--card-bg) !important;
                box-shadow: var(--shadow-premium) !important;
                overflow: hidden;
            }
            .login-card-header {
                background-color: var(--bg-color) !important;
                border-bottom: 1px solid var(--border-color) !important;
                padding: 0 !important;
                display: flex !important;
            }
            .login-tab {
                flex: 1;
                text-align: center;
                padding: 14px 10px;
                font-weight: 700;
                font-size: 0.88rem;
                color: var(--text-muted);
                cursor: pointer;
                border-bottom: 2px solid transparent;
                transition: all 0.2s ease;
            }
            .login-tab.active {
                color: var(--primary-color) !important;
                border-bottom: 2px solid var(--boi-orange) !important;
                background-color: var(--card-bg) !important;
            }
            .login-card-body {
                padding: 25px 20px !important;
            }
            .login-pane {
                display: none;
            }
            .login-pane.active {
                display: block !important;
            }

            /* Feature Cards */
            .features-section {
                padding: 60px 0 !important;
                background-color: var(--card-bg) !important;
                border-bottom: 1px solid var(--border-color) !important;
            }
            .section-tag {
                text-transform: uppercase;
                color: var(--boi-orange);
                font-weight: 800;
                font-size: 0.82rem;
                letter-spacing: 1px;
                margin-bottom: 8px;
                display: block;
            }
            .section-title {
                font-size: 2rem !important;
                font-weight: 800 !important;
                color: var(--text-color) !important;
                margin-bottom: 40px !important;
            }
            .feature-box {
                padding: 25px !important;
                border: 1px solid var(--border-color) !important;
                border-radius: var(--radius-md) !important;
                background-color: var(--bg-color) !important;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                height: 100%;
            }
            .feature-box:hover {
                transform: translateY(-4px);
                box-shadow: var(--card-shadow-hover) !important;
            }
            .feature-icon {
                width: 50px;
                height: 50px;
                border-radius: var(--radius-sm);
                background-color: rgba(12, 74, 96, 0.08) !important;
                color: var(--boi-blue) !important;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.3rem !important;
                margin-bottom: 18px;
            }
            .theme-dark .feature-icon {
                background-color: rgba(56, 189, 248, 0.15) !important;
                color: var(--primary-color) !important;
            }
            .feature-box h3 {
                font-size: 1.15rem !important;
                font-weight: 700 !important;
                margin-bottom: 10px;
            }
            .feature-box p {
                color: var(--text-muted) !important;
                font-size: 0.88rem !important;
                line-height: 1.6;
                margin-bottom: 0;
            }

            /* Security warning banner */
            .security-banner {
                background-color: #fef3c7 !important;
                border-bottom: 1px solid #fde68a !important;
                color: #92400e !important;
                padding: 12px 0 !important;
                font-size: 0.85rem !important;
                font-weight: 500;
            }
            .theme-dark .security-banner {
                background-color: rgba(245, 158, 11, 0.1) !important;
                border-bottom: 1px solid rgba(245, 158, 11, 0.2) !important;
                color: #fbbf24 !important;
            }

            /* Adjust list styles and line heights in robust.css */
            .footer-col h4 {
                font-size: 1.05rem !important;
                font-weight: 700 !important;
                margin-bottom: 15px !important;
                color: var(--text-color) !important;
            }
            .footer-col ul {
                list-style: none !important;
                padding-left: 0 !important;
            }
            .footer-col ul li {
                margin-bottom: 8px !important;
            }
            .footer-col ul li a {
                color: var(--text-muted) !important;
                text-decoration: none;
                font-size: 0.85rem !important;
                transition: color 0.2s ease;
            }
            .footer-col ul li a:hover {
                color: var(--boi-orange) !important;
            }
            hr {
                border-top: 1px solid var(--border-color) !important;
            }
            
            /* Form Icon Alignment and Overrides for index login */
            .login-card-body .input-group-prepend {
                margin-right: -1px;
            }
            .login-card-body .input-group-text {
                border-radius: var(--radius-sm) 0 0 var(--radius-sm) !important;
                border-right: none !important;
            }
            .login-card-body .form-control {
                border-radius: 0 var(--radius-sm) var(--radius-sm) 0 !important;
            }

            /* Mobile Navigation Drawer styles */
            .mobile-menu-toggle {
                background: none;
                border: none;
                color: var(--text-color);
                font-size: 1.5rem;
                cursor: pointer;
                outline: none !important;
            }
            .mobile-nav-drawer {
                position: fixed;
                top: 0;
                right: -280px;
                width: 280px;
                height: 100vh;
                background-color: var(--card-bg);
                border-left: 1px solid var(--border-color);
                box-shadow: -5px 0 25px rgba(0,0,0,0.08);
                z-index: 10000;
                transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                display: flex;
                flex-direction: column;
                padding: 25px;
            }
            .mobile-nav-drawer.active {
                right: 0;
            }
            .mobile-nav-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
                border-bottom: 1px solid var(--border-color);
                padding-bottom: 15px;
            }
            .mobile-nav-header .close-btn {
                background: none;
                border: none;
                font-size: 2rem;
                color: var(--text-color);
                cursor: pointer;
                outline: none !important;
                line-height: 1;
            }
            .mobile-nav-links {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }
            .mobile-nav-links a {
                color: var(--text-color);
                font-size: 1.1rem;
                font-weight: 600;
                text-decoration: none;
                transition: color 0.2s ease;
                padding: 8px 0;
            }
            .mobile-nav-links a:hover {
                color: var(--boi-orange);
            }
        </style>
    </head>

    <body>

        <!-- Top Announcement Bar -->
        <div class="top-bar">
            <div class="container d-flex justify-content-between align-items-center">
                <div>
                    <a href="#"><i class="fas fa-phone mr-1"></i> Customer Support: 1800 220 224</a>
                    <a href="#"><i class="fas fa-map-marker-alt mr-1"></i> ATM & Branch Locator</a>
                </div>
                <div class="d-none d-md-block">
                    <a href="#"><i class="fas fa-shield-alt mr-1"></i> Security Center</a>
                    <a href="#"><i class="fas fa-percentage mr-1"></i> Interest Rates</a>
                </div>
            </div>
        </div>

        <!-- Navigation Bar -->
        <nav class="navbar-bank">
            <div class="container d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="index.php">
                    <img src="admin/dist/img/<?php echo $sys->sys_logo; ?>" alt="BOI Logo">
                    <span><?php echo $sys->sys_name; ?></span>
                </a>
                <div class="d-none d-lg-flex">
                    <a class="nav-link-custom" href="#home">Home</a>
                    <a class="nav-link-custom" href="#features">Features</a>
                    <a class="nav-link-custom" href="#security">Security</a>
                    <a class="nav-link-custom" href="client/pages_client_signup.php">Register</a>
                </div>
                <div class="d-flex align-items-center">
                    <a class="btn btn-primary d-none d-sm-inline-block d-lg-none mr-2" href="#portals">Portals</a>
                    <button class="mobile-menu-toggle d-lg-none" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Navigation Menu Drawer -->
        <div id="mobileMenu" class="mobile-nav-drawer">
            <div class="mobile-nav-header">
                <span class="font-weight-bold" style="font-size: 1.25rem;">Menu</span>
                <button class="close-btn" onclick="toggleMobileMenu()">&times;</button>
            </div>
            <div class="mobile-nav-links">
                <a href="#home" onclick="toggleMobileMenu()">Home</a>
                <a href="#features" onclick="toggleMobileMenu()">Features</a>
                <a href="#security" onclick="toggleMobileMenu()">Security</a>
                <a href="client/pages_client_signup.php" onclick="toggleMobileMenu()">Register</a>
            </div>
        </div>

        <!-- Security Warning Banner -->
        <div id="security" class="security-banner">
            <div class="container">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle mr-3 font-size-lg"></i>
                    <div>
                        <strong>Cybersecurity Advisory:</strong> Bank of India never requests passwords, card PINs, OTPs, or CVVs. Do not share credentials or login on unverified third-party pages.
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero Section with Embedded Login Hub -->
        <section id="home" class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Hero Content -->
                    <div class="col-lg-6 pr-lg-5 mb-5 mb-lg-0">
                        <span class="section-tag">BOI Internet Banking</span>
                        <h1 class="hero-title">
                            Safe & Smart <span>Banking</span> for Everyone.
                        </h1>
                        <p class="hero-subtitle">
                            <?php echo $sys->sys_tagline; ?>. Manage checkbooks, issue transfers, track transaction graphs, and process withdrawals with a secure digital shield.
                        </p>
                        
                        <div class="row d-none d-md-flex mt-4">
                            <div class="col-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success mr-2"></i>
                                    <span class="font-weight-bold" style="font-size:0.9rem">Instant Fund Transfers</span>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success mr-2"></i>
                                    <span class="font-weight-bold" style="font-size:0.9rem">Biometric Security Logs</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success mr-2"></i>
                                    <span class="font-weight-bold" style="font-size:0.9rem">Automated E-Statements</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success mr-2"></i>
                                    <span class="font-weight-bold" style="font-size:0.9rem">24/7 Support Desk</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Embedded Login Portal Hub -->
                    <div id="portals" class="col-lg-6 col-xl-5 offset-xl-1">
                        <div class="login-card-hub">
                            <!-- Tabs navigation -->
                            <div class="login-card-header">
                                <div class="login-tab active" onclick="switchLoginTab('client-pane', this)">
                                    <i class="fas fa-user-shield d-block mb-1"></i> Customer Login
                                </div>
                                <div class="login-tab" onclick="switchLoginTab('staff-pane', this)">
                                    <i class="fas fa-user-cog d-block mb-1"></i> Staff Login
                                </div>
                                <div class="login-tab" onclick="switchLoginTab('admin-pane', this)">
                                    <i class="fas fa-users-cog d-block mb-1"></i> Admin Login
                                </div>
                            </div>

                            <!-- Form Contents -->
                            <div class="login-card-body">
                                <!-- Customer Pane -->
                                <div id="client-pane" class="login-pane active">
                                    <h3 class="font-weight-bold mb-1">Customer Login</h3>
                                    <p class="text-muted small mb-3">Log in directly to manage your client accounts.</p>
                                    
                                    <form action="client/pages_client_index.php" method="post">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="text" name="email" class="form-control" placeholder="User ID / Email" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                        <div class="row align-items-center mb-3">
                                            <div class="col-7">
                                                <div class="icheck-primary">
                                                    <input type="checkbox" id="remember-client">
                                                    <label for="remember-client" class="small text-muted" style="cursor:pointer">Remember Me</label>
                                                </div>
                                            </div>
                                            <div class="col-5 text-right">
                                                <button type="submit" name="login" class="btn btn-success btn-block py-2 font-weight-bold">Log In</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <div class="text-center mt-2">
                                        <span class="text-muted small">New to online banking?</span>
                                        <a href="client/pages_client_signup.php" class="small font-weight-bold ml-1" style="color: var(--boi-orange)">Register Now</a>
                                    </div>
                                </div>

                                <!-- Staff Pane -->
                                <div id="staff-pane" class="login-pane">
                                    <h3 class="font-weight-bold mb-1">Employee Login</h3>
                                    <p class="text-muted small mb-3">Log in directly to manage client assets & onboarding.</p>
                                    
                                    <form action="staff/pages_staff_index.php" method="post">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="text" name="email" class="form-control" placeholder="Employee ID / Email" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-7">
                                                <div class="icheck-primary">
                                                    <input type="checkbox" id="remember-staff">
                                                    <label for="remember-staff" class="small text-muted" style="cursor:pointer">Remember Me</label>
                                                </div>
                                            </div>
                                            <div class="col-5 text-right">
                                                <button type="submit" name="login" class="btn btn-primary btn-block py-2 font-weight-bold" style="background-color: var(--boi-orange) !important; border-color: var(--boi-orange) !important;">Log In</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Admin Pane -->
                                <div id="admin-pane" class="login-pane">
                                    <h3 class="font-weight-bold mb-1">Admin Login</h3>
                                    <p class="text-muted small mb-3">Log in directly to access administrative system tools.</p>
                                    
                                    <form action="admin/pages_index.php" method="post">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="text" name="email" class="form-control" placeholder="Admin ID / Email" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-7">
                                            </div>
                                            <div class="col-5 text-right">
                                                <button type="submit" name="login" class="btn btn-primary btn-block py-2 font-weight-bold">Log In</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Showcase Section -->
        <section id="features" class="features-section">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="section-tag">Convenience</span>
                    <h2 class="section-title">Designed for Complete Security</h2>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <h3>Instant Transfers</h3>
                            <p>Reliable funds dispatching via NEFT, RTGS, and IMPS. Send money safely with detailed confirmation reports.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3>Transaction Graphs</h3>
                            <p>Get a detailed graphical breakdown of your savings, withdrawal statistics, and deposit rates directly in your panel.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="feature-box">
                            <div class="feature-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                            <h3>Financial Reports</h3>
                            <p>Download e-statements, search detailed transaction logs, and generate budget lists for accounting audits.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Section -->
        <footer class="main-footer" style="padding: 50px 0 20px 0 !important; background-color: var(--card-bg);">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <a class="navbar-brand mb-3" href="index.php" style="padding-left:0">
                            <img src="admin/dist/img/<?php echo $sys->sys_logo; ?>" alt="BOI Logo">
                            <span><?php echo $sys->sys_name; ?></span>
                        </a>
                        <p class="text-muted small mt-2">
                            A secure, fast, and responsive digital banking system tailored to empower clients, employees, and system admins.
                        </p>
                    </div>
                    <div class="col-md-2 offset-md-1 mb-4 mb-md-0 footer-col">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><a href="#home">Home</a></li>
                            <li><a href="#features">Features</a></li>
                            <li><a href="#security">Security Center</a></li>
                            <li><a href="client/pages_client_signup.php">Register Online</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 mb-4 mb-md-0 footer-col">
                        <h4>Portals</h4>
                        <ul>
                            <li><a href="client/pages_client_index.php">Customer Portal</a></li>
                            <li><a href="staff/pages_staff_index.php">Employee Portal</a></li>
                            <li><a href="admin/pages_index.php">Admin Portal</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 footer-col">
                        <h4>Contact Us</h4>
                        <p class="text-muted small mb-1">
                            <i class="fas fa-map-marker-alt mr-2" style="color: var(--boi-orange)"></i> Head Office, Mumbai, India
                        </p>
                        <p class="text-muted small">
                            <i class="fas fa-phone mr-2" style="color: var(--boi-orange)"></i> Toll-Free Support: 1800 220 224
                        </p>
                    </div>
                </div>
                <hr>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        &copy; 2020-<?php echo date('Y'); ?> - Created By Bhushan Ingale. All rights reserved.
                    </div>
                    <div class="text-muted small mt-2 mt-md-0">
                        <b>System Version:</b> 2.0.0
                    </div>
                </div>
            </div>
        </footer>

        <!-- REQUIRED SCRIPTS -->
        <script src="client/plugins/jquery/jquery.min.js"></script>
        <script src="client/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

        <script>
            // JavaScript function to switch active login portal tabs on homepage
            function switchLoginTab(tabId, el) {
                // Remove active class from all tabs
                document.querySelectorAll('.login-tab').forEach(tab => {
                    tab.classList.remove('active');
                });
                // Add active class to clicked tab
                el.classList.add('active');

                // Hide all login panes
                document.querySelectorAll('.login-pane').forEach(pane => {
                    pane.classList.remove('active');
                });
                // Show active login pane
                document.getElementById(tabId).classList.add('active');
            }

            // JavaScript function to toggle mobile navigation drawer
            function toggleMobileMenu() {
                const drawer = document.getElementById('mobileMenu');
                if (drawer) {
                    drawer.classList.toggle('active');
                }
            }
        </script>
    </body>

    </html>
<?php
} ?>