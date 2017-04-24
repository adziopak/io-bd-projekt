<?php
require_once 'utils/databaseConnect.php';
require_once 'models/path.php';

class Pin
{
	public $id;
	public $name;
	public $posX;
	public $posY;
	public $map;
	public $editorId;

	public function getPaths()
	{
		// Pobiera wszystkie sciezki z danym pinem.
	}

	public function getPathToPin($pin)
	{
		// Pobiera (jezeli istnieje) sciezke do pinu z parametru.
	}

	public function update()
	{
		
	}
}

?>