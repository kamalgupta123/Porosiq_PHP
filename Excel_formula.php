<?php 

$a10 = "11/1/2020";
$b10 = "11/30/20";
$sum = strtotime($a10) + strtotime($b10);
if ($sum == 0) {
	$ans = 0;
}
else {
	$a10 = "11/1/2020";
	$b10 = "11/30/20";
	$minus = strtotime($b10) - strtotime($a10);
    $minus = strtotime($minus);
  	$day = date("d", strtotime($b10));
    if ($day <=30) {
    	$res = $minus + 1;
    }
    else {
    	$res = $minus + 0;
    }
    
    $eomonth = date("Y/m/t", strtotime($b10));
    
    if ($b10 == $eomonth && date("d", strtotime($b10)) < 30) {
    	
        $res = $res + (30 - date("d", strtotime($b10)));
    
    }
    else {
    	$res = $res + 0;
    }
    echo $res;
}

// var daily_rate = parseFloat($(this).parent().parent().find("td:eq(13)").text());
            // // console.log(daily_rate);
            // var worked_days_except_holidays = parseFloat($(this).parent().parent().find("td:eq(4)").text());
            // // console.log(worked_days_except_holidays);
            // var holidays = parseFloat($(this).val());
            // // console.log(holidays);
            // worked_days_except_holidays = 30 - holidays;

            // $(this).parent().parent().find("td:eq(4)").text(worked_days_except_holidays);
            
            // var ot_hours = parseFloat($(this).parent().parent().find("td:eq(6) > input").val());
            // // console.log(ot_hours);

            // var gross_salary = (daily_rate*worked_days_except_holidays)+((holidays*daily_rate)*2)+(((daily_rate/8)*1.5)*(ot_hours));

            // // console.log(gross_salary);

            // $(this).parent().parent().find("td:eq(11)").text(gross_salary.toFixed(2));

            // var ordinary_salary = gross_salary;

            // $(this).parent().parent().find("td:eq(14)").text(ordinary_salary.toFixed(2));

            // var cuota_patronal = (26.50/100)*ordinary_salary;

            // $(this).parent().parent().find("td:eq(15)").text(cuota_patronal.toFixed(2));

            // var labor_risk = 0.01*ordinary_salary;

            // $(this).parent().parent().find("td:eq(18)").text(labor_risk.toFixed(2));

            // var aguinaldo = 0.0833*ordinary_salary;

            // $(this).parent().parent().find("td:eq(16)").text(aguinaldo.toFixed(2));

            // var vacations = 0.0417*ordinary_salary;

            // $(this).parent().parent().find("td:eq(17)").text(vacations.toFixed(2));

            // var social_cost = cuota_patronal+aguinaldo+vacations+labor_risk;

            // $(this).parent().parent().find("td:eq(19)").text(social_cost.toFixed(2));

            // var monthly_cost = social_cost+ordinary_salary;

            // $(this).parent().parent().find("td:eq(20)").text(monthly_cost.toFixed(2));

            // var vendor_fee = 0.3*monthly_cost;

            // $(this).parent().parent().find("td:eq(21)").text(vendor_fee.toFixed(2));

            // var administ_fee = 0.00*monthly_cost;

            // $(this).parent().parent().find("td:eq(22)").text(administ_fee.toFixed(2));

            // var vat = 0.00*monthly_cost;

            // $(this).parent().parent().find("td:eq(23)").text(vat.toFixed(2));

            // var cuota_obrera = 0.105*ordinary_salary;

            // $(this).parent().parent().find("td:eq(24)").text(cuota_obrera.toFixed(2));

            // var monthly_invoice = ordinary_salary + social_cost + vendor_fee;

            // $(this).parent().parent().find("td:eq(12)").text(monthly_invoice.toFixed(2));




            // var daily_rate = parseFloat($(this).parent().parent().find("td:eq(13)").text());
            // // console.log(daily_rate);
            // var worked_days_except_holidays = parseFloat($(this).parent().parent().find("td:eq(4)").text());
            // // console.log(worked_days_except_holidays);
            // var holidays = parseFloat($(this).parent().parent().find("td:eq(5) > input").val());
            // // console.log(holidays);
            // var ot_hours = parseFloat($(this).val());
            // // console.log(ot_hours);

            // var gross_salary = (daily_rate*worked_days_except_holidays)+((holidays*daily_rate)*2)+(((daily_rate/8)*1.5)*(ot_hours));

            // // console.log(gross_salary);

            // $(this).parent().parent().find("td:eq(11)").text(gross_salary.toFixed(2));

            // var ordinary_salary = gross_salary;

            // $(this).parent().parent().find("td:eq(14)").text(ordinary_salary.toFixed(2));

            // var cuota_patronal = (26.50/100)*ordinary_salary;

            // $(this).parent().parent().find("td:eq(15)").text(cuota_patronal.toFixed(2));

            // var labor_risk = 0.01*ordinary_salary;

            // $(this).parent().parent().find("td:eq(18)").text(labor_risk.toFixed(2));

            // var aguinaldo = 0.0833*ordinary_salary;

            // $(this).parent().parent().find("td:eq(16)").text(aguinaldo.toFixed(2));

            // var vacations = 0.0417*ordinary_salary;

            // $(this).parent().parent().find("td:eq(17)").text(vacations.toFixed(2));

            // var social_cost = cuota_patronal+aguinaldo+vacations+labor_risk;

            // $(this).parent().parent().find("td:eq(19)").text(social_cost.toFixed(2));

            // var monthly_cost = social_cost+ordinary_salary;

            // $(this).parent().parent().find("td:eq(20)").text(monthly_cost.toFixed(2));

            // var vendor_fee = 0.3*monthly_cost;

            // $(this).parent().parent().find("td:eq(21)").text(vendor_fee.toFixed(2));

            // var administ_fee = 0.00*monthly_cost;

            // $(this).parent().parent().find("td:eq(22)").text(administ_fee.toFixed(2));

            // var vat = 0.00*monthly_cost;

            // $(this).parent().parent().find("td:eq(23)").text(vat.toFixed(2));

            // var cuota_obrera = 0.105*ordinary_salary;

            // $(this).parent().parent().find("td:eq(24)").text(cuota_obrera.toFixed(2));

            // var monthly_invoice = ordinary_salary + social_cost + vendor_fee;

            // $(this).parent().parent().find("td:eq(12)").text(monthly_invoice.toFixed(2));


            // console.log('holidays');
            // var daily_rate = parseFloat($(this).parent().parent().find("td:eq(13)").text());
            // // console.log(daily_rate);
            // var worked_days_except_holidays = parseFloat($(this).parent().parent().find("td:eq(4)").text());
            // // console.log(worked_days_except_holidays);
            // var holidays = parseFloat($(this).parent().parent().find("td:eq(5) > input").val());
            // // console.log(holidays);
            // var ot_hours = parseFloat($(this).val());
            // // console.log(ot_hours);

            // var gross_salary = (daily_rate*worked_days_except_holidays)+((holidays*daily_rate)*2)+(((daily_rate/8)*1.5)*(ot_hours));

            // // console.log(gross_salary);

            // $(this).parent().parent().find("td:eq(11)").text(gross_salary.toFixed(2));

            // var ordinary_salary = gross_salary;

            // $(this).parent().parent().find("td:eq(14)").text(ordinary_salary.toFixed(2));

            // var cuota_patronal = (26.50/100)*ordinary_salary;

            // $(this).parent().parent().find("td:eq(15)").text(cuota_patronal.toFixed(2));

            // var labor_risk = 0.01*ordinary_salary;

            // $(this).parent().parent().find("td:eq(18)").text(labor_risk.toFixed(2));

            // var aguinaldo = 0.0833*ordinary_salary;

            // $(this).parent().parent().find("td:eq(16)").text(aguinaldo.toFixed(2));

            // var vacations = 0.0417*ordinary_salary;

            // $(this).parent().parent().find("td:eq(17)").text(vacations.toFixed(2));

            // var social_cost = cuota_patronal+aguinaldo+vacations+labor_risk;

            // $(this).parent().parent().find("td:eq(19)").text(social_cost.toFixed(2));

            // var monthly_cost = social_cost+ordinary_salary;

            // $(this).parent().parent().find("td:eq(20)").text(monthly_cost.toFixed(2));

            // var vendor_fee = 0.3*monthly_cost;

            // $(this).parent().parent().find("td:eq(21)").text(vendor_fee.toFixed(2));

            // var administ_fee = 0.00*monthly_cost;

            // $(this).parent().parent().find("td:eq(22)").text(administ_fee.toFixed(2));

            // var vat = 0.00*monthly_cost;

            // $(this).parent().parent().find("td:eq(23)").text(vat.toFixed(2));

            // var cuota_obrera = 0.105*ordinary_salary;

            // $(this).parent().parent().find("td:eq(24)").text(cuota_obrera.toFixed(2));

            // var monthly_invoice = ordinary_salary + social_cost + vendor_fee;

            // $(this).parent().parent().find("td:eq(12)").text(monthly_invoice.toFixed(2));

?>