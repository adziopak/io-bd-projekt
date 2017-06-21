<?php
require_once 'models/admin.php';
require_once 'models/map.php';
require_once 'models/path.php';
require_once 'views/adminPanel/indexView.php';
require_once 'views/adminPanel/loginView.php';
require_once 'views/adminPanel/alreadyLoggedView.php';
require_once 'views/adminPanel/addBuildingView.php';
require_once 'views/adminPanel/buildingAddedView.php';
require_once  'views/adminPanel/choosePathView.php';
require_once  'views/adminPanel/addPathView.php';


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

				case 'choosePath':
					return $this->choosePath();

				case 'addAdmin':
					return $this->addAdmin();
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
			$admin = Admin::GetByUserName($_POST['userName']);

			if (password_verify($_POST['userPassword'], $admin->userPassword))
			{
				$_SESSION['loginUserId'] = $admin->id;
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
			$building->adminId = $_SESSION['loginUserId'];
			
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
					$map->adminId = $_SESSION['loginUserId'];
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
		if (isset($_POST['first_pin']) && isset($_POST['second_pin']))
		{
			$path = new Path;
			$path->firstPinId = $_POST['first_pin'];
			$path->secondPinId = $_POST['second_pin'];
			$path->adminId = $_SESSION['loginUserId'];
			$path->update();

		}
		if (!isset($_GET['name']) || !isset($_GET['floor']))
		{
			header("Location: /adminPanel/choosePath");
			die();
		}

		$building = Building::GetByName($_GET['name']);
		$map = $building->getMap($_GET['floor']);
		$view = new addPathView;
		$view->map = $map;

		
		$view->pins = $map->getPins();
		$view->paths = PathCoords::GetAllFromMapId($map->id);
		

		return $view->render();
		// Funkcjonalnosc dodawania sciezek
	}

	public function choosePath()
	{
		if (!isset($_SESSION['loginUserId']))
		{
			header("Location: /adminPanel/login");
			die();
		}
	$view = new choosePathView;
	$view->floors = BuildingFloor::GetAll();
	return $view->render();
	
	}

	// /adminPanel/addAdmin
	public function addAdmin()
	{
		if (!isset($_SESSION['loginUserId']))
		{
			header("Location: /adminPanel/login");
			die();
		}
		
	$edit=new Admin;
	$edit->userName=$_GET['userName'];
	$edit->userPassword=password_hash($_GET['userPassword'], PASSWORD_DEFAULT);
	if($_GET['userPassword']==$_GET['userPassword2'])
	{
	      $edit->update();
	      $view = new addEditorView(true);
	} 
	else {$view = new addEditorView(false);}
	echo $view->render();
	
	

		


		// Funkcjonalnosc dodawania edytorow
	}
}

?>
