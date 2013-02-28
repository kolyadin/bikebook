<?php
class KaApiMovie extends KaApiAbstract
{
	private $table = 'kinoafisha_v2_goods_';

	public function getById($fields,$id)
	{

	}

    public function dataManager()
    {
        return new KaApiMovieDataManager;
    }
}

$movieApi = new KaApiMovie;
$dataManager = $movieApi->dataManager();

$dataManager->set('title','Аватар');


class KaApiMovieDataManager
{
    public function set()
    {

    }

    public function preSave()
    {

    }
}