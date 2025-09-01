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
app.controller("ResidentMasterDataController", function ($scope, API) {
  $scope.client = "mercedes";
  $scope.mdx = $scope.mdx || {};

  $scope.VerifySession = function () {
    console.log("RMD Loaded");
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

  $scope.DoCreateAccount = function () {
    console.log(
      $scope.newacc_role
    );
    

    Swal.fire({
      title: "Loading...",
      text: "Processing New Application. Please Wait...",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      username: $scope.newacc_username,
      password: $scope.newacc_password,
      role: $scope.newacc_role,
      first_name: $scope.newacc_first_name,
      middle_name: $scope.newacc_middle_name,
      last_name: $scope.newacc_last_name,
      request_type: "DoCreateAccount",
    };

    API.getApi("api/ResidentMasterDataAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      console.log(final_response);

      Swal.close();

      if (final_response.result) {
        let modal =  bootstrap.Modal.getInstance(document.getElementById("newAccountModal"));
        modal.hide();
      
        
        Swal.fire({
          icon: "success",
          title: "Success!",
          text: final_response.message || "Account created successfully.",
        });
      } else {
        modal = new bootstrap.Modal(
          document.getElementById("newAccountModal")
        );
        modal.hide();
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: final_response.message || "Account creation failed.",
        });
      }
    });
  };

  $scope.openModalSearch = function () {
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
      accountnumber: $scope.accountnumber,
      request_type: "GetAccountList",
    };

    API.getApi("api/LedgerAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.accountlist = final_response;
      console.log($scope.accountlist);

      let modal;

      if ($scope.accountlist.length > 1) {
        Swal.close();
        modal = new bootstrap.Modal(
          document.getElementById("accountSearchModal")
        );
        modal.show();
      } else if ($scope.accountlist.length === 1) {
        $scope.GetAccountDetails(final_response[0].accountnumber);
        Swal.close();
      } else {
        Swal.close();
        Swal.fire({
          icon: "warning",
          title: "No Results",
          text: "No account found matching your search.",
          confirmButtonText: "OK",
          confirmButtonColor: "#6c757d",
        });
      }
    });
  };

  $scope.GetAccountDetails = function (accountnumber) {
    console.log(accountnumber);
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
      accountnumber: accountnumber,
      request_type: "GetAccountDetails",
    };

    API.getApi("api/LedgerAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.mdx = final_response;

      if (final_response.date_registered) {
        final_response.date_registered = new Date(
          final_response.date_registered
        );
      }

      if (final_response) {
        //$scope.GetTransactionHistory($scope.customer.accountnumber);
        console.log(final_response);
      }
      Swal.close();
    });
  };
});
