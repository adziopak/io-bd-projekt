<?php

class AdminPanelAddBuildingView
{

	function render()
	{
		$layout = file_get_contents('views/_layoutView.html');
		$body = file_get_contents('views/adminPanel/addBuildingView.html');
		$js = file_get_contents('views/adminPanel/addBuildingView.js');
		$content = str_replace(['::RenderStyles::', '::RenderBody::', '::RenderScripts::'],
			['', $body, $js], $layout);

		return $content;
	}
}

?>