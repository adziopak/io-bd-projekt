<?php

class HomeIndexView
{
	function render()
	{
		$layout = file_get_contents('views/_layoutView.html');
		$body = file_get_contents('views/home/indexView.html');
		$content = str_replace(['::RenderStyles::', '::RenderBody::', '::RenderScripts::'],
			['', $body, ''], $layout);
		return $content;
	}
}

?>