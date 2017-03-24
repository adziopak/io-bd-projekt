<?php

class MapView
{
	public $apiKey;

	function render()
	{
		$content = file_get_contents('views/mapView.html');
		$content = str_replace('::apiKey::', $this->apiKey, $content);
		return $content;
	}
}

?>