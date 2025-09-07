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
app.controller("NewApplicationController", function ($scope, API) {
  $scope.client = "mercedes";
  $scope.newapp = $scope.newapp || {};

  $scope.VerifySession = function () {
    console.log("New App Loaded");
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

  $scope.MDXSwalClose = function (delay) {
    setTimeout(function () {
      Swal.close();
    }, delay);
  };

  $scope.GetAccountRequest = function (){
    var data = {
      client: $scope.client,
      request_type: "GetAccountRequest"
    }
    API.getApi("api/NewApplicationAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      //console.log(final_response);
      $scope.request_list = final_response;

    });
  }

  $scope.DoGenerateAccountNumber = function () {
    var data = {
      client: $scope.client,
      request_type: "GenerateAccountnumber",
    };
    API.getApi("api/NewApplicationAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.response = final_response;
      $scope.newapp.accountnumber = $scope.response;
    });
  };

  $scope.DoGeneratePassword = function () {
    const chars = "0123456789";
    let password = "";

    for (let i = 0; i < 6; i++) {
      const randomIndex = Math.floor(Math.random() * chars.length);
      password += chars[randomIndex];
    }

    $scope.newapp.password = password;

    console.log("Generated Password:", password);
    return password;
  };

  $scope.DoCreateAccount = function () {
    //console.log($scope.request_id);
    var data = {
      client: $scope.client,
      params: $scope.newapp,
      request_id : $scope.request_id,
      request_type: "CreateAccount",
    }
    API.postApi("api/NewApplicationAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.response = final_response;
      if ($scope.response.result) {
        Swal.fire({
          title: "Success!",
          text: $scope.response.message,
          icon: "success",
          confirmButtonText: "Done",
        }).then((res) => {
          if (res.isConfirmed) {
            location.reload();
          }
        });
      } else {
        Swal.fire({
          title: "Error",
          text: $scope.response.message,
          icon: "error",
          confirmButtonText: "OK",
        });
        $scope.isEditing = false;
      }
      
    });
  }

  $scope.PopulateNewAppTable = function (req) {
    Swal.fire({
      title: "Loading...",
      text: "Fetching data, please wait.",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });
    setTimeout(function () {
        $scope.$apply(function () {
            $scope.newapp = req;
            $scope.request_id = req.request_id;
        });
        Swal.close(); // ✅ close the spinner
    }, 1000);
  }

  $scope.DiscardChanges = function () {
    $scope.newapp = '';
  }

  

});
