<?php
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
