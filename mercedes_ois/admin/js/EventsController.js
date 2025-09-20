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
    $scope.DoSetPastEventStatus();
  };

  //FLAGS
  $scope.isEditing = false;

  $scope.InitializeUpdating = function () {
    $scope.isEditing = !$scope.isEditing;
  };

  $scope.clean_date = function(d) {
    let date = new Date(d);
    let year = date.getFullYear();
    let month = String(date.getMonth() + 1).padStart(2, "0");
    let day = String(date.getDate()).padStart(2, "0");
    let hours = String(date.getHours()).padStart(2, "0");
    let minutes = String(date.getMinutes()).padStart(2, "0");
    let seconds = String(date.getSeconds()).padStart(2, "0");

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
  }

  $scope.DoSetPastEventStatus = function () {
    data = {
      client: $scope.client,
      request_type: "DoSetPastEventStatus"
    }
    API.getApi("api/EventsAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
    });
  }

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
      //request_id: $scope.request_id,
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
    // console.log($scope.selectedEvent);
  };

  $scope.DoDeleteEvent = function (event_no) {
    Swal.fire({
      title: "Are you sure?",
      text: "You are about to delete Event No: " + event_no,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        var data = {
          client: $scope.client,
          event_no: event_no,
          request_type: "DoDeleteEvent",
        };

        API.getApi("api/EventsAPI.php", data).then(function (response) {
          var final_response = JSON.parse(atob(response.data));
          console.log(final_response);

          // Show success/failure alert
          if (final_response.result) {
            Swal.fire("Deleted!", final_response.message, "success").then(
              () => {
                var modalEl = document.getElementById("eventDetailsModal");
                var modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
                $scope.initRequest();
              }
            );
          } else {
            Swal.fire(
              "Error!",
              final_response.message || "Something went wrong.",
              "error"
            );
          }
        });
      }
    });
  };

  $scope.DoUpdateEvent = function (event) {
    let dupe = angular.copy(event);
    dupe.start_date = $scope.clean_date(event.start_date);
    dupe.end_date = $scope.clean_date(event.end_date);
    // console.log(dupe);

    var data = {
      params: dupe,
      request_type: "DoUpdateEvent",
    }
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

  $scope.DoCancelEvent = function (event_no, event_status){
    var data = {
      client: $scope.client,
      event_no: event_no,
      event_status: event_status,
      request_type: "DoCancelEvent",
    }
    console.log(data)
    API.getApi("api/EventsAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.GetEvents();
    });
  }
});
