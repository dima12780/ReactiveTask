<?
 	class DbConnect
    {
		public $db_host = "localhost"; 
	    public $db_user = "root"; 
	    public $db_password = ""; 
	    public $db_base = "task";
		public $db_table = "users";
		public $mysqli; 
		public $query; 

	    function __construct()
	    {
			$database = "CREATE DATABASE IF NOT EXISTS ". $this->db_base .";";
			$tabel = "CREATE TABLE IF NOT EXISTS ". $this->db_table."( 
					`id` INT(10) AUTO_INCREMENT,
					`login` VARCHAR(30) ,
					`password` VARCHAR(30) ,
					`name` VARCHAR(30) ,
					`email` VARCHAR(30) ,
					PRIMARY KEY (`id`)) ENGINE = InnoDB;";

	        $this->mysqli =  mysqli_connect($this->db_host, $this->db_user, $this->db_password) or die("Ошибка подключения<br>" . mysqli_error($this->mysqli));

			$this->query = mysqli_query($this->mysqli, $database) or die ("Ошибка при создании БД<br>" . mysqli_error($this->mysqli));
			$this->mysqli = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_base);

			$this->query = mysqli_query($this->mysqli, $tabel) or die ("Ошибка при создании таблицы<br>" . mysqli_error($this->mysqli));
   		}

   		function select($query, $bool = true)
   		{
			$result = mysqli_query($this->mysqli, $query);
			return ($bool)? mysqli_fetch_row($result) : $result;
   		}

		function insert($query)
		{
			return mysqli_query($this->mysqli, $query);
		}
		
		function delete($query)
		{
			return mysqli_query($this->mysqli, $query);
		}

   		function assoc($res){
	        while ($row = $res->fetch_assoc())
	        {
	            $result[] = $row;
	        }
    		return $result;
    	}

   		function close()
   		{
   			 mysqli_close($this->mysqli);
   		}

	}