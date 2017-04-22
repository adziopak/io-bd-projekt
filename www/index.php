<?php
require_once 'views/startView.php';
require_once 'views/exampleView.php';
require_once 'views/mapView.php';
require_once 'views/phpInfoView.php';
require_once 'views/buildingMapView.php';
require_once 'views/pinSearchView.php';
require_once 'utils/databaseConnect.php';
require_once 'utils/point2D.php';
require_once 'controllers/adminPanelController.php';

session_start();

if (isset($_GET['path']))
{
	$subviews = [ 'example', 'map', 'buildingMap', 'databaseTest' ];

	if ($_GET['path'] == 'example')
	{
		$view = new ExampleView;
		if (isset($_GET['message']))
			$view->what = $_GET['message'];
		else
			$view->what = "World!";
		echo $view->render();
	}
	else if ($_GET['path'] == 'map')
	{
		$view = new MapView;
		// TODO: wrzucic to do jakiegos configu
		$view->apiKey = "AIzaSyBcwERVsQ9-u3vGi93armuqOI4lts5qqt4";
		echo $view->render();
	}
	else if ($_GET['path'] == 'phpinfo')
	{
		$view = new PhpInfoView;
		echo $view->render();
	}
	else if ($_GET['path'] == 'buildingMap')
	{
		$dbconn = new DatabaseConnect;
		$view = new BuildingMapView;

		$sql = "select `name` from maps";
		$result = $dbconn->getConnection()->query($sql);
		$view->maps = $result->fetch_all();
		
		if (isset($_GET['map']))
		{
			$sql = "select * from maps where name ='" . $_GET['map'] . "'";
			$result = $dbconn->getConnection()->query($sql);
			$result = $result->fetch_assoc();

			$view->currentMap = "media/" . $result['image'];
			$view->mapWidth = $result['map_width'];
			$view->mapHeight = $result['map_height'];

			$sql = "select * from pins where map_id = " . $result['id'];	

			if (isset($_GET['roomOnly']))
			{
				$sql = $sql . " and not (name is null or name = '')";
			}
			
			if (isset($_GET['pinId']))
			{
				$sql = $sql . " and id = " . $_GET['pinId'];
			}			
			
			
			$resultFetch = $dbconn->getConnection()->query($sql);

			for ($pin = $resultFetch->fetch_assoc(); $pin != null; $pin = $resultFetch->fetch_assoc())
			{
				$pos = new Point2D;
				$pos->x = $pin['pos_x'];
				$pos->y = $pin['pos_y'];
				array_push($view->positions, $pos);
			}
		}

		echo $view->render();		
	}
	else if ($_GET['path'] == 'pinSearch')
	{
		if (isset($_GET['roomName']))
		{
			$dbconn = new DatabaseConnect;
			$sql = "select * from pins where name ='" . $_GET['roomName'] . "'";
			$resultPin = $dbconn->getConnection()->query($sql);
			$resultPin = $resultPin->fetch_assoc();
			
			if (!is_null($resultPin))
			{
				$sql = "select * from maps where id = " . $resultPin['map_id'];
				$resultMap = $dbconn->getConnection()->query($sql);
				$resultMap = $resultMap->fetch_assoc();

				header("Location: buildingMap&map=" . $resultMap['name'] . "?pinId=" . $resultPin['id']);
				die();
			}
		}

		$view = new PinSearchView;
		echo $view->render();
	}
	else if ($_GET['path'] == 'databaseTest')
	{
		$dbconn = new DatabaseConnect;
		$sql = "select * from testtable";
		$result = $dbconn->getConnection()->query($sql);

		header('Content-type: application/json');
		echo json_encode($result->fetch_all(MYSQLI_ASSOC));
	}
	else if ($_GET['path'] == 'adminPanel')
	{
		$ctrl = new AdminPanelController;

		echo $ctrl->index();
	}
	else if ($_GET['path'] == '')
	{
		$view = new StartView;
		echo $view->render();
	}
	else 
	{
		http_response_code(404);
		die();
	}
}	
else
{
	$view = new StartView;
	echo $view->render();
}

?>