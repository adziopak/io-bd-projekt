<?php
require_once 'views/home/indexView.php';

// obsluga strony startowej
// /
// /home
class HomeController
{
	// /home
	public function index()
	{
		// przekierowania do akcji kontrolera
		if (isset($_GET['action']))
		{
			switch($_GET['action'])
			{
				case 'about':
					return $this->about();
			}
		}

		// kod /home/index
		$view = new HomeIndexView;
		return $view->render();
	}	

	// /home/about
	public function about()
	{

	}
}

?>