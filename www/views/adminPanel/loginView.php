<?php

class AdminPanelLoginView
{
	public $result;

	function render()
	{
		$content = file_get_contents('views/adminPanel/loginView.html');
		$content = str_replace('::result::', $this->result, $content);
		return $content;
	}
}

?>