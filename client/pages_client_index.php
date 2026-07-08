<?php
session_start();
include('conf/config.php'); //get configuration file
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $input_password = $_POST['password'];
  
  // Query client by email or client number
  $stmt = $mysqli->prepare("SELECT password, client_id FROM iB_clients WHERE email=? OR client_number=?");
  $stmt->bind_param('ss', $email, $email);
  $stmt->execute();
  $stmt->bind_result($db_password, $client_id);
  $rs = $stmt->fetch();
  $stmt->close();
  
  if ($rs && ($db_password === sha1(md5($input_password)) || $db_password === sha1($input_password))) {
    $_SESSION['client_id'] = $client_id;
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
      <div class="login-visual-panel" style="background: linear-gradient(135deg, #1c0533 0%, #0c0217 100%) !important;">
        <div class="login-visual-logo">
          <img src="../admin/dist/img/<?php echo $auth->sys_logo; ?>" alt="BOI Logo">
          <span><?php echo $auth->sys_name; ?></span>
        </div>
        
        <div class="login-visual-graphic">
          <div class="shield-wrapper">
            <div class="shield-ring"></div>
            <div class="shield-ring-2"></div>
            <div class="shield-core" style="background: linear-gradient(135deg, #f15a24 0%, #d03e10 100%) !important; box-shadow: 0 10px 25px rgba(241, 90, 36, 0.4) !important;">
              <i class="fas fa-wallet"></i>
            </div>
          </div>
          <div class="login-visual-text">
            <h2>Personal Internet Banking</h2>
            <p>Access your accounts securely. Check your balances, transfer money instantly to any beneficiary, view customized analytics, and manage your credit/debit cards on the go.</p>
          </div>
        </div>
        
        <div class="login-visual-footer">
          <span>BOI Customer Portal</span>
          <span>&copy; <?php echo date('Y'); ?></span>
        </div>
      </div>
      
      <!-- Right Form Panel -->
      <div class="login-form-panel">
        <div class="login-form-box">
          <div class="login-form-header">
            <h2>Welcome Back</h2>
            <p>Log in to access your digital banking account.</p>
          </div>
          
          <div class="split-login-card">
            <form method="post">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
                <input type="text" name="email" class="form-control" placeholder="Email / Client Number" required>
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
            <p class="mb-2">
              <span style="color: var(--text-muted); font-size: 0.88rem;">New to BOI?</span> 
              <a href="pages_client_signup.php" class="font-weight-bold ml-1" style="color: var(--secondary-color);">Register a new account</a>
            </p>
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