<?php
require_once 'views/startView.php';
require_once 'views/exampleView.php';
require_once 'views/mapView.php';
require_once 'views/phpInfoView.php';
require_once 'views/buildingMapView.php';
require_once 'utils/databaseConnect.php';

if (isset($_GET['path']))
{
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
		$view = new BuildingMapView;
		$view->currentMap = "media/v_0.png";
		echo $view->render();		
	}
	else if ($_GET['path'] == 'databaseTest')
	{
		$dbconn = new DatabaseConnect;
		$sql = "select * from testtable";
		$result = $dbconn->getConnection()->query($sql);

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