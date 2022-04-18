<?
	$module_id = "exchange";
	use Bitrix\Main\Loader;
	Loader::includeModule($module_id);
	$tabControl = new CAdminTabControl("tabControl", $aTabs);

	$tabs = [
		[
			"DIV" => "edit1",
			"TAB" => "Настройки",
			"TITLE" => "Настройки параметров 1С",
		],
		[
			"DIV" => "edit2",
			"TAB" => "Интервалы несогласованности",
			"TITLE" => "Интервалы несогласованности",
		],
		
		[
			"DIV" => "edit4",
			"TAB" => "Отладка обмена",
			"TITLE" => "Отладка обмена",
		],
	];

	$tabControl = new CAdminTabControl("tabControl", $tabs);

	$tabControl->Begin(); 
?>

	<?
	$tabControl->BeginNextTab();
	?>
	<form enctype="multipart/form-data" name="insertFile" method="POST" action="submitFile.php">
	    Файл настроек 1С: <input name="settingsfile" type="file" />
	    <input type="submit" value="Загрузить файл" />
	</form>


	
	<?
	$tabControl->BeginNextTab();
	?>

	<form name="getIntervals" method="POST">
	 <!--  <div align = "center"><input type="submit" name="updateFiles" value="Обновить список файлов"></div> -->
	  <div align = "center"><select name="file">
	  	<option value="">Выберите файл</option>
	  	<?  
                if (isset ($select)&&$select!=""){  
                $select=$_POST ['file'];  
            }  
            ?>  
	   <?php
    $dir =
        "E:/0ДАША/httpd-2.4.52-o111m-x64-vc15/Apache24/htdocs/bitrix/Settings/";
    $files = scandir($dir);
    ?>
		<?
		foreach ($files as $file):
			if($file != '.' && $file != '..'){?>
			
			<option value="<? echo $dir.$file?>"><? echo $file ?></option>
		<?} endforeach;
		?>
	  </select></div>  

	<div align = "center"><input type="submit" name="countIntervals" value="Посчитать отрезки"></div>  
    </form> 
	

	<?
	$tabControl->BeginNextTab();
	?>

  <form name="getOrderInfo"  method="POST" >
	  <div><pre></div>
	  <div align = "center"><label>ID: <input type="text" id="id" name="id"></label></div>
	  <div><pre></div>
	  <div align = "center"><input type="submit" name="getOrderInfo" value="Получить"></div>

	  <div align = "center"><input type="checkbox" name="flag" value="Выводить лог"> <label>Выводить лог</label><br></div>


	  <div><pre></div>
	  <div align = "center"><table name="output" rows="20" cols="150" border="" >


    <?php if (isset($_POST["getOrderInfo"])) {
        displayTable((int) $_POST["id"]);
        // if(isset($flag)){
        // 	// displayText((int)$_POST['id']);
        // }
    } ?>


  </table></div>

</form>
 

 <?php function saveFile()
 {
     if (isset($_FILES["settingsfile"])) {
         $allowedExtensions = ["xml", "txt"];
         $mimeType = $_FILES["settingsfile"]["type"];
         $fileName = $_FILES["settingsfile"]["name"];
         $fileLocation =
             "E:/0ДАША/httpd-2.4.52-o111m-x64-vc15/Apache24/htdocs/bitrix/Settings/";

         if (!in_array($mimeType, $allowedExtensions)) {
             echo "bad file extension";
         } else {
             move_uploaded_file($_FILES["file"]["tmp_name"], $fileLocation);
             echo "moved";
         }
     }
 } ?>
