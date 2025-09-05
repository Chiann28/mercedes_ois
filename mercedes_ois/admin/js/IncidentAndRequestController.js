var app = angular.module("mercedesApp", []);

app.service("API", function ($http) {
  this.getApi = function (url, params) {
    return $http({
      method: "GET",
      url: url,
      params: params,
    });
  };

  this.postApi = function (url, data) {
    return $http({
      method: "POST",
      url: url,
      data: data,
    });
  };
});

// Controller Start
app.controller("IncidentAndRequestController", function ($scope, API) {
  $scope.client = "mercedes";
  $scope.customer = $scope.customer || {};
  $scope.VerifySession = function () {
    console.log("Ledger Loaded");
    API.getApi("api/AdminAPI.php", { request_type: "VerifySession" }).then(
      function (response) {
        var final_response = response.data;

        if (final_response.result && final_response.role === "admin") {
          console.log("Welcome " + final_response.username + " (Admin)");
        } else if (final_response.result) {
          window.location.href = "../../mercedes_ois/user/MDXUserDashboard.php";
        } else {
          window.location.href = "../../mercedes_ois/user/MDXLogin.php";
        }
      }
    );
  };

  $scope.GetRequestAndIncidents = function () {
    Swal.fire({
      title: "Loading...",
      text: "Fetching account list, please wait.",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      request_type: "GetRequestAndIncidents",
    };

    API.getApi("api/IncidentAndRequestAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.listAll = final_response.All;
      console.log(final_response);
      $scope.listNew = final_response.New;
      $scope.listInprogress = final_response.In_Progress;
      $scope.listResolved = final_response.Resolved;
      $scope.listClosed = final_response.Closed;
      Swal.close();
    });
  };

  $scope.selectedItem = {};

  $scope.openModal = function (item) {
    $scope.selectedItem = angular.copy(item);
    $scope.GetCommentById($scope.selectedItem.id);
    var modal = new bootstrap.Modal(document.getElementById("detailsModal"));
    modal.show();
  };

  $scope.DoPostComment = function (id) {
    var data = {
      client: $scope.client,
      id: id,
      comment: $scope.comment,
      request_type: "DoPostComment",
    };

    API.postApi("api/IncidentAndRequestAPI.php", data).then(function (
      response
    ) {
      var final_response = JSON.parse(atob(response.data));
      console.log(final_response);
      $scope.comment = "";
      $scope.GetCommentById(id);
    });
  };

  $scope.GetCommentById = function (id) {
    var data = {
      client: $scope.client,
      id: id,
      request_type: "GetCommentById",
    };

    API.getApi("api/IncidentAndRequestAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.comments = final_response;
      console.log($scope.comments);
    });
  };

  $scope.DoSaveChanges = function (item) {
    var data = {
      id: item.id,
      description: item.description,
      priority: item.priority,
      status: item.status,
      client: $scope.client,
      resolved_date: item.resolved_date,
      request_type: "DoSaveChanges",
    };

    API.postApi("api/IncidentAndRequestAPI.php", data).then(function (
      response
    ) {
      var final_response = JSON.parse(atob(response.data));
      console.log(final_response);
      $scope.comment = "";

      $scope.GetCommentById(item.id);

      if (final_response) {
        location.reload();
      }
    });
  };

  $scope.$watch(
    "selectedItem",
    function (newVal) {
      if (!newVal) return;
      if (typeof newVal.sysentrydate === "string") {
        newVal.sysentrydate = new Date(newVal.sysentrydate);
      }
      if (typeof newVal.modifieddate === "string") {
        newVal.modifieddate = new Date(newVal.modifieddate);
      }
      if (typeof newVal.resolved_date === "string" && newVal.resolved_date) {
        newVal.resolved_date = new Date(newVal.resolved_date);
      }
    },
    true
  );
});
