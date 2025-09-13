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
app.controller("EventsController", function ($scope, API) {
  $scope.client = "mercedes";
  $scope.events = $scope.events || {};
  $scope.postevent = $scope.postevent || {};
  $scope.selectedEvent = {};
  $scope.pastEvents = $scope.pastEvents || {};

  $scope.VerifySession = function () {
    console.log("Events Loaded");
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

  $scope.initRequest = function () {
    $scope.GetEvents();
    $scope.GetPastEvents();
    $scope.DoCountEvents();
    $scope.DoCountPastEvents();
  };

  $scope.DoCountEvents = function () {
    var data = {
      client: $scope.client,
      request_type: "DoCountEvents",
    };
    API.getApi("api/EventsAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));

      $scope.EventCount = final_response[0]["count(event_no)"];
    });
  };

  $scope.DoCountPastEvents = function () {
    var data = {
      client: $scope.client,
      request_type: "DoCountPastEvents",
    };
    API.getApi("api/EventsAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));

      $scope.PastEventCount = final_response[0]["count(event_no)"];
    });
  };

  $scope.MDXSwalClose = function (delay) {
    setTimeout(function () {
      Swal.close();
    }, delay);
  };

  $scope.GetEvents = function () {
    var data = {
      client: $scope.client,
      request_type: "GetEvents",
    };
    API.getApi("api/EventsAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      //console.log(final_response);

      $scope.EventsList = final_response;
    });
  };

  $scope.GetPastEvents = function () {
    var data = {
      client: $scope.client,
      request_type: "GetPastEvents",
    };
    API.getApi("api/EventsAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      console.log(final_response);
      $scope.pastEvents = final_response;
    });
  };

  $scope.DoPostEvent = function () {
    //console.log($scope.request_id);
    var data = {
      client: $scope.client,
      params: $scope.postevent,
      request_id: $scope.request_id,
      request_type: "DoPostEvent",
    };
    API.postApi("api/EventsAPI.php", data).then(function (response) {
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
  };

  $scope.setSelectedEvent = function (event) {
    $scope.selectedEvent = angular.copy(event);
    if ($scope.selectedEvent.start_date) {
      $scope.selectedEvent.start_date = new Date(
        $scope.selectedEvent.start_date
      );
    }
    if ($scope.selectedEvent.end_date) {
      $scope.selectedEvent.end_date = new Date($scope.selectedEvent.end_date);
    }
    console.log($scope.selectedEvent);
  };
});
