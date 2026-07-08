<?php
session_start();
include('conf/config.php'); //get configuration file
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $input_password = $_POST['password'];
  
  // Query staff by email or staff number
  $stmt = $mysqli->prepare("SELECT password, staff_id FROM iB_staff WHERE email=? OR staff_number=?");
  $stmt->bind_param('ss', $email, $email);
  $stmt->execute();
  $stmt->bind_result($db_password, $staff_id);
  $rs = $stmt->fetch();
  $stmt->close();
  
  if ($rs && ($db_password === sha1(md5($input_password)) || $db_password === sha1($input_password))) {
    $_SESSION['staff_id'] = $staff_id;
    header("location:pages_dashboard.php");
  } else {
    $err = "Access Denied Please Check Your Credentials";
  }
}

/* Persisit System Settings On Brand */
$ret = "SELECT * FROM `iB_SystemSettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($auth = $res->fetch_object()) {
?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta http-equiv="content-type" content="text/html;charset=utf-8" />
      <?php include("dist/_partials/head.php"); ?>
  </head>
  <body>
    <div class="split-login-container">
      <!-- Left Visual Panel -->
      <div class="login-visual-panel" style="background: linear-gradient(135deg, #0c0217 0%, #1c0533 100%) !important;">
        <div class="login-visual-logo">
          <img src="../admin/dist/img/<?php echo $auth->sys_logo; ?>" alt="BOI Logo">
          <span><?php echo $auth->sys_name; ?></span>
        </div>
        
        <div class="login-visual-graphic">
          <div class="shield-wrapper">
            <div class="shield-ring"></div>
            <div class="shield-ring-2"></div>
            <div class="shield-core" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important; box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4) !important;">
              <i class="fas fa-users-cog"></i>
            </div>
          </div>
          <div class="login-visual-text">
            <h2>Staff Operations Portal</h2>
            <p>Access the staff dashboard to open client bank accounts, manage client profiles, process manual transactions (deposits and withdrawals), and view financial audit reports.</p>
          </div>
        </div>
        
        <div class="login-visual-footer">
          <span>BOI Staff Portal</span>
          <span>&copy; <?php echo date('Y'); ?></span>
        </div>
      </div>
      
      <!-- Right Form Panel -->
      <div class="login-form-panel">
        <div class="login-form-box">
          <div class="login-form-header">
            <h2>Staff Session Login</h2>
            <p>Log in to access your administrative operational dashboard.</p>
          </div>
          
          <div class="split-login-card">
            <form method="post">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
                <input type="text" name="email" class="form-control" placeholder="Staff ID / Email" required>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
              </div>
              <div class="row align-items-center">
                <div class="col-7">
                  <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember" style="font-size: 0.85rem; font-weight: 500; color: var(--text-muted);">
                      Remember Me
                    </label>
                  </div>
                </div>
                <div class="col-5">
                  <button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
                </div>
              </div>
            </form>
          </div>
          
          <div class="mt-4 text-center">
            <p class="mb-0">
              <a href="../index.php" class="small font-weight-bold" style="color: var(--text-muted)"><i class="fas fa-arrow-left mr-1"></i> Back to Homepage</a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
  </body>
  </html>
<?php
} ?>