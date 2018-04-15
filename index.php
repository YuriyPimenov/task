<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>WORLD BANK</title>
<link href="jquery-ui-1.12.1.custom/jquery-ui.css" rel="stylesheet">
 

	
	<link rel="stylesheet" href="style.css">
	
</head>
<body>
	<!-- Логотип -->
	<div class="header">
		<div class="logo">
			<img src="logo.png" alt="logo" width="210" height="70">
		</div>
		<div class="phones">
			8-800-100-5005 <br>
			+7(3452)522-000
		</div>
	</div>

	<!-- Меню -->
	<div class="menu">
		<div class="elem_first"><a href="#">Кредитные карты</a></div>
		<div class="elem elem_activ"><a href="#">Вклады</a></div>
		<div class="elem"><a href="#">Дебетовая карта</a></div>
		<div class="elem"><a href="#">Страхование</a></div>
		<div class="elem"><a href="#">Друзья</a></div>
		<div class="elem_last"><a href="#">Интернет-банк</a></div>
	</div>

	<!-- Хлебные крошки -->
	<div class="bread">
		<ul>
			<li class="bread_elem"><a href="#">Главная</a></li>
			<li class="bread_elem"> - <a href="#">Вклады</a></li>
			<li class="bread_elem bread_elem_active"> - <a href="#">Калькулятор</a></li>
		</ul>
	</div>

	<!-- Тело -->
	<div class="body">
		<div class="calc">
			<div class="calc_header">
				<span>Калькулятор</span>
			</div>
			<div class="calc_body">
				<table>
					<tr>
						<td class="table_title">Дата оформления вклада</td>
						<td class="table_elem_form"><input class="input" type="text" id="datepicker"></td>
						<td class="elem_slider"></td>
					</tr>

					<tr>
						<td class="table_title">Сумма вклада</td>
						<td class="table_elem_form">
						<input class="input"  type="text" id="amount" type="number"  required  >

						<!-- <input id="amount" value="10000" step="10" min="1000" max="3000000" class="input" type="number" required> -->
						</td>
						<td class="elem_slider">
						<div id="slider-range-min"></div>
							<!-- <div id="slider"></div> -->
						</td>
					</tr>

					<tr>
						<td class="table_title">Срок вклада</td>
						<td class="table_elem_form">
							<select name="" id="select">
								<option value="1">1 год</option>
								<option value="2">2 года</option>
								<option value="3">3 года</option>
								<option value="4">4 года</option>
								<option value="5">5 лет</option>	
							</select>
						</td>
						<td class="elem_slider"></td>
					</tr>

					<tr>
						<td class="table_title">Пополнение вклада</td>
						<td class="table_elem_form"><input name="radio" value="0" type="radio" checked="checked"> Нет <input class="radio" type="radio" value="1" name="radio"> Да </td>
						<td class="elem_slider"></td>
					</tr>

					<tr>
						<td class="table_title">Сумма пополнения вклада</td>
						<td class="table_elem_form">
						<input class="input"  type="text" id="amount2" type="number"  required >
						<!-- <input value="10000" step="10" min="1000" max="3000000" class="input" type="number" required> -->
						</td>
						<td class="elem_slider"><div id="slider-range-min2"></div></td>
					</tr>
				</table>
			</div>
			<div class="cacl_footer">
				<div class="calc_botton" id="send_res"><img src="result.png" alt=""></div>
				<div class="calc_result"><span>Результат:</span></div>
			</div>
		</div>
	</div>

	<!-- футер -->
	<div class="footer">
		<ul>
			<li class="footer_elem"><a href="#">Кредитные карты</a></li>
			<li class="footer_elem"><a href="#">Вклады</a></li>
			<li class="footer_elem"><a href="#">Дебетовая карта</a></li>
			<li class="footer_elem"><a href="#">Страхование</a></li>
			<li class="footer_elem"><a href="#">Друзья</a></li>
			<li class="footer_elem"><a href="#">Интернет-банк</a></li>
		</ul>
	</div>
<script src="jquery-ui-1.12.1.custom/external/jquery/jquery.js"></script>
<script src="jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script>
$( "#datepicker" ).datepicker({
	inline: true
});


 $( function() {
    $( "#slider-range-min" ).slider({
      range: "min",
      value: 10000,
      min: 1000,
      max: 3000000,
      slide: function( event, ui ) {
        $( "#amount" ).val(  ui.value );
      }
    });
    $( "#amount" ).val( $( "#slider-range-min" ).slider( "value" ) );

$( "#slider-range-min2" ).slider({
      range: "min",
      value: 10000,
      min: 1000,
      max: 3000000,
      slide: function( event, ui ) {
        $( "#amount2" ).val(  ui.value );
      }
    });
    $( "#amount2" ).val( $( "#slider-range-min2" ).slider( "value" ) );

  } );

$('#send_res').on('click',function(){
	let datepicker = $('#datepicker').val();
	datepicker = datepicker.replace(/\//g, '.');

	let amount = $('#amount').val();
	let amount2 = $('#amount2').val();
	let select = $('#select').val();

	let radio = $('input[name=radio]:checked').val();
	
	$.ajax({
            type: 'POST',
            url: 'calc.php',
            data : {
              'datepicker':datepicker,
              'amount':amount,
              'amount2':amount2,
              'select':select,
              'radio':radio
            },
            success: function(answer) {
              	var dataAnswer = JSON.parse(answer);
              	if(dataAnswer.status=='bad'){
              		$('span.bad').remove();
              		$('span.good').remove();
          			$('.calc_result').append('<span class="bad">'+dataAnswer.str+'</span>');
              	}
              	if(dataAnswer.status=='good'){
              		$('span.good').remove();
              		$('span.bad').remove();
              		let num = (Math.ceil(
              			Number(dataAnswer.str) 
              			));
              		$('.calc_result').append('<span class="good">'+num+'</span>');
              	}
            }
          });
	// console.log(datepicker,amount,amount2,select,radio);
});
</script>
</body>
</html>