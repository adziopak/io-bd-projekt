<?php
require_once 'models/editor.php';
require_once 'views/adminPanel/indexView.php';
require_once 'views/adminPanel/loginView.php';
require_once 'views/adminPanel/alreadyLoggedView.php';

class AdminPanelController
{
	public function index()
	{
		if (isset($_GET['action']))
		{
			switch($_GET['action'])
			{
				case 'login':
					return $this->login();
			}
		}

		if (isset($_SESSION['loginUserId']))
		{
			if (isset($_GET['logout']))
			{
				unset($_SESSION['loginUserId']);
				header("Location: /adminPanel/login");
				die();
			}

			$view = new AdminPanelIndexView;
			return $view->render();
		}
		else
		{
			header("Location: /adminPanel/login");
			die();
		}
	}

	public function login()
	{
		if (isset($_SESSION['loginUserId']))
		{
			$view = new AdminPanelAlreadyLoggedView;
			return $view->render();
		}

		$view = new AdminPanelLoginView();
		// If post action
		if (isset($_POST['userName']))
		{
			$editor = Editor::GetEditorByUserName($_POST['userName']);

			if (password_verify($_POST['userPassword'], $editor->userPassword))
			{
				$_SESSION['loginUserId'] = $editor->id;
				header("Location: /adminPanel");
				die();
			}
			else 
			{
				$view->result = "Złe dane";
			}
		}

		return $view->render();
	}
}

?>