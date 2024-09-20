let varFinanceChart = document
	.getElementById("elFinanceChart")
	.getContext("2d");
let varEmployeeChart = document
	.getElementById("elEmployeeChart")
	.getContext("2d");

let varVenderChart = document.getElementById("VendorChart").getContext("2d");
let varAccountsChart = document
	.getElementById("accountsChart")
	.getContext("2d");

Chart.defaults.global.defaultFontColor = "white";
Chart.defaults.global.defaultFontSize = 10;

var barChart = new Chart(varFinanceChart, {
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
				data: [20, 40, 70, 80, 120, 140, 50, 65, 30, 55, 100, 70],
				fill: false,
				backgroundColor: "green",
				borderColor: "orange",
				pointBackgroundColor: "orange",
				pointBorderColor: "orange",
				pointHoverBackgroundColor: "orange",
				pointHoverBorderColor: "orange",
			},
		],
	},
	options: {
		tooltips: {
			callbacks: {
				label: function (tooltipItem) {
					return Number(tooltipItem.yLabel) + "K $";
				},
			},
		},
		legend: {
			display: false,
		},
		title: {
			display: true,
			text: "Finance Chart",
			fontSize: 12,
			fontColor: "black",
		},
		scales: {
			yAxes: [
				{
					scaleLabel: {
						display: true,
						fontColor: "black",
						labelString: "Amount (in $)",
					},
					ticks: {
						beginAtZero: true,
						fontColor: "black",
						stepSize: 50,
						maxTicksLimit: 5,
						callback: function (value, index, values) {
							return value + "K";
						},
					},
					gridLines: {
						color: "rgba(0, 0, 0, 0)",
					},
				},
			],
			xAxes: [
				{
					scaleLabel: {
						display: true,
						labelString: "Months",
						fontColor: "black",
					},
					ticks: {
						fontColor: "black",
					},
					gridLines: {
						color: "rgba(0, 0, 0, 0)",
					},
				},
			],
		},
	},
});
var barChart = new Chart(varEmployeeChart, {
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

var BarChart = new Chart(varVenderChart, {
	type: "bar",
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
				data: [4, 30, 20, 35, 23, 12, 22, 43, 34, 33, 29, 30],
				backgroundColor: "blue",
			},
		],
	},
	options: {
		legend: {
			display: false,
		},
		title: {
			display: true,
			text: "Vendor Chart",
			fontSize: 12,
			fontColor: "black",
		},
		scales: {
			yAxes: [
				{
					scaleLabel: {
						display: false,
						fontColor: "black",
						labelString: "Vendor",
					},
					ticks: {
						beginAtZero: true,
						fontColor: "black",
						stepSize: 10,
						maxTicksLimit: 5,
					},
					gridLines: {
						color: "rgba(0, 0, 0, 0)",
					},
				},
			],
			xAxes: [
				{
					scaleLabel: {
						display: true,
						labelString: "Months",
						fontColor: "black",
					},
					ticks: {
						fontColor: "black",
					},
					gridLines: {
						color: "rgba(0, 0, 0, 0)",
					},
				},
			],
		},
	},
});

var doughnetChart = new Chart(varAccountsChart, {
	type: "doughnut",
	data: {
		labels: [
			"1-30 days",
			"31-60 days",
			"61-90 days",
			"91-120 days",
			"120+ days",
		],
		fontColor: "black",
		datasets: [
			{
				label: "Accounts Receivable",
				data: [120, 50, 30, 110, 30],
				backgroundColor: [
					"#92ccfc",
					"#e08cec",
					"#f5a5c8",
					"#ffcc5c",
					"#9bc89f",
				],
			},
		],
	},
	options: {
		responsive: true,
		legend: {
			display: true,
			position: "right",
			align: "center",
			labels: {
				fontColor: "black",
				boxWidth: 10,
			},
		},
		title: {
			display: true,
			text: "Accounts Receivable",
			fontColor: "black",
		},
	},
});
