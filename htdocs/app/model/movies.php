<?php
class KaModelMovies extends KaModel
{
	public function getMovie($id)
	{

	}

	private function parseArgs($args)
	{
		parse_str($args,$output);

		return $output;
	}

	public function getMovies($args)
	{
		$par = $this->parseArgs($args);

		print '<pre>'.print_r($par,true).'</pre>';

		/*
		$result = $this->mysqli->query('SELECT * FROM ka_movie');

		while ($row = $result->fetch_assoc())
		{
			print '<pre>'.print_r($row,true).'</pre>';
		}
		*/
	}

	public function getAdminList()
	{

		$result = $this->mysqli->query('SELECT * FROM ka_movie ORDER BY id DESC');
		
		$data = array();
		
		while ($row = $result->fetch_assoc())
		{
			$data[] = $row;
		}
		
		return $data;
	}
	
	public function setFull($data)
	{
		if (is_array($data['poster']))
		{
			$json = array();
			
			foreach ($data['poster'] as $poster)
			{
				$json[] = array(
					 'timestamp' => time()
					,'path'      => $poster
				);
			}
			
			$data['poster'] = json_encode($json);
		}
		
		$this->mysqli->queryFile('/movie.sql/new_movie'
			,$this->mysqli->real_escape_string($data['title'])
			,$this->mysqli->real_escape_string($data['poster'])
			,$this->mysqli->real_escape_string($data['original_title'])
			,$this->mysqli->real_escape_string($data['production_year'])
			,$this->mysqli->real_escape_string($data['production_country'])
			,$this->mysqli->real_escape_string($data['description'])
		);
	}
	
	public function getLastId()
	{
		return 953614;
	}
}
