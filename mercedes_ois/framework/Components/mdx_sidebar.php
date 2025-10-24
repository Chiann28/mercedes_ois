<div class="sidebar" id="sidebar">
    <div class="sidebar-header mb-4">
        <img src="../admin/logo_mercedes.png" class="mx-auto sidebar-logo img-fluid" alt="Logo" class="mx-auto">
    </div>


    <a href="../../mercedes_ois/admin/mdx_admin_dashboard.php" class="sidebar-icon" id="sidebarDashboard"><i
            class="fa-solid fa-chart-line sidebar-icon"></i> <span class="sidebar-text ms-2">Admin Dashboard</span></a>


    <a class="sidebar-icon" data-bs-toggle="collapse" href="#residentInformationMenu" role="button"
        aria-expanded="false" aria-controls="residentInformationMenu"><i class="fa-solid fa-users sidebar-icon"></i>
        <span class="sidebar-text ms-2">Resident Information</span></a>

    <div class="collapse" id="residentInformationMenu">
        <ul class="list-unstyled">
            <li>
                <a href="../../mercedes_ois/admin/mdx_resident_master_data.php" id="rmdSideButton"
                    class="sidebar-sub-link">
                    <i class="fa-solid fa-database"></i>
                    <span class="sidebar-text ms-2"> Resident Master Data</span>
                </a>
            </li>
            <li>
                <a href="../../mercedes_ois/admin/mdx_new_application.php" id="newAppSideButton"
                    class="sidebar-sub-link">
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

    <a class="sidebar-icon" data-bs-toggle="collapse" href="#propertiesMenu" role="button" aria-expanded="false"
        aria-controls="propertiesMenu"><i class="fa-solid fa-house-chimney-user sidebar-icon"></i>
        <span class="sidebar-text ms-2">Properties</span></a>

    <div class="collapse" id="propertiesMenu">
        <ul class="list-unstyled">
            <li>
                <a href="../../mercedes_ois/admin/mdx_property_master_data.php" id="sidebarPMD"
                    class="sidebar-sub-link">
                    <i class="fa-solid fa-people-roof"></i>
                    <span class="sidebar-text ms-2"> Property Master Data</span>
                </a>
            </li>
            <li>
                <a href="../../mercedes_ois/admin/mdx_new_property.php" id="sidebarNewProp" class="sidebar-sub-link">
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

    <a href="mdx_announcement.php" class="sidebar-icon" id="sidebarAnnouncement"><i
            class="fa-solid fa-bullhorn sidebar-icon"></i> <span class="sidebar-text ms-2">Announcement
            Module</span></a>

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
                <a href="../../mercedes_ois/admin/mdx_add_transactions.php" id="addTransaction"
                    class="sidebar-sub-link">
                    <i class="fa-solid fa-plus me-2"></i><span class="sidebar-text ms-2"> Add New Transaction</span>
                </a>
            </li>
            <li>
                <a href="mdx_import_transaction.php" id="importTransaction" class="sidebar-sub-link">
                    <i class="fa-solid fa-file-import me-2"></i><span class="sidebar-text ms-2"> Import
                        Transaction</span>
                </a>
            </li>
            <li>
                <a href="mdx_ledger.php" id="ledger" class="sidebar-sub-link">
                    <i class="fa-solid fa-book me-2"></i> <span class="sidebar-text ms-2">Ledger</span>
                </a>
            </li>
            <li>
                <a href="mdx_adjustments.php" id="adjustment" class="sidebar-sub-link">
                    <i class="fa-solid fa-sliders me-2"></i> <span class="sidebar-text ms-2">Adjustments</span>
                </a>
            </li>
            <li>
                <a href="mdx_bill_generation.php" id="billGeneration" class="sidebar-sub-link">
                    <i class="fa-solid fa-sliders me-2"></i> <span class="sidebar-text ms-2">Bill Generation</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Transactions End -->

    <a href="mdx_events.php" class="sidebar-icon" id="sidebarEvents"><i
            class="fa-solid fa-calendar sidebar-icon"></i><span class="sidebar-text ms-2">Events and
            Operations</span></a>

    <a class="sidebar-icon" href="mdx_incident_and_requests.php" id="sidebarIncident" role="button"
        aria-expanded="false" aria-controls="residentInformationMenu"><i class="fa-solid fa-bell sidebar-icon"></i>
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
                <a href="../../mercedes_ois/admin/mdx_residents_report.php" id="reportMasterlist"
                    class="sidebar-sub-link">
                    <i class="fa-solid fa-image-portrait me-2"></i><span class="sidebar-text ms-2"> Residents
                        Masterlist</span>
                </a>
            </li>
            <li>
                <a href="../../mercedes_ois/admin/mdx_announcement_report.php" id="reportAnnouncement"
                    class="sidebar-sub-link">
                    <i class="fa-solid fa-scroll me-2"></i>
                    <span class="sidebar-text ms-2">
                        Announcement History</span>
                </a>
            </li>
            <li>
                <a href="../../mercedes_ois/admin/mdx_collection_report.php" id="reportPayment"
                    class="sidebar-sub-link">
                    <i class="fa-solid fa-file-invoice me-2"></i>
                    <span class="sidebar-text ms-2">Payment Collection</span>
                </a>
            </li>
            <li>
                <a href="../../mercedes_ois/admin/mdx_event_report.php" id="reportEvents" class="sidebar-sub-link">
                    <i class="fa-solid fa-calendar-check me-2"></i>
                    <span class="sidebar-text ms-2">Events </span>
                </a>
            </li>
            <li>
                <a href="../../mercedes_ois/admin/mdx_incident_report.php" id="reportIncident" class="sidebar-sub-link">
                    <i class="fa-solid fa-clipboard-list me-2"></i>
                    <span class="sidebar-text ms-2">Incident Logs</span>
                </a>
            </li>
        </ul>
    </div>


