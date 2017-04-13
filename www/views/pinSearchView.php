<?php

class PinSearchView
{
	function render()
	{
		$content = file_get_contents('views/pinSearchView.html');
		
		return $content;
	}
}

?>