<?php
/*
$trApi = KA::getApi('api/trailers.php');

$trApi->get();
$trApi->insert();
$trApi->update();


$trApi->getById();
$trApi->getByIdHash('id','id_hash','title','sdfshbfsiyfgsf6t38fgv');


$trApi->getFrame();
$trApi->getPoster();

$trApi->setDefaultId(1231);

$trApi->flush();


$trApi->reset();
*/

abstract class KaApiAbstract
{
	abstract protected function getById($fields,$id);
	
	protected function parseFields($fields)
	{
		if ($fields == '*')
		{
			return '*';
		}
		else if (is_array($fields) && count($fields))
		{
			return implode(',',$fields);
		}
		else
		{
			return false;
		}
	}
}

class KaApiTrailer extends KaApiAbstract
{
	public $table = 'ka_trailers';
	
	public function getById($fields,$id)
	{
		
	}
	
	public function getByIdHash($fields,$idHash)
	{
		if (!$select = $this->parseFields($fields)) return false;
		
		#$mysqli = KADB::getInstance();
		
		printf('SELECT %s FROM %s WHERE id_hash = "%s" LIMIT 1'
			,$select
			,$this->table
			,$idHash
		);
	}
}

$trApi = new KaApiTrailer;
$trApi->getByIdHash(array('id','title','timestamp'),'e1a72ef9933f34543de72ffa45379538');
