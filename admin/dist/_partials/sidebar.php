<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <?php
  $admin_id = $_SESSION['admin_id'];
  $ret = "SELECT * FROM iB_admin WHERE admin_id = ? ";
  $stmt = $mysqli->prepare($ret);
  $stmt->bind_param('i', $admin_id);
  $stmt->execute(); //ok
  $res = $stmt->get_result();
  while ($row = $res->fetch_object()) {
    //set automatically logged in user default image if they have not updated their pics
    if ($row->profile_pic == '') {
      $profile_picture = "<img src='dist/img/user_icon.png' class='img-circle elevation-2' alt='User Image' style='border: 2px solid var(--primary-color); object-fit: cover; width:34px; height:34px'>";
    } else {
      $profile_picture = "<img src='dist/img/$row->profile_pic' class='img-circle elevation-2' alt='User Image' style='border: 2px solid var(--primary-color); object-fit: cover; width:34px; height:34px'>";
    }

    /* Persist System Settings On Brand */
    $ret_sys = "SELECT * FROM `iB_SystemSettings` ";
    $stmt_sys = $mysqli->prepare($ret_sys);
    $stmt_sys->execute(); //ok
    $res_sys = $stmt_sys->get_result();
    while ($sys = $res_sys->fetch_object()) {
  ?>

      <a href="pages_dashboard.php" class="brand-link px-3 d-flex align-items-center">
        <img src="dist/img/<?php echo $sys->sys_logo; ?>" alt="Logo" class="brand-image img-circle elevation-2" style="opacity: .9">
        <span class="brand-text font-weight-bold ml-2"><?php echo $sys->sys_name; ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
          <div class="image">
            <?php echo $profile_picture; ?>
          </div>
          <div class="info ml-2">
            <a href="pages_account.php" class="d-block font-weight-bold" style="line-height:1.2;"><?php echo htmlspecialchars($row->name); ?></a>
            <span class="text-xs text-muted" style="color: rgba(255,255,255,0.5) !important;">System Administrator</span>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            <li class="nav-header">Overview</li>
            <li class="nav-item">
              <a href="pages_dashboard.php" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages_global_search.php" class="nav-link">
                <i class="nav-icon fas fa-search"></i>
                <p>Global Search</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages_account.php" class="nav-link">
                <i class="nav-icon fas fa-user-shield"></i>
                <p>Admin Profile</p>
              </a>
            </li>

            <li class="nav-header">Staff Control</li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                  Staff Management
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages_add_staff.php" class="nav-link">
                    <i class="fas fa-plus nav-icon small"></i>
                    <p>Add Staff Member</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_manage_staff.php" class="nav-link">
                    <i class="fas fa-list nav-icon small"></i>
                    <p>Manage Staff</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header">Client Control</li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Client Management
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages_add_client.php" class="nav-link">
                    <i class="fas fa-plus nav-icon small"></i>
                    <p>Add Client Member</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_manage_clients.php" class="nav-link">
                    <i class="fas fa-list nav-icon small"></i>
                    <p>Manage Clients</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header">Core Banking</li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-briefcase"></i>
                <p>
                  Account Modules
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages_add_acc_type.php" class="nav-link">
                    <i class="fas fa-plus nav-icon small"></i>
                    <p>Add Account Type</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_manage_accs.php" class="nav-link">
                    <i class="fas fa-tasks nav-icon small"></i>
                    <p>Manage Account Types</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_open_acc.php" class="nav-link">
                    <i class="fas fa-folder-open nav-icon small"></i>
                    <p>Open Client Acc</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_manage_acc_openings.php" class="nav-link">
                    <i class="fas fa-list-ul nav-icon small"></i>
                    <p>Manage Open Accs</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header">Fund Operations</li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-dollar-sign"></i>
                <p>
                  Finances & Audits
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages_deposits.php" class="nav-link">
                    <i class="fas fa-arrow-alt-circle-up nav-icon small"></i>
                    <p>Deposit History</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_withdrawals.php" class="nav-link">
                    <i class="fas fa-arrow-alt-circle-down nav-icon small"></i>
                    <p>Withdrawal History</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_transfers.php" class="nav-link">
                    <i class="fas fa-random nav-icon small"></i>
                    <p>Transfer History</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_balance_enquiries.php" class="nav-link">
                    <i class="fas fa-search-dollar nav-icon small"></i>
                    <p>Balance Inquiries</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header">Reports & Auditing</li>
            <li class="nav-item">
              <a href="pages_transactions_engine.php" class="nav-link">
                <i class="nav-icon fas fa-history"></i>
                <p>Transaction Audit Logs</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages_audit_logs.php" class="nav-link">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>System Audit Logs</p>
              </a>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                <p>
                  Financial Reports
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages_financial_reporting_deposits.php" class="nav-link">
                    <i class="fas fa-file-export nav-icon small"></i>
                    <p>Deposits Report</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_financial_reporting_withdrawals.php" class="nav-link">
                    <i class="fas fa-file-import nav-icon small"></i>
                    <p>Withdrawals Report</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages_financial_reporting_transfers.php" class="nav-link">
                    <i class="fas fa-file-signature nav-icon small"></i>
                    <p>Transfers Report</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-header">Administration</li>
            <li class="nav-item">
              <a href="pages_system_settings.php" class="nav-link">
                <i class="nav-icon fas fa-sliders-h"></i>
                <p>System Settings</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages_logout.php" class="nav-link" style="background-color: rgba(239, 68, 68, 0.1) !important; color: #ef4444 !important;">
                <i class="nav-icon fas fa-power-off" style="color: #ef4444 !important"></i>
                <p>Log Out</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
  <?php
    }
  } ?>
</aside>