let varClientChart = document.getElementById("clientChart").getContext("2d");

var vendorChart = new Chart(varClientChart, {
	type: "horizontalBar",
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
				backgroundColor: "#1292f7",
			},
		],
	},
	options: {
		legend: {
			display: false,
		},
		title: {
			display: true,
			text: "Vendor Performance",
			fontSize: 12,
			fontColor: "black",
		},
		scales: {
			yAxes: [
				{
					scaleLabel: {
						display: true,
						fontColor: "black",
						labelString: "Client",
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
						labelString: "Payments",
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
