<?php
require_once 'models/map.php';

class PinListView
{
	public $pins = array();

	function render()
	{
		$PinList = "";

		foreach($this->pins as $value)
		{
			$resultMap = Map::GetById($value->mapId);
			$building = Building::GetById($resultMap->buildingId);
			$PinList = $PinList . '<p><a href="show?name=' . $building->name . 
				'&floor=' . $resultMap->floor . '&pinId=' . $value->id . '">budynek ' . 
				$building->name . ' pietro ' . $resultMap->floor . ' pinId ' . 
				$value->id . '</a></p>';
		}
		
		$layout = file_get_contents('views/_layoutView.html');
		$body = $PinList;
				
		$content = str_replace(['::RenderStyles::', '::RenderBody::', '::RenderScripts::', 
			'::RenderScriptsInclude::'],
			['', $body, '', ''], $layout);

		return $content;
	}
}

?>
