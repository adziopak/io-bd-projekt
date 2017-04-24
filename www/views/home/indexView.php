<?php

class HomeIndexView
{
	function render()
	{
		$content = file_get_contents('views/home/indexView.html');
		return $content;
	}
}

?>