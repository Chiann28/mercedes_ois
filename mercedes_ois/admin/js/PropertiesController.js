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
app.controller("PropertiesController", function ($scope, API) {
  $scope.client = "mercedes";
  // $scope.newapp = $scope.newapp || {};

  $scope.VerifySession = function () {
    console.log("Properties Loaded");
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
   $scope.InitializeUpdating = function (){
     $scope.isEditing = !$scope.isEditing;
  }

  $scope.DoCreateProperty = function () {
    //console.log($scope.request_id);
    var data = {
      client: $scope.client,
      params: $scope.new_prop,
      request_type: "CreateProperty",
    }
    API.postApi("api/PropertiesAPI.php", data).then(function (response) {
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
      property_code: $scope.property_code,
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
            document.getElementById("accountSearchModal")
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
