<?php

// Obsluga wyswietlania mapy wszystkich budynkow (google map i/albo nasz mapa)
// /map
class MapController
{
	// /map
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

		// kod /map/index
		// ...
	}	

	// /map/about
	public function about()
	{

	}
}

?>