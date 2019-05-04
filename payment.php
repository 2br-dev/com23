<?php

session_start();



// подключение к бд
$hostname = "localhost";
$db_user = "akvatoria_new";
$db_name = "akvatoria_new";
$db_password = "38180067";



$link = mysqli_connect($hostname, $db_user, $db_password, $db_name) or die("Cannot connect to the database");

mysqli_select_db($link, $db_name) or die("Cannot select the database");



// Проверка пароля
if (isset($_POST['password']) && $_POST['password'] == "2212198638180067"){
	$_SESSION['online_payment']['success'] = 1; // Идетификатор правильно введенного пароля
}
else {
	//$_SESSION['online_payment']['success'] = 0;
}

// Если нажата кнопка Выход
if (isset($_POST['exit'])) {
	$_SESSION['online_payment']['success'] = 0;
}

// Если ввели правильный пароль 
if ($_SESSION['online_payment']['success']) {	
	echo "Вы вошли";
	echo "<form method='post' action='/payment.php'>
		<input type='hidden' name='exit' />
		<input type='submit' value='Выход'/>
	  </form>";
	echo '<form method="post" action="/payment.php">
		<!-- <input type="checkbox" name="date_payment" id="date_payment"><label for="date_payment">Отбирать по дате оплаты заказов</label><br><br>-->
		<strong>с </strong><input type="date" name="date_from" value="'.$_POST['date_from'].'" />
		<strong>по </strong><input type="date" name="date_to" value="'.$_POST['date_to'].'"/>
		<input type="submit" value="Сформировать" />
	</form>';

	// Вибираем все заказы со статусом 1 и типом опалаты "онлайн"
	$query = 'SELECT `order`.`order_num`, `order`.`dateof`, `order`.`totalcost`, `order`.`admin_comments`, `user`.`name`, `user`.`midname`, `user`.`surname`, `address`.`address`, `user`.`phone`
			FROM `akv_order` as `order` 
			LEFT JOIN `akv_users` as `user` 
			ON `order`.`user_id` = `user`.`id` 
			LEFT JOIN `akv_order_address` as `address`
			ON `order`.`use_addr` = `address`.`id`
			WHERE `order`.`payment` = 4 AND `order`.`site_id` = 1 AND `order`.`is_payed` = 1 ORDER BY FLOOR(`order`.`order_num`) DESC';
	$result = mysqli_query($link, $query);
	$total_amount = 0; // Общее количсвто заказов
	$total_summ = 0; // Общая сумма заказов

	// Если задана дата ОТ
	if (isset($_POST['date_from']) && $_POST['date_from'] != ''){
		
		if (strstr($_POST['date_from'], '.')) {
			$date_dot_from = explode('.', $_POST['date_from']);
			$date_from = $date_dot_from[2].$date_dot_from[1].$date_dot_from[0];			
		}
		else {
			$date_from = str_replace('-', '', $_POST['date_from']); // Преобразумем дату ОТ, убираем '-'
			$date_from_format = explode('-', $_POST['date_from']); // Разделяем дату на ($date_to_format[0] - год, $date_to_format[1] - месяц, $date_to_format[2] - дата) для последующего отображения в нужном формате.
		}
					
		
		// Если задана дата ДО
		if (isset($_POST['date_to']) && $_POST['date_to'] != ''){

			if (strstr($_POST['date_to'], '.')) {
				$date_dot_to = explode('.', $_POST['date_to']);
				$date_to = $date_dot_to[2].$date_dot_to[1].$date_dot_to[0];
				echo "<p>Показаны все заказы с <strong>".$date_dot_from[0].".".$date_dot_from[1].".".$date_dot_from[2]." по ".$date_dot_to[0].".".$date_dot_to[1].".".$date_dot_to[2]."</strong></p>";
			}
			else {
				$date_to = str_replace('-', '', $_POST['date_to']); // Преобразумем дату ДО, убираем '-'
				$date_to_format = explode('-', $_POST['date_to']); // Разделяем дату на ($date_to_format[0] - год, $date_to_format[1] - месяц, $date_to_format[2] - дата) для последующего отображения в нужном формате.
				echo "<p>Показаны все заказы с <strong>".$date_from_format[2].".".$date_from_format[1].".".$date_from_format[0]." по ".$date_to_format[2].".".$date_to_format[1].".".$date_to_format[0]."</strong></p>";
			}
			
			echo '<table>
					<tr>
						<td style="border:1px solid #ccc; padding: 5px;"><strong>Дата</strong></td>
						<td style="border:1px solid #ccc; padding: 5px;"><strong>Время</strong></td>
						<td style="border:1px solid #ccc; padding: 5px;"><strong>Сумма</strong></td>
						<td style="border:1px solid #ccc; padding: 5px;"><strong>ФИО</strong></td>					
						<td style="border:1px solid #ccc; padding: 5px;"><strong>Адрес доставки</strong></td>
						<td style="border:1px solid #ccc; padding: 5px;"><strong>Телефон</strong></td>
						<td style="border:1px solid #ccc; padding: 5px;"><strong>Номер заказа</strong></td>
						<td style="border:1px solid #ccc; padding: 5px;"><strong>Комментарий администратора</strong></td>						
					</tr>';
			while ($row = mysqli_fetch_array($result)){				
				
					$date_order = explode(' ', $row['dateof']); // Преобразуме дату заказа, чтоб отсечь время заказа
					$date_order_forFilter = str_replace('-', '', $date_order); // Преобразуем дату заказа, убираем '-'
					$dateOrder_date = explode('-', $date_order[0]);	// Разделяем дату на ($dateOrder_date[0] - год, $dateOrder_date[1] - месяц, $dateOrder_date[2] - дата) для последующего отображения в нужном формате.
				

				// Сравниваме дату заказа с датой От и датой ДО и выводим только подходящие под условие заказы
				if (($date_from <= $date_order_forFilter[0]) && ($date_to >= $date_order_forFilter[0])){
					$total_amount++;
					$total_summ = $total_summ + $row['totalcost'];
					echo '<tr>
						<td style="border:1px solid #ccc; padding: 5px;">'.$dateOrder_date[2].'.'.$dateOrder_date[1].'.'.$dateOrder_date[0].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$date_order[1].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['totalcost'].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['surname'].' '.$row['name'].' '.$row['midname'].'</td>				
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['address'].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['phone'].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['order_num'].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['admin_comments'].'</td>											
					</tr>';
				}
				
			}
			echo "</table>";
			echo $total_amount;
			echo "<br>";			
			echo $total_summ;
		}

		// Если не задана дато ДО
		else {
			if (strstr($_POST['date_from'], '.')){
				$date_dot_from = explode('.', $_POST['date_from']);
				$date_from = $date_dot_from[2].$date_dot_from[1].$date_dot_from[0];
				echo "<p>Показаны все заказы c <strong>".$date_dot_from[0].".".$date_dot_from[1].".".$date_dot_from[2]."</strong></p>";
			}
			else{
				$date_from_format = explode('-', $_POST['date_from']); // Разделяем дату на ($date_to_format[0] - год, $date_to_format[1] - месяц, $date_to_format[2] - дата) для последующего отображения в нужном формате.
				echo "<p>Показаны все заказы c <strong>".$date_from_format[2].".".$date_from_format[1].".".$date_from_format[0]."</strong></p>";
			}
			
			echo '<table>
				<tr>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Дата</strong></td>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Время</strong></td>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Сумма</strong></td>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>ФИО</strong></td>					
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Адрес доставки</strong></td>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Телефон</strong></td>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Номер заказа</strong></td>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Комментарий администратора</strong></td>						
				</tr>';
			while ($row = mysqli_fetch_array($result)){
				$date_order = explode(' ', $row['dateof']);
				$date_order_forFilter = str_replace('-', '', $date_order);
				$dateOrder_date = explode('-', $date_order[0]);	// Разделяем дату на ($dateOrder_date[0] - год, $dateOrder_date[1] - месяц, $dateOrder_date[2] - дата) для последующего отображения в нужном формате.				
				if ($date_from <= $date_order_forFilter[0]){
					$total_amount++;
					$total_summ = $total_summ + $row['totalcost'];
					echo '<tr>
						<td style="border:1px solid #ccc; padding: 5px;">'.$dateOrder_date[2].'.'.$dateOrder_date[1].'.'.$dateOrder_date[0].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$date_order[1].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['totalcost'].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['surname'].' '.$row['name'].' '.$row['midname'].'</td>				
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['address'].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['phone'].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['order_num'].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['admin_comments'].'</td>							
					</tr>';
				}
				
			}
			echo "</table>";
			echo $total_amount;
			echo "<br>";			
			echo $total_summ;
		}
	}

	// Если не задана дата От, но задана дата ДО
	elseif ((!isset($_POST['date_from']) || $_POST['date_from'] == '') && (isset($_POST['date_to']) && $_POST['date_to'] != '')){
		$date_to = str_replace('-', '', $_POST['date_to']); // Преобразумем дату ДО, убираем '-'
		if (strstr($_POST['date_to'], '.')){
			$date_dot_to = explode('.', $_POST['date_to']);
			$date_to = $date_dot_to[2].$date_dot_to[1].$date_dot_to[0];
			echo "<p>Показаны все заказы до <strong>".$date_dot_to[0].".".$date_dot_to[1].".".$date_dot_to[2]."</strong></p>";
		}
		else{
			$date_to_format = explode('-', $_POST['date_to']); // Разделяем дату на ($date_to_format[0] - год, $date_to_format[1] - месяц, $date_to_format[2] - дата) для последующего отображения в нужном формате.
			echo "<p>Показаны все заказы до <strong>".$date_to_format[2].".".$date_to_format[1].".".$date_to_format[0]."</strong></p>";
		}
		
		echo '<table>
			<tr>
				<td style="border:1px solid #ccc; padding: 5px;"><strong>Дата</strong></td>
				<td style="border:1px solid #ccc; padding: 5px;"><strong>Время</strong></td>
				<td style="border:1px solid #ccc; padding: 5px;"><strong>Сумма</strong></td>
				<td style="border:1px solid #ccc; padding: 5px;"><strong>ФИО</strong></td>					
				<td style="border:1px solid #ccc; padding: 5px;"><strong>Адрес доставки</strong></td>
				<td style="border:1px solid #ccc; padding: 5px;"><strong>Телефон</strong></td>
				<td style="border:1px solid #ccc; padding: 5px;"><strong>Номер заказа</strong></td>
				<td style="border:1px solid #ccc; padding: 5px;"><strong>Комментарий администратора</strong></td>							
			</tr>';
			while ($row = mysqli_fetch_array($result)){
				$date_order = explode(' ', $row['dateof']); // Разделяем дату от редискрипт на $date_order[0] - дата, $date_order[1] - время
				$date_order_forFilter = str_replace('-', '', $date_order);
				$dateOrder_date = explode('-', $date_order[0]);	// Разделяем дату на ($dateOrder_date[0] - год, $dateOrder_date[1] - месяц, $dateOrder_date[2] - дата) для последующего отображения в нужном формате.				
				if ($date_to >= $date_order_forFilter[0]){
					$total_amount++;
					$total_summ = $total_summ + $row['totalcost'];
					echo '<tr>
						<td style="border:1px solid #ccc; padding: 5px;">'.$dateOrder_date[2].'.'.$dateOrder_date[1].'.'.$dateOrder_date[0].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$date_order[1].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['totalcost'].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['surname'].' '.$row['name'].' '.$row['midname'].'</td>				
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['address'].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['phone'].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['order_num'].'</td>
						<td style="border:1px solid #ccc; padding: 5px;">'.$row['admin_comments'].'</td>						
					</tr>';
				}
				
			}
			echo "</table>";
			echo $total_amount;
			echo "<br>";			
			echo $total_summ;
	}

	// Если не заданы дата ОТ и дата ДО
	else {
		echo "<p>Показаны Все заказы</p>";
		echo '<table>
				<tr>									
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Дата</strong></td>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Время</strong></td>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Сумма</strong></td>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>ФИО</strong></td>					
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Адрес доставки</strong></td>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Телефон</strong></td>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Номер заказа</strong></td>
					<td style="border:1px solid #ccc; padding: 5px;"><strong>Комментарий администратора</strong></td>						
				</tr>';
		while ($row = mysqli_fetch_array($result)){
			$total_amount++;
			$total_summ = $total_summ + $row['totalcost'];
			$date_order = explode(' ', $row['dateof']); // Разделяем дату от редискрипт на $data_order[0] - дата, $data_order[1] - время
			$dateOrder_date = explode('-', $date_order[0]);	// Разделяем дату на ($dateOrder_date[0] - год, $dateOrder_date[1] - месяц, $dateOrder_date[2] - дата) для последующего отображения в нужном формате.			
			echo '<tr>							
				<td style="border:1px solid #ccc; padding: 5px;">'.$dateOrder_date[2].'.'.$dateOrder_date[1].'.'.$dateOrder_date[0].'</td>
				<td style="border:1px solid #ccc; padding: 5px;">'.$date_order[1].'</td>
				<td style="border:1px solid #ccc; padding: 5px;">'.$row['totalcost'].'</td>
				<td style="border:1px solid #ccc; padding: 5px;">'.$row['surname'].' '.$row['name'].' '.$row['midname'].'</td>				
				<td style="border:1px solid #ccc; padding: 5px;">'.$row['address'].'</td>
				<td style="border:1px solid #ccc; padding: 5px;">'.$row['phone'].'</td>
				<td style="border:1px solid #ccc; padding: 5px;">'.$row['order_num'].'</td>
				<td style="border:1px solid #ccc; padding: 5px;">'.$row['admin_comments'].'</td>					
			</tr>';
		}
		echo "</table>";
		echo $total_amount;
		echo "<br>";			
		echo $total_summ;
	}
} 
else {
	echo "<form method='post' action='/payment.php'>
		<input type='password' name='password' />
		<input type='submit' value='OK'/>
	  </form>";	  
}

