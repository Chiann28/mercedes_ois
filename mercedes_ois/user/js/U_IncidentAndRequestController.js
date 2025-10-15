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
          break
        default: break;
      }
    });
  };

  $scope.GetReportTicket = function(accountnumber){
    console.log('get report ticket: ' + accountnumber)

    var data = {
      client: $scope.client,
      accountnumber: accountnumber,
      request_type: 'GetReportTicket',
    }
    API.getApi("api/U_IncidentAndRequestAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.rt = final_response;
    });
    
  }

  $scope.GetRequestTicket = function(accountnumber){
    console.log('get report ticket: ' + accountnumber)

    var data = {
      client: $scope.client,
      accountnumber: accountnumber,
      request_type: 'GetRequestTicket',
    }
    API.getApi("api/U_IncidentAndRequestAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.rt = final_response;
    });
    
  }

  $scope.submitReport = function() {
  // Show loading SweetAlert
  Swal.fire({
    title: 'Submitting Report...',
    text: 'Please wait while we process your request.',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });

  var data = {
    client: $scope.client,
    report: $scope.ri,
    accountnumber: $scope.data.accountnumber,
    request_type: "submitReport"
  };

  API.postApi("api/U_IncidentAndRequestAPI.php", data).then(function(response) {
    var final_response = JSON.parse(atob(response.data));
    $scope.data = final_response;
    console.log($scope.data);

    // Close the loader
    Swal.close();

    // Show result alert
    if ($scope.data.result) {
      Swal.fire({
        icon: 'success',
        title: 'Report Submitted!',
        text: 'Your report has been successfully submitted.',
        timer: 2000,
        showConfirmButton: false
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Submission Failed',
        text: 'Something went wrong while submitting your report.'
      });
    }
  }).catch(function(error) {
    Swal.close();
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'An unexpected error occurred.'
    });
    console.error(error);
  });
  };

  $scope.submitRequest = function() {
  // Show loading SweetAlert
  Swal.fire({
    title: 'Submitting Report...',
    text: 'Please wait while we process your request.',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });

  var data = {
    client: $scope.client,
    request: $scope.ri,
    accountnumber: $scope.data.accountnumber,
    request_type: "submitRequest"
  };

  API.postApi("api/U_IncidentAndRequestAPI.php", data).then(function(response) {
    var final_response = JSON.parse(atob(response.data));
    $scope.data = final_response;
    console.log($scope.data);

    // Close the loader
    Swal.close();

    // Show result alert
    if ($scope.data.result) {
      Swal.fire({
        icon: 'success',
        title: 'Request Submitted!',
        text: 'Your request has been successfully submitted.',
        timer: 2000,
        showConfirmButton: false
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Submission Failed',
        text: 'Something went wrong while submitting your report.'
      });
    }
  }).catch(function(error) {
    Swal.close();
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'An unexpected error occurred.'
    });
    console.error(error);
  });
  };



  
});
