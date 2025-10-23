<div class="sidebar" id="sidebar">
    <div class="sidebar-header mb-4">
        <img src="../admin/logo_mercedes.png" class="mx-auto sidebar-logo img-fluid" alt="Logo" class="mx-auto">
    </div>
    <a href="../../mercedes_ois/admin/mdx_admin_dashboard.php" class="sidebar-icon"><i
            class="fa-solid fa-chart-line sidebar-icon"></i> <span class="sidebar-text ms-2">Admin Dashboard</span></a>


    <a class="sidebar-icon" data-bs-toggle="collapse" href="#residentInformationMenu" role="button"
        aria-expanded="false" aria-controls="residentInformationMenu"><i class="fa-solid fa-users sidebar-icon"></i>
        <span class="sidebar-text ms-2">Resident Information</span></a>

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
            <!-- <li>
                <a href="../../mercedes_ois/admin/mdx_account_request.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-user-check"></i>
                    <span class="sidebar-text ms-2"> Account Requests</span>
                </a>
            </li> -->
        </ul>
    </div>

    <a class="sidebar-icon" data-bs-toggle="collapse" href="#propertiesMenu" role="button"
        aria-expanded="false" aria-controls="propertiesMenu"><i class="fa-solid fa-house-chimney-user sidebar-icon"></i>
        <span class="sidebar-text ms-2">Properties</span></a>

    <div class="collapse" id="propertiesMenu">
        <ul class="list-unstyled">
            <li>
                <a href="../../mercedes_ois/admin/mdx_property_master_data.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-people-roof"></i>
                    <span class="sidebar-text ms-2"> Property Master Data</span>
                </a>
            </li>
            <li>
                <a href="../../mercedes_ois/admin/mdx_new_property.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-house-medical"></i>
                    <span class="sidebar-text ms-2"> New Property</span>
                </a>
            </li>
            <!-- <li>
                <a href="../../mercedes_ois/admin/mdx_account_request.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-user-check"></i>
                    <span class="sidebar-text ms-2"> Account Requests</span>
                </a>
            </li> -->
        </ul>
    </div>
    


    <a href="mdx_announcement.php" class="sidebar-icon"><i class="fa-solid fa-bullhorn sidebar-icon"></i> <span
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
                <a href="mdx_import_transaction.php" class="sidebar-sub-link">
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
            <li>
                <a href="mdx_bill_generation.php" class="sidebar-sub-link">
                    <i class="fa-solid fa-sliders me-2"></i> <span class="sidebar-text ms-2">Bill Generation</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Transactions End -->

    <a href="mdx_events.php" class="sidebar-icon"><i class="fa-solid fa-calendar sidebar-icon"></i><span
            class="sidebar-text ms-2">Events and Operations</span></a>

    <a class="sidebar-icon" href="mdx_incident_and_requests.php" role="button" aria-expanded="false"
        aria-controls="residentInformationMenu"><i class="fa-solid fa-bell sidebar-icon"></i>
        <span class="sidebar-text ms-2">Incidents and Requests</span>
    </a>

    <!-- REPORT -->
    <a class="sidebar-icon d-flex align-items-center" data-bs-toggle="collapse" href="#reportMenu" role="button"
        aria-expanded="false" aria-controls="reportMenu">
        <i class="fa-solid fa-money-check-dollar sidebar-icon"></i>
        <span class="sidebar-text ms-2">Reports</span>
        <!-- <i class="fa-solid fa-angle-down ms-auto"></i> -->
    </a>
    <div class="collapse" id="reportMenu">
        <ul class="list-unstyled">
            <li>
                <a href="../../mercedes_ois/admin/mdx_residents_report.php" class="sidebar-sub-link">
                    <span class="sidebar-text ms-2"> Residents Masterlist</span>
                </a>
            </li>
            <li>
                <a href="../../mercedes_ois/admin/mdx_announcement_report.php" class="sidebar-sub-link"><span
                        class="sidebar-text ms-2">
                        Announcement History</span>
                </a>
            </li>
            <li>
                <a href="../../mercedes_ois/admin/mdx_collection_report.php" class="sidebar-sub-link">
                    <span class="sidebar-text ms-2">Payment Collection</span>
                </a>
            </li>
            <li>
                <a href="../../mercedes_ois/admin/mdx_event_report.php" class="sidebar-sub-link">
                    <span class="sidebar-text ms-2">Events </span>
                </a>
            </li>
            <li>
                <a href="../../mercedes_ois/admin/mdx_incident_report.php" class="sidebar-sub-link">
                    <span class="sidebar-text ms-2">Incident Logs</span>
                </a>
            </li>
        </ul>
    </div>


</div>