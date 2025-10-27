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
app.controller("AdminReportsController", function ($scope, API) {
  $scope.client = "mercedes";
  $scope.VerifySession = function () {
    console.log("Welcome Admin");
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

  $scope.GetReport = function (type) {
    switch (type) {
      case "resident_masterlist":
        var data = {
          client: $scope.client,
          datefrom: $scope.datefrom,
          dateto: $scope.dateto,
          status: $scope.status,
          request_type: "resident_masterlist",
        };
        break;
      case "announcement_history":
        var data = {
          client: $scope.client,
          datefrom: $scope.datefrom,
          dateto: $scope.dateto,
          status: $scope.status,
          request_type: "announcement_history",
        };
        break;
      case "payment_collection":
        var data = {
          client: $scope.client,
          datefrom: $scope.datefrom,
          dateto: $scope.dateto,
          status: $scope.status,
          request_type: "payment_collection",
        };
        break;
      case "events":
        var data = {
          client: $scope.client,
          datefrom: $scope.datefrom,
          dateto: $scope.dateto,
          event_type: $scope.event_type,
          request_type: "events",
        };
        break;
      case "incident":
        var data = {
          client: $scope.client,
          datefrom: $scope.datefrom,
          dateto: $scope.dateto,
          type: $scope.type,
          request_type: "incident",
        };
        break;
      default:
        break;
    }

    Swal.fire({
      title: "Loading...",
      text: "Please Wait...",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    API.getApi("api/AdminReportsAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      if (final_response) {
        $scope.data = final_response;
        console.log("DATA", final_response);
        swal.close();
      }
    });
  };

  $scope.ExportExcel = function (type) {
    // Check if data exists
    if (!$scope.data || $scope.data.length === 0) {
      alert("No data to export.");
      return;
    }

    let exportData = [];
    let sheetName = "";
    let fileName = "";

    switch (type) {
      case "residents":
        exportData = $scope.data.map((r) => ({
          "Account #": r.accountnumber,
          Name: `${r.firstname || ""} ${r.middlename || ""} ${
            r.lastname || ""
          }`.trim(),
          Email: r.email,
          Contact: r.contact_number,
          "Lot #": r.lot_number,
          "House #": r.house_no,
          Status: r.status,
          "Date Registered": r.registration_date,
        }));
        sheetName = "Resident Masterlist";
        fileName = "Resident_Masterlist.xlsx";
        break;

      case "announcement":
        exportData = $scope.data.map((r) => ({
          Title: r.title,
          Message: r.message,
          By: r.modifiedby,
          Status: r.status,
        }));
        sheetName = "Announcements";
        fileName = "Announcements.xlsx";
        break;

      case "collection":
        exportData = $scope.data.map((r) => ({
          Date: r.transaction_date,
          "Account #": r.accountnumber,
          Name: r.fullname,
          Reference: r.transaction_id,
          Collector: r.modifiedby,
          Status: r.payment_status,
        }));
        sheetName = "Collection";
        fileName = "Collection.xlsx";
        break;

      case "events":
        exportData = $scope.data.map((r) => ({
          "Start Date": r.start_date,
          "End Date": r.end_date,
          Name: r.event_name,
          Type: r.event_type,
          Description: r.event_description,
          "Initiated By": r.initiated_by,
          Status: r.event_status,
        }));
        sheetName = "Events";
        fileName = "Events.xlsx";
        break;

      case "incidents":
        exportData = $scope.data.map((r) => ({
          Type: r.type,
          Category: r.category,
          Title: r.title,
          Description: r.description,
          Status: r.status,
          Location: r.location,
          Posted: r.sysentrydate,
        }));
        sheetName = "Incidents";
        fileName = "incidents.xlsx";
        break;

      default:
        alert("Invalid export type.");
        return;
    }

    // Create workbook and worksheet
    const ws = XLSX.utils.json_to_sheet(exportData);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, sheetName);

    // Write the file
    XLSX.writeFile(wb, fileName);
  };
});
