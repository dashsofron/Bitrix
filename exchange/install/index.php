<?
	Class exchange extends CModule
	{
	    var $MODULE_ID = "exchange";
	    var $MODULE_NAME;
	    var $MODULE_DESCRIPTION;
	
	    function exchange()
	    {
	        $arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}

		$this->MODULE_NAME = "Обмен с 1С";
		$this->MODULE_DESCRIPTION = "После установки будет возможность более удобной отладки";

	    }
	 
	    function DoInstall()
	    {
	        RegisterModule("exchange");
	        
      	    }
	 
	    function DoUninstall()
	    {
	       UnRegisterModule("exchange");

	    }
	}
	?>