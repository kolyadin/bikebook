<?php
class KaControllerMovies extends KaController
{
    public function movie($movie_id)
    {
        $vars = array(
            'title'    => 'Главная страница'
        ,'content'  => '<p>Фильмец бля'
        ,'movie_id' => $movie_id
        );

        $this->view->loadAndRender('movies.php',$vars);
    }

    public function postMovie($movie)
    {

        echo '<pre>'.print_r($_POST,1).'</pre>';
    }

    public function rating()
    {
        $model = $this->model->load('movies');

        $this->view->loadAndRender('movies/rating.php',array(
            'list' => $model->getMovies('order=rating&sort=desc')
        ));

        $model->getRating();
    }
}