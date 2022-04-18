AddEventHandler("main", "OnBuildGlobalMenu", "DoBuildGlobalMenu");

function DoBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu) {
$aModuleMenu[] = array(
      "parent_menu" => "global_menu_custom",
      "icon" => "default_menu_icon",
      "page_icon" => "default_page_icon",
      "sort"=>"100",
      "text"=>"Custom Item Text",
      "title"=>"Custom Item Tille",
      "url"=>"/bitrix/admin/custom_item.php",
      "more_url"=>array(),
   );

}