<?php
/**function displayText($id){ 
CModule::IncludeModule('sale');
    $order = Bitrix\Sale\Order::load($id);
    $shipmentCollection = $order->getShipmentCollection();
    foreach ($shipmentCollection as $shipment) {
      $shipmentItemCollection = $shipment->getShipmentItemCollection();
      $sellableItems = $shipmentItemCollection->getSellableItems();
	//pre($sellableItems);
    }$arFilter = array("ID"=>1);
    $arOrder = array('ID'=>1, "PERSON_TYPE_ID" => 1);
    CModule::IncludeModule("catalog");
    CModule::IncludeModule("sale");

    $registry = Bitrix\Sale\Registry::getInstance(Bitrix\Sale\Registry::REGISTRY_TYPE_ORDER);
     @var Sale\Order $orderClass 
    $orderClass = $registry->getOrderClassName();
    $order = $orderClass::load($arOrder['ID']);
    //$order = CSaleExport::load($arOrder['ID']);
    //print("order:\n");
    //print_r($order);

    $arAgent = CSaleExport::getSaleExport();
    foreach($arAgent as $key => $value){
    	$logText=$logText+"\t{$key}: {$value}\n";
    }

$logText=$logText+'\n'
    // $agentParams = (array_key_exists($arOrder["PERSON_TYPE_ID"], $arAgent) ? $arAgent[$arOrder["PERSON_TYPE_ID"]] : array() );
    // print("agentParams:\n");

    // foreach($agentParams as $key => $value){
    //   echo "\t{$key}: {$value}\n";
    // }

    // echo "\n";

    $bExportFromCrm = false;
    $bCrmModuleIncluded = false;
    $paySystems = array();
    $delivery = array();
    $locationStreetPropertyValue = "";

    $arProp = CSaleExport::prepareSaleProperty($arOrder, $bExportFromCrm, $bCrmModuleIncluded, $paySystems, $delivery, $locationStreetPropertyValue, $order);
    print("arProp:\n");


    foreach($arProp as $key => $value){
      echo "\t{$key}: {$value}\n";
    }

    echo "\n";

    $agent = CSaleExport::prepareSalePropertyRekv($order, $agentParams, $arProp, $locationStreetPropertyValue);
    print("agent:\n");


    foreach($agent as $key => $value){
      echo "\t{$key}: {$value}</pre>\n";
    }

    echo "\n";

    $SaleProperties = CSaleExport::getXmlSaleProperties($arOrder, $arShipment, $arPayment, $agent, $agentParams, $bExportFromCrm);
    $RekvProperties = CSaleExport::getXmlRekvProperties($agent, $agentParams);

    echo "\n";
    print("Дополнительные реквизиты:\n");
    print("SaleProperties:\n"); 


    print_r($SaleProperties);
    echo "\n";
    print("RekvProperties:\n");

    print_r($RekvProperties);
  }*/
?>



