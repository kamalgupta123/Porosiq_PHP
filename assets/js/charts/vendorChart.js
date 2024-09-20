let varVenderChart = document.getElementById("VendorChart").getContext("2d");

var vendorChart = new Chart(varVenderChart, {
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
