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
app.controller("AnnouncementController", function ($scope, API) {
  $scope.client = "mercedes";

  $scope.sortKey = "title"; // default sorting key
  $scope.sortReverse = false; // ascending by default
  $scope.groupBy = "status"; // default grouping

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

  $scope.GetAnnouncements = function () {
    $scope.GetAnnouncementCount();
    Swal.fire({
      title: "Loading...",
      text: "Fetching announcements, please wait.",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      request_type: "GetAnnouncements",
    };

    API.getApi("api/AnnouncementAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.listAll = final_response.ALL;
      $scope.listNew = final_response.New;
      $scope.listInprogress = final_response.In_Progress;
      $scope.listResolved = final_response.Resolved;
      $scope.listClosed = final_response.Closed;
      Swal.close();
    });
  };

  $scope.GetAnnouncementCount = function () {
    var data = {
      client: $scope.client,
      request_type: "GetAnnouncementCount",
    };

    API.getApi("api/AnnouncementAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.listCount = final_response;
      $scope.activeCount = final_response.ACTIVE;
      $scope.closedCount = final_response.CLOSED;
      $scope.draftCount = final_response.DRAFT;
      $scope.scheduledCount = final_response.SCHEDULED;
    });
  };

  $scope.setSort = function (key, reverse) {
    $scope.sortKey = key;
    $scope.sortReverse = reverse;
  };

  $scope.setGroup = function (key) {
    $scope.groupBy = key;
  };

  $scope.newAnnouncement = {
    attachments: [],
  };

  $scope.setFiles = function (element) {
    $scope.$apply(function () {
      $scope.newAnnouncement.attachments = element.files;
    });
  };

  $scope.DoAddAnnouncement = function () {
    Swal.fire({
      title: "Adding announcement",
      text: "Please Wait . . .",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      title: $scope.newAnnouncement.title,
      message: $scope.newAnnouncement.message,
      scheduled_date: $scope.newAnnouncement.scheduled_date,
      request_type: "DoAddAnnouncement",
    };

    API.postApi("api/AnnouncementAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.result = final_response;
      Swal.close();
      if ($scope.result.result) {
        if ($scope.newAnnouncement.attachments.length > 0) {
          $scope.DoUploadAttachment(final_response.announcement_no);
        }

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

  // Save announcement details
  $scope.DoAddAnnouncement = function () {
    Swal.fire({
      title: "Adding announcement",
      text: "Please Wait . . .",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      title: $scope.newAnnouncement.title,
      message: $scope.newAnnouncement.message,
      scheduled_date: $scope.newAnnouncement.scheduled_date,
      request_type: "DoAddAnnouncement",
    };

    API.postApi("api/AnnouncementAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.result = final_response;
      Swal.close();

      if ($scope.result.result) {
        // Upload attachments after saving
        if ($scope.newAnnouncement.attachments.length > 0) {
          $scope.DoUploadAttachment(final_response.announcement_no);
        }

        Swal.fire({
          title: "Success!",
          text: $scope.result.message,
          icon: "success",
          confirmButtonText: "Done",
        }).then((res) => {
          if (res.isConfirmed) {
            $scope.GetAnnouncements();
            $scope.newAnnouncement = { attachments: [] };
            angular.element("#newAnnouncementModal").modal("hide");
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

  // Upload multiple attachments
  $scope.DoUploadAttachment = function (announcement_no) {
    let formData = new FormData();
    formData.append("client", $scope.client);
    formData.append("announcement_no", announcement_no);
    formData.append("request_type", "UploadAttachment");
    angular.forEach($scope.newAnnouncement.attachments, function (file) {
      formData.append("files[]", file);
    });

    fetch("api/AnnouncementAPI.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        console.log("Upload response:", data);
      })
      .catch((err) => {
        console.error("Upload failed:", err);
      });
  };

  $scope.selectedAnnouncement = {};

  $scope.openModal = function (announcement) {
    $scope.announcementBasePath =
      "http://localhost/mercedes_ois/mercedes_ois/files/announcements/";
    $scope.GetAnnouncementAttachment(announcement.announcement_no);

    $scope.selectedAnnouncement = angular.copy(announcement);

    const modal = new bootstrap.Modal(
      document.getElementById("announcementModal")
    );
    modal.show();
  };

  $scope.GetAnnouncementAttachment = function (announcement_no) {
    Swal.fire({
      title: "Loading...",
      text: "Fetching announcements, please wait.",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      announcement_no: announcement_no,
      request_type: "GetAnnouncementAttachment",
    };

    API.getApi("api/AnnouncementAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      $scope.announcement_attachment = final_response;
      console.log(final_response);
      Swal.close();
    });
  };
});
