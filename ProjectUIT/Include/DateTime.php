<?php
date_default_timezone_set("Europe/Belgrade");
$CurentTime=time();
$DateTime=strftime("%d-%B-%Y %H:%M:%S",$CurentTime);
echo $DateTime;