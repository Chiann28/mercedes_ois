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
app.controller("AddTransactionsController", function ($scope, API) {
  $scope.client = "mercedes";
  $scope.customer = $scope.customer || {};
  $scope.VerifySession = function () {
    console.log("Transaction Loaded");
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
      request_type: "GetAccountList",
    };

    API.getApi("api/AddTransactionsAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.accountlist = final_response;
      console.log($scope.accountlist);

      var modal = new bootstrap.Modal(
        document.getElementById("accountSearchModal")
      );

      modal.show();
      Swal.close();
    });
  };

  $scope.PopulateAccountDetails = function (account) {
    $scope.customer = account;
    $scope.customer.accountnumber = account.accountnumber;
    $scope.customer.country = "Philippines";
    $scope.customer.street = "Soro Soro";
    $scope.customer.city = "Batangas City";
    $scope.customer.postal = "4200";

    $scope.GetLatestTransactions(account.accountnumber);
  };

  $scope.GetLatestTransactions = function (accountnumber) {
    var data = {
      client: $scope.client,
      accountnumber: accountnumber,
      request_type: "GetLatestTransactions",
    };

    API.getApi("api/AddTransactionsAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.LatestTransaction = final_response;
    });
  };

  $scope.DoPostPayment = function () {
    if ($scope.customer.accountnumber == undefined) {
      Swal.fire({
        icon: "warning",
        title: "Missing Account",
        text: "Please select an account before proceeding.",
        confirmButtonText: "OK",
        confirmButtonColor: "#6c757d",
        allowOutsideClick: false,
        allowEscapeKey: true,
      });
      return;
    }

    let amount = parseFloat($scope.amount_paid);

    if (isNaN(amount) || amount <= 0) {
      console.log($scope.amount_paid);
      Swal.fire({
        icon: "warning",
        title: "Invalid Payment",
        text: "Please input a valid amount",
        confirmButtonText: "OK",
        confirmButtonColor: "#6c757d",
        allowOutsideClick: false,
        allowEscapeKey: true,
      });
      return;
    }

    if ($scope.transaction_type == undefined) {
      Swal.fire({
        icon: "warning",
        title: "Invalid Transaction Type",
        text: "Please choose a valid transaction type",
        confirmButtonText: "OK",
        confirmButtonColor: "#6c757d",
        allowOutsideClick: false,
        allowEscapeKey: true,
      });
      return;
    }

    if ($scope.payment_status == undefined) {
      Swal.fire({
        icon: "warning",
        title: "Invalid Payment Status",
        text: "Please choose a valid payment status",
        confirmButtonText: "OK",
        confirmButtonColor: "#6c757d",
        allowOutsideClick: false,
        allowEscapeKey: true,
      });
      return;
    }

    Swal.fire({
      title: "Posting payment",
      text: "Please Wait . . .",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      accountnumber: $scope.customer.accountnumber,
      amount_paid: $scope.amount_paid,
      status: $scope.payment_status,
      transaction_type: $scope.transaction_type,
      request_type: "DoPostPayment",
    };

    // console.log(data);
    // return;
    API.postApi("api/AddTransactionsAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.result = final_response;
      console.log($scope.result);
      Swal.close();

      if ($scope.result.result) {
        Swal.fire({
          title: "Success!",
          text: $scope.result.message,
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
          text: $scope.result.message,
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    });
  };
});
