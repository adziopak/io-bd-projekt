<?php
require_once 'utils/databaseConnect.php';
require_once 'models/map.php';
require_once 'models/editor.php';

class Pin
{
	public $id;
	public $name;
	public $posX;
	public $posY;
	public $map;
	public $editorId;

	public function getPathsId()
	{
		// Pobiera wszystkie sciezki z danym pinem.
	}

	public function getPathIdToPin($pin)
	{
		// Pobiera (jezeli istnieje) sciezke do pinu z parametru.
	}

	public function update()
	{
		
	}
}

?>