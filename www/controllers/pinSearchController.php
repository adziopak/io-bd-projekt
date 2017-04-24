<?php

// obsluga wyszukiwarki 
// /
// /home
class PinSearchController
{
	// /pinSearch
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

		// kod /pinSearch/index
		// ...
	}	

	// /pinSearch/about
	public function about()
	{

	}
}

?>