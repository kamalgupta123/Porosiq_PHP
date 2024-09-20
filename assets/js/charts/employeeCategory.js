let varEmployeeChart = document
	.getElementById("elEmployeeChart")
	.getContext("2d");

Chart.defaults.global.defaultFontColor = "white";
Chart.defaults.global.defaultFontSize = 10;

var employeeChart = new Chart(varEmployeeChart, {
	type: "pie",
	data: {
		labels: [
			"IT",
			"Admin Clerical",
			"Professional",
			"Light Industrial",
			"Engineering",
			"Scientific",
			"Healthcare",
		],
		datasets: [
			{
				label: "Employee category",
				data: [30, 50, 100, 110, 30, 40, 70],
				backgroundColor: [
					"rgba(255, 99, 132, 1)",
					"rgba(54, 162, 235, 1)",
					"rgba(255, 206, 86, 1)",
					"rgba(75, 192, 192, 1)",
					"rgba(153, 102, 255, 1)",
					"rgba(255, 159, 64, 1)",
					"rgb(187,187,187)",
					"rgba(255, 99, 132, 1)",
					"rgba(255, 206, 86, 1)",
					"rgba(75, 192, 192, 1)",
					"rgba(153, 102, 255, 1)",
				],
			},
		],
	},
	options: {
		legend: {
			display: true,
			position: "right",
			align: "center",
			labels: {
				boxWidth: 10,
			},
		},
		title: {
			display: true,
			text: "Employee Category",
		},
	},
});
