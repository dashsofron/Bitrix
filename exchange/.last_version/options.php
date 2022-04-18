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
		"DIV" => "edit3",
		"TAB" => "Данные об обмене",
		"TITLE" => "Обмен",
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

<form name="input" method="POST" action="">

  <div><pre></div>
  <div align = "center"><label>ID: <input type="text" name="id"></label></div>
  <div><pre></div>
  <div align = "center"><input type="submit" name="get" value="Получить"></div>
  <div><pre></div>
  <div align = "center"><textarea name="output" rows="20" cols="150" >

    <?php 
      if(isset($_POST['get'])){
        display((int)$_POST['id']);
      }
    ?>

  </textarea></div>
</form>
 

<?php
  function display($id){
      
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
    /** @var Sale\Order $orderClass */
    $orderClass = $registry->getOrderClassName();
    $order = $orderClass::load($arOrder['ID']);
    //$order = CSaleExport::load($arOrder['ID']);
    //print("order:\n");
    //print_r($order);

    $arAgent = CSaleExport::getSaleExport();
    foreach($arAgent as $key => $value){
      echo "\t{$key}: {$value}\n";
    }

    echo "\n";

    $agentParams = (array_key_exists($arOrder["PERSON_TYPE_ID"], $arAgent) ? $arAgent[$arOrder["PERSON_TYPE_ID"]] : array() );
    print("agentParams:\n");

    foreach($agentParams as $key => $value){
      echo "\t{$key}: {$value}\n";
    }

    echo "\n";

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
  }
?>
<? $tabControl->End(); ?>





