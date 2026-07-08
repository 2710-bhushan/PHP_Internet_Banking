<?php
$staff_id = $_SESSION['staff_id'];
$ret = "SELECT * FROM iB_staff WHERE staff_id = ?";
$stmt = $mysqli->prepare($ret);
$stmt->bind_param('i', $staff_id);
$stmt->execute();
$res = $stmt->get_result();
$staff_name = "Staff";
while ($row = $res->fetch_object()) {
    $staff_name = $row->name;
}
$first_name = explode(' ', trim($staff_name))[0];
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav align-items-center">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block ml-3">
            <span class="font-weight-bold" style="font-size: 1.05rem; color: var(--text-color);">
                Welcome, <span style="color: var(--secondary-color);"><?php echo htmlspecialchars($first_name); ?></span> 
                <span class="font-weight-normal text-muted small ml-1">(Operational Staff)</span>
            </span>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto align-items-center">
        <!-- Live Clock -->
        <li class="nav-item d-none d-md-inline-block mr-4">
            <span id="live-banking-clock" class="badge badge-light p-2 font-weight-bold text-muted" style="border:1px solid var(--border-color); font-size:0.85rem">
                <i class="far fa-clock mr-1" style="color: var(--secondary-color)"></i> Loading Time...
            </span>
        </li>

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" style="position:relative">
                <i class="far fa-bell" style="font-size:1.15rem"></i>
                <?php
                //code for summing up notifications
                $result = "SELECT count(*) FROM iB_notifications";
                $stmt = $mysqli->prepare($result);
                $stmt->execute();
                $stmt->bind_result($ntf);
                $stmt->fetch();
                $stmt->close();
                ?>
                <span class="badge badge-danger navbar-badge" style="top:5px; right:2px"><?php echo $ntf; ?></span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header font-weight-bold"><?php echo $ntf; ?> System Alerts</span>
                <div class="dropdown-divider"></div>
                
                <div style="max-height: 250px; overflow-y: auto;">
                    <?php
                    $ret = "SELECT * FROM iB_notifications ORDER BY notification_id DESC LIMIT 5";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_object()) {
                            $notification_time = $row->created_at;
                    ?>
                        <a href="pages_dashboard.php?Clear_Notifications=<?php echo $row->notification_id; ?>" class="dropdown-item d-flex justify-content-between align-items-start">
                            <div style="padding-right: 15px;">
                                <p class="text-sm mb-1" style="white-space: normal; line-height:1.3; font-weight:500;"><?php echo $row->notification_details; ?></p>
                                <span class="text-xs text-muted"><i class="far fa-clock mr-1"></i><?php echo date("d-M :: h:i A", strtotime($notification_time)); ?></span>
                            </div>
                            <span class="text-danger text-xs"><i class="fas fa-trash"></i></span>
                        </a>
                    <?php 
                        } 
                    } else {
                        echo '<a href="#" class="dropdown-item text-center text-muted small">No notifications found</a>';
                    }
                    ?>
                </div>
                <div class="dropdown-divider"></div>
                <a href="pages_dashboard.php" class="dropdown-item dropdown-footer text-center small font-weight-bold" style="color: var(--secondary-color)">Back to Dashboard</a>
            </div>
        </li>
    </ul>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function updateClock() {
            const clockEl = document.getElementById("live-banking-clock");
            if (!clockEl) return;
            const now = new Date();
            const options = { 
                weekday: 'short', 
                day: '2-digit', 
                month: 'short', 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                hour12: true 
            };
            clockEl.innerHTML = '<i class="far fa-clock mr-1" style="color: var(--secondary-color)"></i> ' + now.toLocaleString('en-US', options);
        }
        setInterval(updateClock, 1000);
        updateClock();
    });
</script>