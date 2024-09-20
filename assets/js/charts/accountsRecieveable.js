let varAccountsChart = document
	.getElementById("accountsChart")
	.getContext("2d");

var accountsChart = new Chart(varAccountsChart, {
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
