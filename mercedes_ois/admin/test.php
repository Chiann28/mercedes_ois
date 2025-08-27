<!DOCTYPE html>
<html lang="en" ng-app="mercedesApp">

<head>
    <meta charset="UTF-8">
    <title>Mercedes OIS - Test UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.3/angular.min.js"></script>

    <script src="../../mercedes_ois/admin/js/Sample.js"></script>
</head>

<body class="bg-light" ng-controller="SampleController" ng-init="init()">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-lg">
                    <div class="card-body">
                        <h4 class="card-title mb-3 text-center">Search User by Client</h4>

                        <div class="mb-3">
                            <label for="client" class="form-label">Client Name</label>
                            <input type="text" class="form-control" id="client" ng-model="client"
                                placeholder="Enter client name">
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary" ng-click="searchClient()">Search</button>
                        </div>

                        <div class="mt-4" ng-if="test.length > 0">
                            <h6>Results:</h6>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Username</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>Modified Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="list in test">
                                        <td ng-bind="list.user_id"></td>
                                        <td ng-bind="list.username"></td>
                                        <td ng-bind="list.firstname"></td>
                                        <td ng-bind="list.lastname"></td>
                                        <td ng-bind="list.modifieddate"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4" ng-if="test.length === 0">
                            <div class="alert alert-warning">No results found for "{{client}}"</div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>