<?php

class StartView
{
	function render()
	{
		$content = file_get_contents('views/startView.html');
		return $content;
	}
}

?>