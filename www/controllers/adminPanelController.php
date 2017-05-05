<?php
require_once 'models/editor.php';
require_once 'models/map.php';
require_once 'views/adminPanel/indexView.php';
require_once 'views/adminPanel/loginView.php';
require_once 'views/adminPanel/alreadyLoggedView.php';
require_once 'views/adminPanel/addBuildingView.php';
require_once 'views/adminPanel/buildingAddedView.php';


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

		if (!empty($_POST['lat']) && !empty($_POST['lon']) && !empty($_POST['_name']))
		{
			$name = $_POST['_name'];
			$posX = $_POST['lat'];
			$posY = $_POST['lon'];
			
			$building = new Building;
			$building->name = $name;
			$building->lat = $posX;
			$building->lon = $posY;
			$building->editorId = $_SESSION['loginUserId'];
			
			if (!$building->update())
			{
				die("Nie udalo sie utworzyc budynku.");
			}

			$bid = $building->id;
			
			if (isset($_FILES['image']))
			{
				foreach ($_FILES['image']['tmp_name'] as $index => $tmpname)
				{
					if ($_FILES['image']['error'][$index] !== UPLOAD_ERR_OK)
					{
						echo "Nie udalo sie wrzucic pliku: Blad {$_FILES['image']['error'][$index]}\n"; 
						continue;
					}
					$imgname = md5($name.$_POST['floor'][$index]).".png";
					move_uploaded_file($tmpname, "./media/".$imgname);
					$map = new Map;
					$map->floor = $_POST['floor'][$index];
					$map->image = $imgname;
					$map->imageMD5 = md5(file_get_contents("./media/".$imgname));
					$size = getimagesize("./media/".$imgname);
					$map->imageWidth = $size[0];
					$map->imageHeight = $size[1];
					$map->buildingId = $bid;
					$map->editorId = $_SESSION['loginUserId'];
					$map->update();
				}
			}
			
			$view = new AdminPanelBuildingAddedView;
		} else
			$view = new AdminPanelAddBuildingView;
		
		return $view->render();
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
		
	// $edit=new Editor;		
	// $this->userName=$_GET['userName'];
	// if($_GET['userPassword']==$_GET['userPassword2']
	//	$this->userPassword=$_GET['userPassword]'];
	

		


		// Funkcjonalnosc dodawania edytorow
	}
}

?>
