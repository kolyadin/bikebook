<?php
class KaModelAdmin extends KaModel
{
	public function __construct()
	{
		//$this->cache = new KaCache;
		$this->mysqli = KaDB::getInstance();
	}

	public function adminList()
	{
		$result = $this->db->query('SELECT * FROM ka_admin');

		$data = array();

		while ($row = $result->fetch_assoc())
		{
			$data[] = $row;
		}

		return $data;
	}
}
