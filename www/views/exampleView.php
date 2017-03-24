<?php

class ExampleView
{
	public $what;

	function render()
	{
		$content = file_get_contents('views/exampleView.html');
		$content = str_replace('::what::', $this->what, $content);
		
		return $content;
	}
}

?>