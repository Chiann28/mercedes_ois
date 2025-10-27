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
app.controller("AdminController", function ($scope, $timeout, API) {
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

  $scope.loadDashboard = function () {
    // $scope.DoAutoPostAnnouncement();
    $scope.DoGetEventDashboard();
    // $scope.DoAutoEmaileDue();
    $scope.GetCollectionPerMonth();
  };

  $scope.GetCollectionPerMonth = function () {
    var data = {
      client: $scope.client,
      request_type: "GetCollectionPerMonth",
    };
    API.getApi("api/AdminAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      if (final_response) {
        $scope.CollectionPerMonth = final_response;
        console.log($scope.CollectionPerMonth);

        $scope.labels = Object.keys($scope.CollectionPerMonth).filter(
          (key) => key !== "Total"
        );
        $scope.values = Object.values($scope.CollectionPerMonth).slice(0, -1);

        $scope.LoadChart($scope.labels,$scope.values);
      }
    });
  };

  $scope.DoAutoPostAnnouncement = function () {
    var data = {
      client: $scope.client,
      request_type: "DoAutoPostAnnouncement",
    };

    API.getApi("api/AdminAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      if (final_response) {
        console.log("Announcement Posted");
      }
    });
  };

  $scope.DoAutoEmaileDue = function () {
    var today = new Date().toISOString().split("T")[0];
    var lastRun = localStorage.getItem("DoAutoEmaileDueLastRun");

    if (lastRun === today) {
      console.log("Auto Email already executed today. Skipping...");
      return;
    }

    Swal.fire({
      title: "Loading...",
      text: "Please Wait...",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    var data = {
      client: $scope.client,
      request_type: "DoAutoEmaileDue",
    };

    API.getApi("api/AdminAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      if (final_response) {
        swal.close();
        localStorage.setItem("DoAutoEmaileDueLastRun", today);
        console.log("Auto Email executed successfully for " + today);
      }
    });
  };

  $scope.init = function () {
    console.log("Welcome User");
  };

  $scope.DoGetEventDashboard = function () {
    var data = {
      client: $scope.client,
      request_type: "DoGetEventDashboard",
    };
    API.getApi("api/AdminAPI.php", data).then(function (response) {
      var final_response = JSON.parse(atob(response.data));
      if (final_response) {
        $scope.DashboardEvents = final_response;
        console.log($scope.DashboardEvents);
      }
    });
  };

  // chart controls

  //collection chart
  $scope.LoadChart = function (label,values) {
    const ctx = document.getElementById("myChart");
    console.log($scope.labels);
    new Chart(ctx, {
      type: "line",
      data: {
        labels: label,

        datasets: [
          {
            label: "",
            data: values,
            borderWidth: 3,
            tension: 0.4,
            borderColor: "#f55355",
            fill: false,
          },
        ],
      },
      options: {
        plugins: {
          legend: {
            display: false,
          },
        },
        scales: {
          x: {
            grid: {
              display: false,
            },
          },
          y: {
            min: 0,
            max: 50000,
            ticks: {
              stepSize: 5000,
            },
          },
        },
      },
    });
  };

  const ctx2 = document.getElementById("myChart2");
  new Chart(ctx2, {
    type: "line",
    data: {
      labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],

      datasets: [
        {
          label: "",
          data: [20, 35, 30, 45, 40, 70, 50, 35, 25, 75, 70, 85],
          borderWidth: 3,
          tension: 0.4,
          borderColor: "#6474ffff",
          fill: false,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
      scales: {
        x: {
          grid: {
            display: false,
          },
        },
        y: {
          min: 1, // lowest value
          max: 100, // highest value
          ticks: {
            stepSize: 20,
          },
        },
      },
    },
  });

  const ctx3 = document.getElementById("roundChart");
  new Chart(ctx3, {
    type: "doughnut",
    data: {
      datasets: [
        {
          data: [75, 25], // 75% filled, 25% empty
          backgroundColor: ["#28a745", "#e9ecef"], // green and light gray
          borderWidth: 0,
          borderRadius: 10,
        },
      ],
    },
    options: {
      responsive: false,
      cutout: "80%", // thickness of ring
      plugins: {
        legend: { display: false }, // hide legend
        tooltip: { enabled: false }, // disable tooltip
      },
    },
    plugins: [
      {
        // Custom text in center
        id: "textCenter",
        beforeDraw(chart) {
          const { width } = chart;
          const { height } = chart;
          const ctx = chart.ctx;
          ctx.restore();
          const fontSize = (height / 100).toFixed(2);
          ctx.font = fontSize + "em sans-serif";
          ctx.textBaseline = "middle";
          const text = "75%";
          const textX = Math.round((width - ctx.measureText(text).width) / 2);
          const textY = height / 2;
          ctx.fillText(text, textX, textY);
          ctx.save();
        },
      },
    ],
  });
});