</div>

<script>
    // BOOM! PARANG NENENG B ANG KANYANG KATAWAN
    let sidebarDashboard = document.getElementById('sidebarDashboard');

    let residentInformationMenu = document.getElementById('residentInformationMenu');
    let rmd = document.getElementById('rmdSideButton');
    let newapp = document.getElementById('newAppSideButton');

    let propertiesMenu = document.getElementById('propertiesMenu');
    let pmd = document.getElementById('sidebarPMD');
    let newprop = document.getElementById('sidebarNewProp');

    let announcementSidebar = document.getElementById('sidebarAnnouncement');

    let transactionMenu = document.getElementById("transactionMenu");
    let addTransaction = document.getElementById("addTransaction");
    let importTransaction = document.getElementById("importTransaction");
    let ledger = document.getElementById("ledger");
    let adjustment = document.getElementById("adjustment");
    let billGeneration = document.getElementById("billGeneration");

    let reportsMenu = document.getElementById("reportMenu");
    let reportMasterlist = document.getElementById("reportMasterlist");
    let reportAnnouncement = document.getElementById("reportAnnouncement");
    let reportPayment = document.getElementById("reportPayment");
    let reportEvents = document.getElementById("reportEvents");
    let reportIncident = document.getElementById("reportIncident");

    let sidebarEvents = document.getElementById('sidebarEvents');
    let sidebarIncident = document.getElementById('sidebarIncident');

    let pageName = window.location.pathname.split("/").pop().split(".")[0];

    switch (pageName) {
        case 'mdx_admin_dashboard':
            sidebarDashboard.classList.add("sidebar-active");
            break;
        case 'mdx_resident_master_data':
            residentInformationMenu.classList.add("show");
            rmd.classList.add("sidebar-active");
            break;
        case 'mdx_new_application':
            residentInformationMenu.classList.add("show");
            newapp.classList.add("sidebar-active");
            break;
        case 'mdx_property_master_data':
            propertiesMenu.classList.add("show");
            pmd.classList.add("sidebar-active");
            break;
        case 'mdx_new_property':
            propertiesMenu.classList.add("show");
            newprop.classList.add("sidebar-active");
            break;
        case 'mdx_announcement':
            announcementSidebar.classList.add("sidebar-active");
            break;
        case 'mdx_add_transactions':
            transactionMenu.classList.add("show");
            addTransaction.classList.add("sidebar-active");
            break;
        case 'mdx_import_transaction':
            transactionMenu.classList.add("show");
            importTransaction.classList.add("sidebar-active");
            break;
        case 'mdx_ledger':
            transactionMenu.classList.add("show");
            ledger.classList.add("sidebar-active");
            break;
        case 'mdx_adjustments':
            transactionMenu.classList.add("show");
            adjustment.classList.add("sidebar-active");
            break;
        case 'mdx_bill_generation':
            transactionMenu.classList.add("show");
            billGeneration.classList.add("sidebar-active");
            break;
        case 'mdx_events':
            sidebarEvents.classList.add("sidebar-active");
            break;
        case 'mdx_incident_and_requests':
            sidebarIncident.classList.add("sidebar-active");
            break;
        case 'mdx_residents_report':
            reportsMenu.classList.add("show");
            reportMasterlist.classList.add("sidebar-active");
            break;
        case 'mdx_announcement_report':
            reportsMenu.classList.add("show");
            reportAnnouncement.classList.add("sidebar-active");
            break;
        case 'mdx_collection_report':
            reportsMenu.classList.add("show");
            reportPayment.classList.add("sidebar-active");
            break;
        case 'mdx_event_report':
            reportsMenu.classList.add("show");
            reportEvents.classList.add("sidebar-active");
            break;
        case 'mdx_incident_report':
            reportsMenu.classList.add("show");
            reportIncident.classList.add("sidebar-active");
            break;

        default:
            break;
    }
</script>