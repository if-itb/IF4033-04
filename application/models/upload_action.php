<?php

class Upload_action extends CI_Model{
    function  __construct() {
        parent::__construct();
    }


$file = $_FILES['file']['name'];
if ($_FILES['file']["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
else
{

    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      }
    }  

?> 