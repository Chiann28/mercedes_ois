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
app.controller("ImportTransactionController", function ($scope, API) {
  $scope.client = "mercedes";
  $scope.customer = $scope.customer || {};
  $scope.ImportedTransactions = [];
  $scope.selectAll = false;
  $scope.transactionDate = new Date().toISOString().split("T")[0];

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

  $scope.GetPaymentImport = function () {
    if ($scope.importDate == undefined) {
      $scope.importDate = new Date();
    }

    Swal.fire({
      title: "Loading...",
      text: "Fetching pending account, please wait.",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      date: $scope.importDate,
      request_type: "GetPaymentImport",
    };

    API.getApi("api/ImportTransactionAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.ImportedTransactions = final_response;
      console.log($scope.ImportedTransactions);
      Swal.close();
    });
  };

  $scope.importTransactions = function () {
    if (!$scope.file) {
      Swal.fire("No File", "Please select a file to import.", "warning");
      return;
    }

    Swal.fire({
      title: "Importing...",
      text: "Please wait while we process the file.",
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading(),
    });

    let reader = new FileReader();

    reader.onload = function (e) {
      let text = e.target.result;
      let rows = text.split("\n").filter((r) => r.trim() !== "");
      let data = rows.map((r) => r.split("|"));

      let payload = {
        request_type: "ImportTransactions",
        client: $scope.client,
        transaction_date: $scope.importDate,
        transactions: data,
      };

      API.postApi("api/ImportTransactionAPI.php", payload).then(function (
        response
      ) {
        Swal.close();
        var final_response = response.data;

        $scope.successData = final_response.success_data || [];
        $scope.failData = final_response.fail_data || [];

        if ($scope.successData.length > 0 || $scope.failData.length > 0) {
          var myModal = new bootstrap.Modal(
            document.getElementById("importResultsModal")
          );
          myModal.show();
          $scope.GetPaymentImport();
        } else {
          Swal.fire(
            "Error",
            final_response.message || "Import failed.",
            "error"
          );
        }
      });
    };

    // Read file as text
    reader.readAsText($scope.file);
  };

  $scope.toggleAll = function () {
    angular.forEach($scope.ImportedTransactions, function (t) {
      if (t.status.toLowerCase() !== "posted") {
        t.selected = $scope.selectAll;
      }
    });
  };

  $scope.toggleOne = function () {
    let eligible = $scope.ImportedTransactions.filter(
      (t) => t.status.toLowerCase() !== "posted"
    );

    let allChecked = eligible.length > 0 && eligible.every((t) => t.selected);

    let noneChecked = eligible.every((t) => !t.selected);

    $scope.selectAll = allChecked;

    let headerCheckbox = document.getElementById("selectAllBox");
    if (headerCheckbox) {
      headerCheckbox.indeterminate = !allChecked && !noneChecked;
    }
  };

  $scope.postTransactions = function () {
    let selected = $scope.ImportedTransactions.filter((t) => t.selected);

    if (selected.length === 0) {
      Swal.fire(
        "No Selection",
        "Please select at least one transaction.",
        "warning"
      );
      return;
    }

    Swal.fire({
      title: "Are you sure?",
      text: `You are about to post ${selected.length} transaction(s).`,
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Yes, Post",
      cancelButtonText: "Cancel",
    }).then((result) => {
      if (!result.isConfirmed) return;

      Swal.fire({
        title: "Posting...",
        text: "Please wait while we post the transactions.",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
      });

      let data = {
        client: $scope.client,
        transactions: selected,
        request_type: "PostTransactions",
      };

      API.postApi("api/ImportTransactionAPI.php", data).then(function (
        response
      ) {
        Swal.close();
        var final_response = response.data;

        if (final_response.result) {
          Swal.fire({
            title: "Posting Completed",
            html: `
                <p><b>Success:</b> ${final_response.success}</p>
                <p><b>Failed:</b> ${final_response.fail}</p>
              `,
            icon: "success",
            confirmButtonText: "OK",
          }).then(() => {
            $scope.GetPaymentImport();
          });

          $scope.selectAll = false;
        } else {
          Swal.fire(
            "Error",
            final_response.message || "Some transactions failed to post.",
            "error"
          );
        }
      });
    });
  };
});

app.directive("fileModel", [
  "$parse",
  function ($parse) {
    return {
      restrict: "A",
      link: function (scope, element, attrs) {
        var model = $parse(attrs.fileModel);
        var modelSetter = model.assign;
        element.bind("change", function () {
          scope.$apply(function () {
            modelSetter(scope, element[0].files[0]);
          });
        });
      },
    };
  },
]);
