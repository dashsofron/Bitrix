<?php

if (isset($_FILES['settingsfile'])) {
        $allowedExtensions = array('text/xml','text/plain');
        $mimeType = $_FILES['settingsfile']['type'];
        $fileName = $_FILES['settingsfile']['name'];
        // echo $fileName, "\n";
        // echo $mimeType, "\n";
        
        $fileLocation = "E:/0ДАША/httpd-2.4.52-o111m-x64-vc15/Apache24/htdocs/bitrix/Settings/".$fileName;
        // echo $fileLocation;
        
        // $fileLocation = "E:/0ДАША/httpd-2.4.52-o111m-x64-vc15/Apache24/htdocs/bitrix/Settings/"+fileName;
        // echo $fileLocation;


        if (!in_array($mimeType, $allowedExtensions)) {
            // echo "bad file extension";
        } else {
            move_uploaded_file($_FILES['settingsfile']['tmp_name'], $fileLocation);
            echo "moved";
        }
    } 
?>
