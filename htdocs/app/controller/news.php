<?php

class KaControllerNews extends KaController
{
    public function view($news_id)
    {
        $vars = array(
        	 'content' => '<p><strong>Как дела то?</strong><p>Хочу в отпуск бля!!'
        	,'news_id' => $news_id
			,'title'   => 'Новости из оврага'
        );

		$vars['list'][] = array(
			'id' => 23551,
			'title' => 'Фродо "возвращается!'
		);

		$vars['list'][] = array(
			'id' => 23552,
			'title' => 'Фродо не вернулся!'
		);




		$movie = $this->model->load('/movies.php');

		$this->model('/movies.php')->getList('order_by=rating');


		$opt = $this->model->newRule();
		$opt->order_by[] = 'id desc';
		$opt->order_by[] = 'rating desc';


		$movie->setFilter($opt)->getMovies();

		$this->view->display('news.twig',$vars);
    }

    public function front()
    {
        print 'front news';
        #echo '<pre>'.print_r(debug_backtrace(),1).'</pre>';
    }
}