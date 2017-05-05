<?php

class AdminPanelIndexView
{

	function render()
	{
		$layout = file_get_contents('views/_layoutView.html');
		$body = file_get_contents('views/adminPanel/indexView.html');
		$content = str_replace(['::RenderStyles::', '::RenderBody::', '::RenderScripts::', 
			'::RenderScriptsInclude::'],
			['', $body, '', ''], $layout);

		return $content;
	}
}

?>