<?php
require_once 'models/map.php';

class PinListView
{
	public $pins = array();

	function render()
	{
		foreach($this->pins as $value)
		{
		$resultMap = Map::GetById($value['id']);
		$PinList = $PinList . "<p><a href=\"building/show?name=".$resultMap['name'] . "&floor=" . $resultMap['floor'] . "&pinId=" . 
		$value['id'] . "> budynek ".$resultMap['name'] . "pietro " . $resultMap['floor'] . "pinId " . $value['id'] ."</a></p>";
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
