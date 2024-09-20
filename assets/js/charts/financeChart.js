let varFinanceChart = document
	.getElementById("elFinanceChart")
	.getContext("2d");

var financeChart = new Chart(varFinanceChart, {
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
