<?php
session_start();
include('conf/config.php');

//register new account
if (isset($_POST['create_account'])) {
  //Register  Client
  $name = $_POST['name'];
  $national_id = $_POST['national_id'];
  $client_number = $_POST['client_number'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $password = sha1(md5($_POST['password']));
  $address  = $_POST['address'];

  //$profile_pic  = $_FILES["profile_pic"]["name"];
  //move_uploaded_file($_FILES["profile_pic"]["tmp_name"],"dist/img/".$_FILES["profile_pic"]["name"]);

  //Insert Captured information to a database table
  $query = "INSERT INTO iB_clients (name, national_id, client_number, phone, email, password, address) VALUES (?,?,?,?,?,?,?)";
  $stmt = $mysqli->prepare($query);
  //bind paramaters
  $rc = $stmt->bind_param('sssssss', $name, $national_id, $client_number, $phone, $email, $password, $address);
  $stmt->execute();

  //declare a varible which will be passed to alert function
  if ($stmt) {
    $success = "Account Created";
  } else {
    $err = "Please Try Again Or Try Later";
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
              <i class="fas fa-user-plus"></i>
            </div>
          </div>
          <div class="login-visual-text">
            <h2>Join Bank of India</h2>
            <p>Create a secure digital banking account in minutes. Access customized loan rates, high-interest savings accounts, easy money transfers, and full-featured debit cards instantly.</p>
          </div>
        </div>
        
        <div class="login-visual-footer">
          <span>BOI Customer Portal</span>
          <span>&copy; <?php echo date('Y'); ?></span>
        </div>
      </div>
      
      <!-- Right Form Panel -->
      <div class="login-form-panel">
        <div class="login-form-box" style="max-width: 500px;">
          <div class="login-form-header" style="margin-bottom: 20px;">
            <h2>Register Account</h2>
            <p>Fill in the details below to register a new client profile.</p>
          </div>
          
          <div class="split-login-card">
            <form method="post">
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                    <input type="text" name="name" required class="form-control" placeholder="Full Name">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fas fa-id-card"></span>
                      </div>
                    </div>
                    <input type="text" required name="national_id" class="form-control" placeholder="National ID">
                  </div>
                </div>
              </div>

              <!-- Hidden Generated Client Number -->
              <div style="display:none">
                <?php
                $length = 4;
                $_Number = substr(str_shuffle('0123456789'), 1, $length); 
                ?>
                <input type="text" name="client_number" value="iBank-CLIENT-<?php echo $_Number; ?>" class="form-control">
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fas fa-phone"></span>
                      </div>
                    </div>
                    <input type="text" name="phone" required class="form-control" placeholder="Phone Number">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                    <input type="email" name="email" required class="form-control" placeholder="Email Address">
                  </div>
                </div>
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span class="fas fa-map-marker-alt"></span>
                  </div>
                </div>
                <input type="text" name="address" required class="form-control" placeholder="Home Address">
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
                <input type="password" name="password" required class="form-control" placeholder="Create Password">
              </div>

              <div class="row align-items-center mt-3">
                <div class="col-7">
                  <span style="color: var(--text-muted); font-size: 0.85rem;">Already registered?</span>
                  <a href="pages_client_index.php" class="font-weight-bold ml-1" style="color: var(--secondary-color);">Sign In</a>
                </div>
                <div class="col-5">
                  <button type="submit" name="create_account" class="btn btn-primary btn-block">Sign Up</button>
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