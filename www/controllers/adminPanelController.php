<?php
require_once 'models/editor.php';
require_once 'views/adminPanel/indexView.php';
require_once 'views/adminPanel/loginView.php';
require_once 'views/adminPanel/alreadyLoggedView.php';


// obsluga panalu admina/edytora
// /adminPanel
class AdminPanelController
{
	// /adminPanel
	public function index()
	{
		// przekierowania do akcji kontrolera
		if (isset($_GET['action']))
		{
			switch($_GET['action'])
			{
				case 'login':
					return $this->login();

				case 'addBuilding':
					return $this->addBuilding();

				case 'addPin':
					return $this->addPin();

				case 'addPath':
					return $this->addPath();

				case 'addEditor':
					return $this->addEditor();
			}
		}

		// kod /adminPanel/index
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

	// /adminPanel/login
	public function login()
	{
		if (isset($_SESSION['loginUserId']))
		{
			$view = new AdminPanelAlreadyLoggedView;
			return $view->render();
		}

		$view = new AdminPanelLoginView();
		
		if (isset($_POST['userName']))
		{
			$editor = Editor::GetByUserName($_POST['userName']);

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

	// /adminPanel/addBuilding
	public function addBuilding()
	{
		if (!isset($_SESSION['loginUserId']))
		{
			header("Location: /adminPanel/login");
			die();
		}

		// Funkcjonalnosc dodawania nowych budynkow
	}

	// /adminPanel/addPin
	public function addPin()
	{
		if (!isset($_SESSION['loginUserId']))
		{
			header("Location: /adminPanel/login");
			die();
		}

		// Funkcjonalnosc dodawania pinow
	}

	// /adminPanel/addPath
	public function addPath()
	{
		if (!isset($_SESSION['loginUserId']))
		{
			header("Location: /adminPanel/login");
			die();
		}

		// Funkcjonalnosc dodawania sciezek
	}

	// /adminPanel/addEditor
	public function addEditor()
	{
		if (!isset($_SESSION['loginUserId']))
		{
			header("Location: /adminPanel/login");
			die();
		}

		// Funkcjonalnosc dodawania edytorow
	}
}

?>