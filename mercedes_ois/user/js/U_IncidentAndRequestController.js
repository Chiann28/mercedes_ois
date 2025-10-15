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
app.controller("U_IncidentAndRequestController", function ($scope, API) {
  $scope.client = "mercedes";

  $scope.init = function (type) {
    var data = {
      client: $scope.client,
      request_type: "GetUserData",
    };

    API.getApi("api/UserDashboardAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.data = final_response;
      console.log($scope.data);

      switch (type) {
        case "incident":
          $scope.GetReportTicket($scope.data.accountnumber);
          break;
        case "request":
          $scope.GetRequestTicket($scope.data.accountnumber);
          break;
        default:
          break;
      }
    });
  };

  $scope.GetReportTicket = function (accountnumber) {
    var data = {
      client: $scope.client,
      accountnumber: accountnumber,
      request_type: "GetReportTicket",
    };
    API.getApi("api/U_IncidentAndRequestAPI.php", data).then(function (
      response
    ) {
      var final_response = JSON.parse(atob(response.data));
      $scope.rt = final_response;
    });
  };

  $scope.GetRequestTicket = function (accountnumber) {
    console.log("get report ticket: " + accountnumber);

    var data = {
      client: $scope.client,
      accountnumber: accountnumber,
      request_type: "GetRequestTicket",
    };
    API.getApi("api/U_IncidentAndRequestAPI.php", data).then(function (
      response
    ) {
      var final_response = JSON.parse(atob(response.data));
      $scope.rt = final_response;
    });
  };

  $scope.submitReport = function () {
    // Show loading SweetAlert
    Swal.fire({
      title: "Submitting Report...",
      text: "Please wait while we process your request.",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      report: $scope.ri,
      accountnumber: $scope.data.accountnumber,
      request_type: "submitReport",
    };

    API.postApi("api/U_IncidentAndRequestAPI.php", data)
      .then(function (response) {
        var final_response = JSON.parse(atob(response.data));
        $scope.data = final_response;
        console.log($scope.data);

        // Close the loader
        Swal.close();

        // Show result alert
        if ($scope.data.result) {
          Swal.fire({
            icon: "success",
            title: "Report Submitted!",
            text: "Your report has been successfully submitted.",
            timer: 2000,
            showConfirmButton: false,
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Submission Failed",
            text: "Something went wrong while submitting your report.",
          });
        }
      })
      .catch(function (error) {
        Swal.close();
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "An unexpected error occurred.",
        });
        console.error(error);
      });
  };

  $scope.submitRequest = function () {
    // Show loading SweetAlert
    Swal.fire({
      title: "Submitting Report...",
      text: "Please wait while we process your request.",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      request: $scope.ri,
      accountnumber: $scope.data.accountnumber,
      request_type: "submitRequest",
    };

    API.postApi("api/U_IncidentAndRequestAPI.php", data)
      .then(function (response) {
        var final_response = JSON.parse(atob(response.data));
        $scope.data = final_response;
        console.log($scope.data);

        // Close the loader
        Swal.close();

        // Show result alert
        if ($scope.data.result) {
          Swal.fire({
            icon: "success",
            title: "Request Submitted!",
            text: "Your request has been successfully submitted.",
            timer: 2000,
            showConfirmButton: false,
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Submission Failed",
            text: "Something went wrong while submitting your report.",
          });
        }
      })
      .catch(function (error) {
        Swal.close();
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "An unexpected error occurred.",
        });
        console.error(error);
      });
  };

  $scope.openDetails = function (tix) {
    $scope.selectedItem = tix;

    $scope.loadComments($scope.selectedItem.id);
    $scope.$applyAsync(); //Ensure Angular updates bindings

    const modal = new bootstrap.Modal(document.getElementById("detailsModal"));
    modal.show();
  };

  $scope.loadComments = function (report_id) {
    var data = {
      client: $scope.client,
      report_id: report_id,
      request_type: "loadComments",
    };
    API.getApi("api/U_IncidentAndRequestAPI.php", data).then(function (
      response
    ) {
      var final_response = JSON.parse(atob(response.data));
      $scope.comments = final_response;
      // console.log($scope.comments);
    });
  };

  $scope.DoPostComment = function (report_id) {
    data = {
      client: $scope.client,
      params: {
        report_id: report_id,
        accountnumber: $scope.data.accountnumber,
        fullname: $scope.data.fullname,
        comment: $scope.send_comment,
      },
      request_type: "DoPostComment",
    };
    console.log(data);
    API.postApi("api/U_IncidentAndRequestAPI.php", data).then(function (
      response
    ) {
      var final_response = JSON.parse(atob(response.data));
      console.log(final_response);
      $scope.send_comment = "";
      $scope.loadComments(report_id);
    });

    console.log(data);
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
