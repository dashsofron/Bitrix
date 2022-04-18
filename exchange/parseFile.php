<?php
 	$FilePath= "E:\\0ДАША\httpd-2.4.52-o111m-x64-vc15\Apache24\htdocs\bitrix\Settings\settings.xml";
	if (file_exists($FilePath)) {
	    $xml = simplexml_load_file($FilePath);

	    // echo $xml->settingsNum;
	} else {
	    exit('Такой файл не существует');
	}

	$servername = "localhost";
	$username = "root";
	$password = "root";
	$db = "sitemanager";
	$conn = mysqli_connect($servername, $username, $password,$db);
	if (!$conn) {
  		die("Connection failed: " . mysqli_connect_error());
	}
	echo "Connected successfully";

	$sql = "INSERT INTO `entity`( `entity_name`) VALUES 
	('payment'),('shipment'),('merch'),('offer'),('property'),('rest'),('price')";
    $result = $conn->query($sql);
    $month_days_num;

    foreach ($xml->settingsList as $exchangeSetting):{
    	$schedule = $exchangeSetting->schedule;
    	$sql = "INSERT INTO `exchange`('exchange_name',`schedule_start`,'schedule_end', `month_repeat`,
    `month_day`,'week_day','week_repeat') VALUES (
    	$exchangeSetting->name,
    	$schedule->periodStartDate,
    	$schedule->periodEndDate,
    	$schedule->periodDaysRepeate,
    	
    	$schedule->monthSchedule->monthDay,
    	strcmp($schedule->monthSchedule->weekDayFromBegin,'true')
    			?$schedule->monthSchedule->weekDay
    			:$month_days_num[]
    	$schedule->monthSchedule->weekDay,
    	$schedule->weekSchedule->periodDaysRepeate
    	)";
		$result = $conn->query($sql);
    	$exchange_id = $conn->insert_id;
    	$days=$schedule->weekSchedule->weekDayList;
    	foreach ($schedule->monthSchedule->monthList as $month):{
    		$sql="SELECT month_id FROM month where month_name = $month"
    		$value_id=$conn->query($sql);
    		$sql = "INSERT INTO `schedule_day_month` ('exchange_id','type','value_ref') VALUES ($exchange_id,month,$value_id);"
    		$result = $conn->query($sql);
    	}
    	foreach ($schedule->weekSchedule->weekDayList as $day):{
    		$sql="SELECT weekday_id FROM weekday where weeday_name = $month"
    		$value_id=$conn->query($sql);
    		$sql = "INSERT INTO `schedule_day_month` ('exchange_id','type','value_ref') VALUES ($exchange_id,day,$value_id);"
    		$result = $conn->query($sql);
    	}
    	$properties = $exchangeSetting->properties;
    	


    	$sql="SELECT entity_id FROM entity where entity_name = $properties->paymentProperties->typeName"
    	$payment_id=$conn->query($sql);

    	$sql="SELECT entity_param_id FROM entity_param where entity_param_name = unloadPayments and entity_id=$payment_id"
    	$entity_param_id=$conn->query($sql);
    	$sql="INSERT INTO `exchange_param`(`entity_param_id`,'exchange_id') VALUES ($entity_param_id,$payment_id)";


    	$sql="SELECT entity_id FROM entity where entity_name = $properties->shipmentProperties->typeName"
    	$shipment_id=$conn->query($sql);

    	$sql="SELECT entity_param_id FROM entity_param where entity_param_name = unloadPayments and entity_id=$shipment_id"
    	$entity_param_id=$conn->query($sql);
    	$sql="INSERT INTO `exchange_param`(`entity_param_id`,'exchange_id') VALUES ($entity_param_id,$shipment_id)";


    	$sql="SELECT entity_id FROM entity where entity_name = $properties->merchProperties->typeName"
    	$merch_id=$conn->query($sql);

    	$sql="SELECT entity_param_id FROM entity_param where entity_param_name = unloadPayments and entity_id=$merch_id"
    	$entity_param_id=$conn->query($sql);
    	$sql="INSERT INTO `exchange_param`(`entity_param_id`,'exchange_id') VALUES ($entity_param_id,$merch_id)";


    	$sql="SELECT entity_id FROM entity where entity_name = $properties->offerProperties->typeName"
    	$offer_id=$conn->query($sql);

    	$sql="SELECT entity_param_id FROM entity_param where entity_param_name = unloadPayments and entity_id=$offer_id"
    	$entity_param_id=$conn->query($sql);
    	$sql="INSERT INTO `exchange_param`(`entity_param_id`,'exchange_id') VALUES ($entity_param_id,$offer_id)";


    	$sql="SELECT entity_id FROM entity where entity_name = $properties->properties->typeName"
    	$property_id=$conn->query($sql);

    	$sql="SELECT entity_param_id FROM entity_param where entity_param_name = unloadPayments and entity_id=$property_id"
    	$entity_param_id=$conn->query($sql);
    	$sql="INSERT INTO `exchange_param`(`entity_param_id`,'exchange_id') VALUES ($entity_param_id,$property_id)";


    	$sql="SELECT entity_id FROM entity where entity_name = $properties->restProperties->typeName"
    	$rest_id=$conn->query($sql);

    	$sql="SELECT entity_param_id FROM entity_param where entity_param_name = unloadPayments and entity_id=$rest_id"
    	$entity_param_id=$conn->query($sql);
    	$sql="INSERT INTO `exchange_param`(`entity_param_id`,'exchange_id') VALUES ($entity_param_id,$rest_id)";


    	$sql="SELECT entity_id FROM entity where entity_name = $properties->priceProperties->typeName"
    	$price_id=$conn->query($sql);

    	$sql="SELECT entity_param_id FROM entity_param where entity_param_name = unloadPayments and entity_id=$price_id"
    	$entity_param_id=$conn->query($sql);
    	$sql="INSERT INTO `exchange_param`(`entity_param_id`,'exchange_id') VALUES ($entity_param_id,$price_id)";


    }
(empty($_POST['action'])) ? 'default' : $_POST['action'];
?>


?сохранение в бд - есть, надо проверить
?!нужно добавить константы  (типо сущностей и параметров)
?!реализация алгоритма



"INSERT INTO `entity`(`entity_name`) VALUES ('$entity_name')";

"INSERT INTO `exchange`('exchange_name', `schedule_start`,'schedule_end', `month_repeat`,'month_list', `month_day`,'week_day', `week_day_list`,'week_repeat') VALUES (`$schedule_start`,'$schedule_end', `$month_repeat`,'$month_list', `$month_day`,'$week_day', `$week_day_list`,'$week_repeat')";

"INSERT INTO `entity_param`(`entity_param_name`,'entity_id','relevance_period') VALUES ('$entity_name','$entity_id','$relevance_period')";
ЗАПОЛНИТЬ ВРУЧНУЮ (или добавить поле )


"INSERT INTO `exchange_param`(`entity_param_id`,'exchange_id') VALUES ('$entity_param_id','$schedule_id')";


"INSERT INTO `param_period`(`exchange_param_id`,'start_date','closest_consistency_date','consistency_gap') VALUES ('$exchange_param_id','$start_date','$closest_consistency_date','$consistency_gap')";

"INSERT INTO `entity_period`(`entity_id`,'start_date','closest_consistancy_date','consistency_gap') VALUES ('$entity_id','$start_date','$closest_consistancy_date','consistency_gap')";

"INSERT INTO `period`(`period_start`,'closest_consistency_date','consistency_gap') VALUES ('$period_start','$closest_consistency_date','$consistency_gap')";