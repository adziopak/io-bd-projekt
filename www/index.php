<?php
require_once 'views/startView.php';
require_once 'views/exampleView.php';
require_once 'views/mapView.php';
require_once 'views/phpInfoView.php';
require_once 'views/buildingMapView.php';
require_once 'utils/databaseConnect.php';
require_once 'utils/point2D.php';

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
		$view->apiKey = "jakistamkluczktorydostaniemypotemiwtedypowinnodzialac";
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
		$sql = "select * from maps where name ='V_0'";
		$result = $dbconn->getConnection()->query($sql);
		$result = $result->fetch_assoc();

		$view = new BuildingMapView;
		$view->currentMap = "media/" . $result['image'];
		$view->mapWidth = $result['map_width'];
		$view->mapHeight = $result['map_height'];

		$sql = "select * from pins";
		$resultFetch = $dbconn->getConnection()->query($sql);

		$pos = new Point2D;
		$result = $resultFetch->fetch_assoc();
		$pos->x = $result['pos_x'];
		$pos->y = $result['pos_y'];
		array_push($view->position, $pos);

		$pos = new Point2D;
		$result = $resultFetch->fetch_assoc();
		$pos->x = $result['pos_x'];
		$pos->y = $result['pos_y'];
		array_push($view->position, $pos);

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