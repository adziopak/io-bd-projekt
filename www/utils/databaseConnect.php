<?php 

class DatabaseConnect
{
	private $connection;

	public function __construct()
	{
		$config = file_get_contents('config/databaseConfig.json');
		$config = json_decode($config, true);
		
		$this->connection = new mysqli($config['serverName'], $config['userName'], 
			$config['password'], $config['databaseName']);

		if ($this->connection->connect_error)
		{
			die("Connection failed: " . $this->connection->connect_error);
		}

	}

	public function __destruct()
	{
		$this->connection->close();
	}

	public function getConnection()
	{
		return $this->connection;
	}
}

?>