<div class="sidebar" id="sidebar">
    <div class="sidebar-header mb-4">
        <h4 class="m-0">LOGO</h4>
    </div>
    <a href="../../mercedes_ois/admin/mdx_admin_dashboard.php" class="sidebar-icon"><i
            class="fa-solid fa-chart-line sidebar-icon"></i> <span class="sidebar-text ms-2">Admin Dashboard</span></a>


    <a class="sidebar-icon" data-bs-toggle="collapse" href="#residentInformationMenu" role="button" aria-expanded="false"
        aria-controls="residentInformationMenu"><i class="fa-solid fa-users sidebar-icon"></i> <span
            class="sidebar-text ms-2">Resident Information</span></a>

    <div class="collapse" id="residentInformationMenu">
        <ul class="list-unstyled">
            <li>
                <a href="../../mercedes_ois/admin/mdx_resident_master_data.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-database"></i>
                    <span class="sidebar-text ms-2"> Resident Master Data</span>
                </a>
            </li>
            <li>
                <a href="../../mercedes_ois/admin/mdx_new_application.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-user-plus"></i>
                    <span class="sidebar-text ms-2"> New Application</span>
                </a>
            </li>
        </ul>
    </div>


    <a href="#" class="sidebar-icon"><i class="fa-solid fa-bullhorn sidebar-icon"></i> <span
            class="sidebar-text ms-2">Announcement Module</span></a>
    <!-- Transactions-->
    <a class="sidebar-icon d-flex align-items-center" data-bs-toggle="collapse" href="#transactionMenu" role="button"
        aria-expanded="false" aria-controls="transactionMenu">
        <i class="fa-solid fa-money-check-dollar sidebar-icon"></i>
        <span class="sidebar-text ms-2">Transaction</span>
        <!-- <i class="fa-solid fa-angle-down ms-auto"></i> -->
    </a>
    <div class="collapse" id="transactionMenu">
        <ul class="list-unstyled">
            <li>
                <a href="../../mercedes_ois/admin/mdx_add_transactions.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-plus me-2"></i><span class="sidebar-text ms-2"> Add New Transaction</span>
                </a>
            </li>
            <li>
                <a href="import_transaction.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-file-import me-2"></i><span class="sidebar-text ms-2"> Import
                        Transaction</span>
                </a>
            </li>
            <li>
                <a href="mdx_ledger.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-book me-2"></i> <span class="sidebar-text ms-2">Ledger</span>
                </a>
            </li>
            <li>
                <a href="mdx_adjustments.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-sliders me-2"></i> <span class="sidebar-text ms-2">Adjustments</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- Transactions End -->
    <a href="#" class="sidebar-icon"><i class="fa-solid fa-calendar sidebar-icon"></i><span
            class="sidebar-text ms-2">Events and Operations</span></a>

</div>