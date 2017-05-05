<?php

class AdminPanelBuildingAddedView
{
	function render()
	{
		$layout = file_get_contents('views/_layoutView.html');
		$content = str_replace(['::RenderStyles::', '::RenderBody::', '::RenderScripts::', 
			'::RenderScriptsInclude::'],
			['', 'Dodano budynek', '', ''], $layout);
		return $content;
	}
}

?>