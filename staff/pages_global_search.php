<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$staff_id = $_SESSION['staff_id'];

$search_query = "";
if (isset($_GET['query'])) {
    $search_query = trim($_GET['query']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <?php include("dist/_partials/head.php"); ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php include("dist/_partials/nav.php"); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include("dist/_partials/sidebar.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Global Search Hub</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Global Search</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Search Input Form -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <form method="get" action="pages_global_search.php">
                                    <div class="input-group input-group-lg">
                                        <input type="search" name="query" class="form-control" placeholder="Search clients, account numbers or transaction details..." value="<?php echo htmlspecialchars($search_query); ?>" required>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-primary">
                                                <i class="fa fa-search mr-1"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <?php if (!empty($search_query)): ?>
                                    <p class="mt-3 text-muted">Showing results for: <strong>"<?php echo htmlspecialchars($search_query); ?>"</strong></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($search_query)): 
                    $like_query = "%" . $search_query . "%";
                ?>
                    <!-- Search Results Sections -->
                    <div class="row">
                        <!-- 1. Clients/Customers Results -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h3 class="card-title text-primary"><i class="fas fa-users mr-2"></i> Matching Clients (Customers)</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Client Number</th>
                                                    <th>National ID</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ret = "SELECT * FROM iB_clients WHERE name LIKE ? OR client_number LIKE ? OR national_id LIKE ? OR email LIKE ? OR phone LIKE ?";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->bind_param('sssss', $like_query, $like_query, $like_query, $like_query, $like_query);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                if ($res->num_rows > 0) {
                                                    while ($row = $res->fetch_object()) {
                                                        echo "<tr>
                                                            <td>".htmlspecialchars($row->name)."</td>
                                                            <td><span class='badge badge-info'>".htmlspecialchars($row->client_number)."</span></td>
                                                            <td>".htmlspecialchars($row->national_id)."</td>
                                                            <td>".htmlspecialchars($row->phone)."</td>
                                                            <td>".htmlspecialchars($row->email)."</td>
                                                            <td>".htmlspecialchars($row->address)."</td>
                                                            <td><a href='pages_view_client.php?client_number=".urlencode($row->client_number)."' class='btn btn-xs btn-primary'><i class='fas fa-folder-open mr-1'></i> Manage</a></td>
                                                        </tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7' class='text-center text-muted p-3'>No matching client records found.</td></tr>";
                                                }
                                                $stmt->close();
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Bank Accounts Results -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h3 class="card-title text-success"><i class="fas fa-briefcase mr-2"></i> Matching Bank Accounts</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Account Name</th>
                                                    <th>Account Number</th>
                                                    <th>Account Type</th>
                                                    <th>Status</th>
                                                    <th>Owner Name</th>
                                                    <th>Owner National ID</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ret = "SELECT * FROM iB_bankAccounts WHERE acc_name LIKE ? OR account_number LIKE ? OR client_name LIKE ? OR client_national_id LIKE ?";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->bind_param('ssss', $like_query, $like_query, $like_query, $like_query);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                if ($res->num_rows > 0) {
                                                    while ($row = $res->fetch_object()) {
                                                        $status_badge = $row->acc_status == 'Active' ? 'badge-success' : 'badge-danger';
                                                        echo "<tr>
                                                            <td>".htmlspecialchars($row->acc_name)."</td>
                                                            <td><span class='badge badge-success font-weight-bold'>".htmlspecialchars($row->account_number)."</span></td>
                                                            <td>".htmlspecialchars($row->acc_type)."</td>
                                                            <td><span class='badge $status_badge'>".htmlspecialchars($row->acc_status)."</span></td>
                                                            <td>".htmlspecialchars($row->client_name)."</td>
                                                            <td>".htmlspecialchars($row->client_national_id)."</td>
                                                            <td>
                                                                <a href='pages_update_client_accounts.php?account_id=".urlencode($row->account_id)."' class='btn btn-xs btn-primary mr-1'><i class='fas fa-edit mr-1'></i> Manage</a>
                                                                <a href='pages_check_client_acc_balance.php?account_id=".urlencode($row->account_id)."' class='btn btn-xs btn-success'><i class='fas fa-dollar-sign mr-1'></i> Balance</a>
                                                            </td>
                                                        </tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7' class='text-center text-muted p-3'>No matching bank accounts found.</td></tr>";
                                                }
                                                $stmt->close();
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Transactions Results -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h3 class="card-title text-warning"><i class="fas fa-exchange-alt mr-2"></i> Matching Transactions</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Transaction Code</th>
                                                    <th>Source Account</th>
                                                    <th>Client Name</th>
                                                    <th>Transaction Type</th>
                                                    <th>Amount</th>
                                                    <th>Beneficiary Account</th>
                                                    <th>Timestamp</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ret = "SELECT * FROM iB_Transactions WHERE tr_code LIKE ? OR account_number LIKE ? OR client_name LIKE ? OR receiving_acc_no LIKE ? OR tr_type LIKE ?";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->bind_param('sssss', $like_query, $like_query, $like_query, $like_query, $like_query);
                                                $stmt->execute();
                                                $res = $stmt->get_result();
                                                if ($res->num_rows > 0) {
                                                    while ($row = $res->fetch_object()) {
                                                        $badge = 'badge-secondary';
                                                        if ($row->tr_type == 'Deposit') $badge = 'badge-success';
                                                        elseif ($row->tr_type == 'Withdrawal') $badge = 'badge-danger';
                                                        elseif ($row->tr_type == 'Transfer') $badge = 'badge-warning';

                                                        echo "<tr>
                                                            <td><span class='badge badge-light font-weight-bold' style='border:1px solid var(--border-color)'>".htmlspecialchars($row->tr_code)."</span></td>
                                                            <td>".htmlspecialchars($row->account_number)."</td>
                                                            <td>".htmlspecialchars($row->client_name)."</td>
                                                            <td><span class='badge $badge'>".htmlspecialchars($row->tr_type)."</span></td>
                                                            <td class='font-weight-bold'>$".htmlspecialchars($row->transaction_amt)."</td>
                                                            <td>".(!empty($row->receiving_acc_no) ? htmlspecialchars($row->receiving_acc_no) : "<span class='text-muted'>-</span>")."</td>
                                                            <td>".date("d-M-Y h:i A", strtotime($row->created_at))."</td>
                                                        </tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7' class='text-center text-muted p-3'>No matching transactions found.</td></tr>";
                                                }
                                                $stmt->close();
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include("dist/_partials/footer.php"); ?>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
