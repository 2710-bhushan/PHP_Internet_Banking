<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

// Clear all logs
if (isset($_GET['clear_all'])) {
    $query = "DELETE FROM iB_notifications";
    $stmt = $mysqli->prepare($query);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Audit Logs Cleared successfully";
    } else {
        $err = "Try again later";
    }
}

// Delete single log
if (isset($_GET['delete_log'])) {
    $log_id = intval($_GET['delete_log']);
    $query = "DELETE FROM iB_notifications WHERE notification_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $log_id);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Audit Log Entry Deleted";
    } else {
        $err = "Try again later";
    }
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
                        <h1>System Audit Logs</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Audit Logs</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-purple card-outline">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">System Operation Audit Trails & Activity History</h3>
                                <div class="card-tools ml-auto">
                                    <a href="pages_audit_logs.php?clear_all=true" onclick="return confirm('Are you sure you want to wipe all audit logs? This action is irreversible.');" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt mr-1"></i> Clear All Logs
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-hover table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Timestamp</th>
                                            <th>Event Status</th>
                                            <th>Log Details</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ret = "SELECT * FROM iB_notifications ORDER BY notification_id DESC";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        $cnt = 1;
                                        while ($row = $res->fetch_object()) {
                                            $details = htmlspecialchars($row->created_at);
                                            
                                            // Determine Event type for display badge
                                            $badge_class = "badge-info";
                                            $icon = "fa-info-circle";
                                            if (stripos($row->notification_details, 'Deposit') !== false) {
                                                $badge_class = "badge-success";
                                                $icon = "fa-upload";
                                            } elseif (stripos($row->notification_details, 'Withdraw') !== false) {
                                                $badge_class = "badge-danger";
                                                $icon = "fa-download";
                                            } elseif (stripos($row->notification_details, 'Transfer') !== false) {
                                                $badge_class = "badge-warning";
                                                $icon = "fa-exchange-alt";
                                            } elseif (stripos($row->notification_details, 'Account') !== false) {
                                                $badge_class = "badge-primary";
                                                $icon = "fa-folder-open";
                                            }
                                        ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td>
                                                    <span class="text-muted small font-weight-bold">
                                                        <i class="far fa-clock mr-1"></i>
                                                        <?php echo date("d-M-Y :: h:i:s A", strtotime($row->created_at)); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge <?php echo $badge_class; ?>">
                                                        <i class="fas <?php echo $icon; ?> mr-1"></i>
                                                        Audit Event
                                                    </span>
                                                </td>
                                                <td class="font-weight-bold"><?php echo htmlspecialchars($row->notification_details); ?></td>
                                                <td>
                                                    <a href="pages_audit_logs.php?delete_log=<?php echo $row->notification_id; ?>" onclick="return confirm('Delete this log entry?');" class="btn btn-danger btn-xs">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                            $cnt++;
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
        </section>
    </div>
    <!-- /.content-wrapper -->
    <?php include("dist/_partials/footer.php"); ?>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "order": [[ 0, "asc" ]]
    });
  });
</script>
</body>
</html>