<?php function displayTable($id)
{
    CModule::IncludeModule("sale");
    $order = Bitrix\Sale\Order::load($id);
    $shipmentCollection = $order->getShipmentCollection();
    foreach ($shipmentCollection as $shipment) {
        $shipmentItemCollection = $shipment->getShipmentItemCollection();
        $sellableItems = $shipmentItemCollection->getSellableItems();
    }
    $arFilter = ["ID" => $id];
    $arOrder = ["ID" => $id, "PERSON_TYPE_ID" => $order->getUserId()];
    CModule::IncludeModule("catalog");
    CModule::IncludeModule("sale");
    $registry = Bitrix\Sale\Registry::getInstance(
        Bitrix\Sale\Registry::REGISTRY_TYPE_ORDER
    );
    $orderClass = $registry->getOrderClassName();
    $order = $orderClass::load($arOrder["ID"]);
    $arAgent = CSaleExport::getSaleExport();
    $agentParams = array_key_exists($arOrder["PERSON_TYPE_ID"], $arAgent)
        ? $arAgent[$arOrder["PERSON_TYPE_ID"]]
        : [];
    $bExportFromCrm = false;
    $bCrmModuleIncluded = false;
    $paySystems = [];
    $delivery = [];
    $locationStreetPropertyValue = "";
    $arProp = CSaleExport::prepareSaleProperty(
        $arOrder,
        $bExportFromCrm,
        $bCrmModuleIncluded,
        $paySystems,
        $delivery,
        $locationStreetPropertyValue,
        $order
    );
    $agent = CSaleExport::prepareSalePropertyRekv(
        $order,
        $agentParams,
        $arProp,
        $locationStreetPropertyValue
    );
    $SaleProperties = CSaleExport::getXmlSaleProperties(
        $arOrder,
        $arShipment,
        $arPayment,
        $agent,
        $agentParams,
        $bExportFromCrm
    );
    $RekvProperties = CSaleExport::getXmlRekvProperties($agent, $agentParams);
    $orderInfo = new SimpleXMLElement($SaleProperties);
    echo '<tr align = "center"><td colspan="',
        6,
        '">Идентификатор 
заказа:',
        $id,
        "</td></tr>";
    echo '<tr align = "center"><td colspan="',
        6,
        '">Идентификатор 
заказчика:',
        $order->getUserId(),
        "</td></tr>";
    if ($agent["IS_FIZ"] == "Y") {
        echo '<tr align = "center">',
            '<td colspan="',
            2,
            '">Физ лицо</td>',
            '<td colspan="',
            2,
            '">Заказ</td>',
            "</tr>";
        echo '<tr align = "center">',
            "<td>Полное имя</td>",
            "<td>",
            $agent["FULL_NAME"],
            "</td>",
            "<td>Оплачен</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[0]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Имя агента</td>",
            "<td>",
            $agent["AGENT_NAME"],
            "</td>",
            "<td>Доставка разрешена</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[1]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Имя</td>",
            "<td>",
            $agent["NAME"],
            "</td>",
            "<td>Отменен</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[2]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Фамилия</td>",
            "<td>",
            $agent["SURNAME"],
            "</td>",
            "<td>Финальный статус</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[3]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Почта</td>",
            "<td>",
            $agent["EMAIL"],
            "</td>",
            "<td>Статус заказа</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[4]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Телефон</td>",
            "<td>",
            $agent["PHONE"],
            "</td>",
            "<td>Статус заказа ид</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[5]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            '<td colspan="2">Адрес</td>',
            "<td>Сайт</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[6]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Полный адрес</td>",
            "<td>",
            $agent["ADDRESS_FULL"],
            "</td>",
            '<td colspan="2" rowspan="6"></td>',
            "</tr>",
            '<tr align = "center">',
            "<td>Индекс</td>",
            "<td>",
            $agent["INDEX"],
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Регион</td>",
            "<td>",
            $agent["REGION"],
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Страна</td>",
            "<td>",
            $agent["COUNTRY"],
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Город</td>",
            "<td>",
            $agent["CITY"],
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Улица</td>",
            "<td>",
            $agent["STREET"],
            "</td>",
            "</tr>";
    } else {
        echo '<tr align = "center">',
            '<td colspan="',
            2,
            '">Юридическое лицо</td>',
            '<td colspan="',
            2,
            '">Физическое лицо</td>',
            '<td colspan="',
            2,
            '">Заказ</td>',
            "</tr>";
        echo '<tr align = "center">',
            "<td>Полное имя</td>",
            "<td>",
            $agent["FULL_NAME"],
            "</td>",
            "<td>Полное имя</td>",
            "<td>",
            $arProp["PROPERTY"]["12"],
            "</td>",
            "<td>Оплачен</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[0]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Имя агента</td>",
            "<td>",
            $agent["AGENT_NAME"],
            "</td>",
            "<td>Имя агента</td>",
            "<td>-</td>",
            "<td>Доставка разрешена</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[1]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>ИНН</td>",
            "<td>",
            $agent["INN"],
            "</td>",
            "<td>Имя</td>",
            "<td>-</td>",
            "<td>Отменен</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[2]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>КПП</td>",
            "<td>",
            $agent["KPP"],
            "</td>",
            "<td>Фамилия</td>",
            "<td>-</td>",
            "<td>Финальный статус</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[3]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Почта</td>",
            "<td>",
            $agent["EMAIL"],
            "</td>",
            "<td>Почта</td>",
            "<td>-</td>",
            "<td>Статус заказа</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[4]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Телефон</td>",
            "<td>",
            $agent["PHONE"],
            "</td>",
            "<td>Телефон</td>",
            "<td>-</td>",
            "<td>Статус заказа ид</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[5]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            '<td colspan="2">Адрес</td>',
            '<td colspan="2">Адрес</td>',
            "<td>Сайт</td>",
            "<td>",
            $orderInfo->ЗначениеРеквизита[6]->Значение,
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Полный адрес</td>",
            "<td>",
            $agent["ADDRESS_FULL"],
            "</td>",
            "<td>Полный адрес</td>",
            "<td>",
            $agent["F_ADDRESS_FULL"],
            "</td>",
            '<td colspan="2" rowspan="6"></td>',
            "</tr>",
            '<tr align = "center">',
            "<td>Страна</td>",
            "<td>",
            $agent["COUNTRY"],
            "</td>",
            "<td>Индекс</td>",
            "<td>",
            $agent["F_INDEX"],
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Город</td>",
            "<td>",
            $agent["CITY"],
            "</td>",
            "<td>Регион</td>",
            "<td>-</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Улица</td>",
            "<td>",
            $agent["STREET"],
            "</td>",
            "<td>Страна</td>",
            "<td>",
            $agent["F_COUNTRY"],
            "</td>",
            "</tr>",
            '<tr align = "center">',
            '<td colspan="2" rowspan="2"></td>',
            "<td>Город</td>",
            "<td>",
            $agent["F_CITY"],
            "</td>",
            "</tr>",
            '<tr align = "center">',
            "<td>Улица</td>",
            "<td>",
            $agent["F_STREET"],
            "</td>",
            "</tr>";
    }
} ?>
<? $tabControl->End(); ?>





 ?>