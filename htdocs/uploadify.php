<?php

$image = $_FILES['Filedata']['tmp_name'];
$nname = microtime(1).'.jpg';

copy($image,dirname(__FILE__).'/upload/'.$nname);

die(json_encode(array(
	 'fileThumb' => '/k/rp/100x100/upload/'.$nname
	,'fileBig'   => '/upload/'.$nname
)));