<?php

// Obsluga strony z widokiem budynku, pinow i sciezek
// /building
class BuildingController
{
	// /building
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

		// kod /building/index
		// ...
	}	

	// /building/about
	public function about()
	{

	}
}

?>