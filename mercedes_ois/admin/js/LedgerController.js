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
app.controller("LedgerController", function ($scope, API) {
  $scope.client = "mercedes";

  var now = new Date();
  $scope.selectedMonthDate = now;

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
      $scope.customer = final_response;

      if (final_response) {
        $scope.GetTransactionHistory($scope.customer.accountnumber);
      }
      Swal.close();
    });
  };

  $scope.GetTransactionHistory = function (accountnumber) {
    var data = {
      client: $scope.client,
      accountnumber: accountnumber,
      request_type: "GetTransactionHistory",
    };

    API.getApi("api/LedgerAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.Transactions = final_response;
      $scope.GetAdjustments(accountnumber);
    });
  };

  $scope.GetAdjustments = function (accountnumber) {
    var data = {
      client: $scope.client,
      accountnumber: accountnumber,
      request_type: "GetAdjustments",
    };

    API.getApi("api/LedgerAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.Adjustments = final_response;
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

  $scope.DoGenerateBill = function () {
    Swal.fire({
      title: "Generating accounts...",
      text: "Please wait.",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      request_type: "DoGenerateBill",
    };

    API.getApi("api/LedgerAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      console.log(final_response);

      if (final_response.result) {
        Swal.fire({
          icon: "success",
          title: "Successfully Posted",
          text: final_response.message,
          confirmButtonText: "OK",
          confirmButtonColor: "#6c757d",
          allowOutsideClick: false,
          allowEscapeKey: true,
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Unsuccessfully Posted",
          text: final_response.message,
          confirmButtonText: "OK",
          confirmButtonColor: "#6c757d",
          allowOutsideClick: false,
          allowEscapeKey: true,
        });
      }
    });
  };

  $scope.DoPrintReceipt = function (transaction_reference) {
    // Swal.fire({
    //   title: "Generating receipt...",
    //   text: "Please wait.",
    //   allowOutsideClick: false,
    //   didOpen: () => {
    //     Swal.showLoading();
    //   },
    // });

    window.open(
      "api/LedgerAPI.php?request_type=DoPrintReceipt&transaction_reference=" +
        transaction_reference,
      "_blank"
    );
  };
});
