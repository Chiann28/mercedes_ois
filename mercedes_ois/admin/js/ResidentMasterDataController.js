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
  $scope.MDXSwalClose = function (delay) {
    setTimeout(function () {
      Swal.close();
    }, delay);
  };

  //FLAGS
  $scope.isEditing = false;


  $scope.DoCreateAccount = function () {
    console.log($scope.newacc_role);

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
      // console.log(final_response);
      let modal = bootstrap.Modal.getInstance(
        document.getElementById("newAccountModal")
      );

      Swal.close();

      if (final_response.result) {
        if ($scope.newacc_role.toLowerCase() === "user") {
          modal.hide();
          $scope.GetAccountDetails(final_response.accountnumber);
        } else {
          modal.hide();
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: final_response.message || "Account created successfully.",
          });
        }
      } else {
        modal = new bootstrap.Modal(document.getElementById("newAccountModal"));
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
        $scope.MDXSwalClose(1000);

        setTimeout(function () {
          modal = new bootstrap.Modal(
            document.getElementById("accountSearchModal")
          );
          modal.show();
        }, 1300);
      } else if ($scope.accountlist.length === 1) {
        $scope.GetAccountDetails(final_response[0].accountnumber);
        $scope.MDXSwalClose(1000);
      } else {
        $scope.MDXSwalClose(1000);
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
        console.log(final_response);
      }

      //set time out, yung swal kasi ambilis mawala parang engot hahahah
      $scope.MDXSwalClose(1000);
    });
  };

  $scope.DoUpdateAccount = function () {
    var data = {
      client: $scope.client,
      accountnumber: $scope.mdx.accountnumber,
      firstname: $scope.mdx.firstname,
      middlename: $scope.mdx.middlename,
      lastname: $scope.mdx.lastname,
      status: $scope.mdx.status,
      contact_number: $scope.mdx.contact_number,
      email: $scope.mdx.email,
      property_code: $scope.mdx.property_code,
      request_type: "DoUpdateAccount",
    };
    API.postApi("api/ResidentMasterDataAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.response = final_response;
      console.log($scope.response);
      Swal.close();

      if ($scope.response.result) {
        let accountnumber = $scope.response.accountnumber;
        Swal.fire({
          title: "Success!",
          text: $scope.response.message,
          icon: "success",
          confirmButtonText: "Done",
        }).then((res) => {
          if (res.isConfirmed) {
            $scope.GetAccountDetails(accountnumber);
            $scope.isEditing = false;
          }
        });
      } else {
        Swal.fire({
          title: "Error",
          text: $scope.response.message,
          icon: "error",
          confirmButtonText: "OK",
        });
        // location.reload();
        $scope.isEditing = false;
      }
    });
  };

  $scope.InitializeUpdating = function (){
     $scope.isEditing = !$scope.isEditing;
  };

  $scope.openPropModal = function () {
    Swal.fire({
      title: "Loading...",
      text: "Fetching properties list, please wait.",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      property_code: '',
      request_type: "GetPropertiesList",
    };

    API.getApi("api/PropertiesAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.proplist = final_response;
      console.log($scope.proplist);

      let modal;

      if ($scope.proplist.length > 1) {
        $scope.MDXSwalClose(1000);

        setTimeout(function () {
          modal = new bootstrap.Modal(
            document.getElementById("propModal")
          );
          modal.show();
        }, 1300);
      } else if ($scope.proplist.length === 1) {
        $scope.GetPropertyDetails(final_response[0].property_code);
        $scope.MDXSwalClose(1000);
      } else {
        $scope.MDXSwalClose(1000);
        Swal.fire({
          icon: "warning",
          title: "No Results",
          text: "No property found matching your search.",
          confirmButtonText: "OK",
          confirmButtonColor: "#6c757d",
        });
      }
    });
  };

  $scope.GetPropertyDetails = function (property_code) {
    // console.log(property_code);
    Swal.fire({
      title: "Loading...",
      text: "Fetching property list, please wait.",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      property_code: property_code,
      request_type: "GetPropertyDetails",
    };

    API.getApi("api/PropertiesAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.property = final_response;

      $scope.mdx.property_code = $scope.property.property_code;
      $scope.mdx.property_name = $scope.property.property_name;

      // if (final_response.date_registered) {
      //   final_response.date_registered = new Date(
      //     final_response.date_registered
      //   );
      // }

      if (final_response) {
        console.log($scope.property);
      }

      //set time out, yung swal kasi ambilis mawala parang engot hahahah
      $scope.MDXSwalClose(1000);
    });
  };


});
