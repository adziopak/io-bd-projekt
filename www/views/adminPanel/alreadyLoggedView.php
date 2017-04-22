<?php

class AdminPanelAlreadyLoggedView
{
	function render()
	{
		$content = file_get_contents('views/adminPanel/alreadyLoggedView.html');
		return $content;
	}
}

?>