<?php

class AdminPanelLoginView
{
	public $result;

	function render()
	{
		$layout = file_get_contents('views/_layoutView.html');
		$body = file_get_contents('views/adminPanel/loginView.html');
		$content = str_replace(['::RenderStyles::', '::RenderBody::', '::RenderScripts::', 
			'::RenderScriptsInclude::'],
			['', $body, '', ''], $layout);
		$content = str_replace('::result::', $this->result, $content);
		return $content;
	}
}

?>