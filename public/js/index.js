let SidebarMenuBtn = document.getElementById("menu-btn");
let Sidebar = document.getElementById("sidebar-show");

SidebarMenuBtn.addEventListener("click", function () {
  Sidebar.classList.toggle("appear-sidebar");

  let pagebox = document.getElementsByTagName('main')[0];

  if (Sidebar.classList.contains('appear-sidebar')) {
    pagebox.classList.add('forward');
  } else {
    Sidebar.style.animation = 'slideOut 0.3s forwards';

    Sidebar.addEventListener('animationend', function () {
      Sidebar.classList.remove('appear-sidebar');
    }, { once: true });

    pagebox.classList.remove('forward');
  }
});
document.addEventListener("DOMContentLoaded", function () {
  // oprations
  const monthlyActivities = window.monthlyActivities;
  if (monthlyActivities) {
    const oprationCanvas = document.getElementsByClassName("opration")[0];
    new Chart(oprationCanvas, {
      type: "bar",
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [
          {
            data: monthlyActivities,
            label: "Activities",
            backgroundColor: "#C7DEE5",
            hoverBackgroundColor: '#E94D65',
            borderWidth: 1,
            borderRadius: 5,
          },
        ],
      },
      options: {
        scales: {
          x: {
            display: true,
            grid: {
              display: true,
            },

          },
          y: {
            grid: {
              display: false,
            },
          },
        },
        plugins: {
          legend: {
            display: false,
          },
        },
      },
    });
  }

  // pie chart
  const pieChartCanvas = document.getElementById('myPieChart').getContext('2d');
  const totalActivities = clients.reduce((sum, client) => sum + client.activitiesCount, 0);
  const data = clients.map(client => client.activitiesCount);

  function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
  }

  const backgroundColors = Array(clients.length).fill().map(() => getRandomColor());

  const pieChartData = {
    labels: clients.map(client => client.name),
    datasets: [{
      data: data,
      backgroundColor: backgroundColors,
      hoverOffset: 20
    }]
  };

  const myPieChart = new Chart(pieChartCanvas, {
    type: 'pie',
    data: pieChartData,
    options: {
      plugins: {
        legend: {
          display: false
        }
      },
      tooltips: {
        callbacks: {
          label: function (tooltipItem, data) {
            const label = data.labels[tooltipItem.index];
            const count = data.datasets[0].data[tooltipItem.index];
            return `${label}: ${count} activities`;
          }
        }
      }
    }
  });

  //pie chart end here
});
// Attendance
google.charts.load('current', { 'packages': ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Year', 'Sales'],
    ["Jan", 141],
    ["Feb", 120],
    ["Mar", 140],
    ["Apr", 97],
    ["May", 100],
    ["Jun", 140],
    ["Jul", 109],
    ["Aug", 154],
    ["Sep", 110],
    ["Oct", 154],
    ["Nov", 134],
    ["Dec", 124]

  ]);

  var options = {
    legend: { position: 'none' },
    series: {
      0: { color: '#1C617B' },
      1: { color: '#E94D65' },
      2: { color: 'white' },

    },

    lineWidth: 2
  };
  var chart = new google.visualization.AreaChart(document.getElementById('attendance-over'));
  chart.draw(data, options);
}
let button = document.getElementById("notification-toggle-button");
let notificationBox = document.getElementById("show-page");
let profileNotification = document.querySelector(".profile-notification");

button.addEventListener("click", function (event) {
  event.stopPropagation();
  notificationBox.classList.toggle("show");
});

document.addEventListener("click", function (event) {
  if (!profileNotification.contains(event.target) && !button.contains(event.target)) {
    notificationBox.classList.remove("show");
  }
});