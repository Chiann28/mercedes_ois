<div class="sidebar" id="sidebar">
    <div class="sidebar-header mb-4">
        <h4 class="m-0">LOGO</h4>
    </div>
    <a href="#" class="sidebar-icon"><i class="fa-solid fa-chart-line sidebar-icon"></i> <span
            class="sidebar-text ms-2">Admin Dashboard</span></a>
    <a href="#" class="sidebar-icon"><i class="fa-solid fa-users sidebar-icon"></i> <span
            class="sidebar-text ms-2">Resident Information</span></a>
    <a href="#" class="sidebar-icon"><i class="fa-solid fa-bullhorn sidebar-icon"></i> <span
            class="sidebar-text ms-2">Announcement Module</span></a>
    <!-- Transactions-->
    <a class="sidebar-icon d-flex align-items-center" data-bs-toggle="collapse" href="#transactionMenu" role="button"
        aria-expanded="false" aria-controls="transactionMenu">
        <i class="fa-solid fa-money-check-dollar sidebar-icon"></i>
        <span class="sidebar-text ms-2">Transaction</span>
        <i class="fa-solid fa-angle-down ms-auto"></i>
    </a>
    <div class="collapse ms-4" id="transactionMenu">
        <ul class="list-unstyled">
            <li>
                <a href="../../mercedes_ois/admin/mdx_add_transactions.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-plus me-2"></i> Add New Transaction
                </a>
            </li>
            <li>
                <a href="import_transaction.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-file-import me-2"></i> Import Transaction
                </a>
            </li>
            <li>
                <a href="mdx_ledger.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-book me-2"></i> Ledger
                </a>
            </li>
            <li>
                <a href="mdx_adjustments.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-sliders me-2"></i> Adjustments
                </a>
            </li>
        </ul>
    </div>
    <!-- Transactions End -->
    <a href="#" class="sidebar-icon"><i class="fa-solid fa-calendar sidebar-icon"></i><span
            class="sidebar-text ms-2">Events and Operations</span></a>

</div>