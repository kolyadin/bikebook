<?php
function addEvent($event,$callback)
{
	try
	{
		if (empty($event)) throw new Exception('Указано несуществующее действие');
	}
	catch (Exception $e)
	{
		die($e->getMessage());
	}
	
	$event = array(
		 'id'        => 3267
		,'title'     => 'отрыков 1'
		,'timestamp' => time()
	);
	
	$callback($event);
}


addEvent('insert_before',function($event){
	
	$mysqli = KADB::getInstance();
	
	
	
});
