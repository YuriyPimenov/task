<?php

//Дата оформления вклада	
$datepicker = $_POST['datepicker'];
//Сумма вклада	
$amount = $_POST['amount'];
//Сумма пополнения вклада 
$amount2 = $_POST['amount2'];
// Срок вклада	
$select = $_POST['select'];
// Пополнение вклада
$radio = $_POST['radio'];

if($datepicker == '' || $amount == '' || $amount2 == '' || $select == '' || $radio == ''){
	echo json_encode(['status'=>'bad','str'=>'Заполните все поля!']);
}else{
	$daysy = date('L')?366:365;
	$percent = 10;
	$daysn = date("t");
	$summadd = ((int)$amount)/10/12;
	
	$date1=explode('.',$datepicker); 
	$date1 = 4-(int)$date1[0];

	
	$summn_1 = $summadd*$date1+$amount;

$summn = $summn_1 + ($summn_1 + ($radio=='1'?$summadd:0))*$daysn*($percent / $daysy);



	echo json_encode(['status'=>'good','str'=>$summn]);
}

?>
