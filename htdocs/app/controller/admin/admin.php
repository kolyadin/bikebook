<?php
class KaControllerAdmin extends KaController
{
    public function movie_edit($movie_id)
    {
        $this->view->loadAndRender('/admin/movies/edit.php');
    }

    public function movie_edit_save()
    {
        $movieModel = $this->model->load('movies');

        $movieModel->setFull($_POST);
    }

    public function movies()
    {
        $model = $this->model->load('/movies.php');

        $list = $model->getAdminList();

        $this->view->loadAndRender('/admin/movies/list.php',array(
            'list' => $list
        ));
    }

    public function remote()
    {
        $filter = $this->parseFilter($_GET['filter']);

        $mysqli = KaDB::getInstance();

        $result = $mysqli->query(sprintf('SELECT id,%1$s FROM %2$s WHERE %1$s LIKE "%%%3$s%%" LIMIT 10'
            ,$filter['field']
            ,$filter['table']
            ,$mysqli->real_escape_string($_GET['term'])
        ));

        //$result = $mysqli->query('SELECT title FROM ka_person LIMIT 10');

        $data = array();

        while ($row = $result->fetch_row())
        {
            $data[] = array(
            	 'id'    => $row[0]
            	,'value' => $row[1]
            	,'pic'   => 'http://v0.kinoafisha.org/k/persons/90/upload/p1OVcU.jpg'
            );
        }


        die(json_encode($data));
    }


    /**
    {ka_person|title}
    {ka_person:cat=1&sub=2|title}
     */
    private function parseFilter($filter)
    {
        if (preg_match('@\A\{(?P<table>[^\:\|]+)(\:(?P<sub>[^\|]+)|\|)(?P<field>.+)\}\z@',$filter,$matches))
        {
            list($table,$sub,$field) = array($matches['table'],$matches['sub'],trim($matches['field'],'|'));

            return array(
                'table' => $table
            ,'sub'   => $sub ? $sub : null
            ,'field' => $field
            );
        }

        return false;
    }
}