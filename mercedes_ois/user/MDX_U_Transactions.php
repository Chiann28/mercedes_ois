<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
    <meta charset="UTF-8">
    <title>MERCEDEX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>

    <script src="../../mercedes_ois/user/js/AccountSettingsController.js"></script>


    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- NASHIE CSS <3 -->
    <link rel="stylesheet" href="../framework/CSS/NashieCss-Frontend.css">
    <link rel="stylesheet" href="../framework/CSS/user_dashboard_anims.css">
</head>

<body class="bg-light" style="" ng-controller="AccountSettingsController" ng-init="init();
                                                                              get_transaction_history();">
    <?php require_once '../framework/Components/mdx_user_header.php'; ?>

    <div class="container-md mb-3 py-5" style="min-height: 87vh">

        <div class="p-5 mt-3 shadow-sm rounded border d-flex justify-content-between align-items-center">
            <h1 class="fw-semiboold">
                <i class="fa-solid fa-receipt lower-card-icon-rotate me-1"></i>
                Transactions
            </h1>
            <div>
                <!-- <button class="btn btn-secondary btn-sm" type="button" ng-click="InitializeUpdating()">
          <i class="fa-solid fa-xmark" ng-if="isEditing"></i>
          <i class="fa-solid fa-user-pen" ng-if="!isEditing"></i>

        </button> -->
            </div>

        </div>

        <div class="p-5 mt-3 shadow-sm rounded border">
            <div class="h5 text-uppercase fw-semibold mb-3">Transaction History</div>
            <hr>
            <div ng-repeat="t in transaction_data">
                <div class="p-3 border-bottom" data-bs-toggle="modal" data-bs-target="#transactionModal"
                    ng-click="GetTransactionDetails(t)" style="cursor: pointer;">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="h5 fw-normal text-uppercase">{{ t.transaction_type }}</p>
                            <p class="text-muted small">{{ t.transaction_date }}</p>
                        </div>
                        <div>
                            <p class="h5 fw-normal">
                                <span ng-bind="t.transaction_type === 'Payment' ? '-' : '+'"></span> PHP
                                <span ng-bind="t.transaction_type === 'Payment' ? t.credit : t.debit "></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h1 class="modal-title fs-6 fw-normal" id="exampleModalLabel">Reference Number</h1>
                        <span class="small">{{ td.transaction_reference }}</span>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <div class="d-flex">
                        <p class="text-muted text-uppercase small me-5">TYPE</p>
                        <p class="text-uppercase fs-5 fw-semibold ms-5">{{ td.transaction_type }}</p>
                    </div>
                    <div class="d-flex">
                        <p class="text-muted text-uppercase small me-5">AMOUNT</p>
                        <p class="text-uppercase fs-5 fw-semibold ms-5">{{ td.transaction_type }}</p>
                    </div> -->
                    <div class="row">
                        <div class="col-4">
                            <p class="text-muted text-uppercase small">TYPE</p>
                        </div>
                        <div class="col-8">
                            <p class="text-uppercase fs-5 fw-semibold">{{ td.transaction_type }}</p>
                        </div>

                        <div class="col-4">
                            <p class="text-muted text-uppercase small">AMOUNT</p>
                        </div>
                        <div class="col-8">
                            <p class="text-uppercase fs-5 fw-semibold">
                                PHP <span ng-bind="td.transaction_type === 'Payment' ? td.credit : td.debit"></span>
                            </p>
                        </div>
                    
                        <div class="col-4">
                            <p class="text-muted text-uppercase small">ENDING BALANCE</p>
                        </div>
                        <div class="col-8">
                            <p class="text-uppercase fs-5 fw-semibold">
                                PHP <span ng-bind="td.balance"></span>
                            </p>
                        </div>

                        <div class="col-4">
                            <p class="text-muted text-uppercase small">TRANSACTION DATE</p>
                        </div>
                        <div class="col-8">
                            <p class="text-uppercase fs-5 fw-semibold">
                                {{ td.transaction_date }}
                            </p>
                        </div>
                    </div>

                </div>
                <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
            </div>
        </div>
    </div>
    <?php require_once '../framework/Components/mdx_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>

</body>

</html>