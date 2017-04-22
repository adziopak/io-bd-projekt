<?php

class AdminPanelIndexView
{

	function render()
	{
		$content = file_get_contents('views/adminPanel/indexView.html');
		return $content;
	}
}

?>