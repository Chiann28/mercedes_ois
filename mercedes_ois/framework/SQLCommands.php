<?php
require_once "Connection.php";

	class SQLCommands extends Connection{

		public $database;
        
		public function __construct($database) {
            parent::__construct();
            $this->database = $database;
        }

		public function check_mysql_version(){
			$version = [];
			$query = "SELECT LEFT(version(),1) as id,version() as `version` ";
			$version = $this->SelectQuery($query);
			return (isset($version[0]) ? $version[0] : $version);
		}

		public function mysql_bulk_insert_on_duplicate_key_update($table,$params){
			$stringValue = '';
			$updateValue = '';
			$tableColumn = '';
					$version = $this->check_mysql_version();
					$version = ['id' => 1];
					foreach($params as $k=>$insert){
						$cols = [];
						$value = '';
						$values = [];
						$updateCols = [];
						foreach ($insert as $key => $value) {
							$cols[] = "`$key`";
								if(isset($version['id']) && $version['id'] >=  9){
									$updateCols[] = "`$key` = temp.`$key`";
								}else{
									$updateCols[] = "`$key` = VALUES(`$key`)";
								}
							$value = $this->clean_string($value);
							if($value == ''){
									$values[] = 'NULL';
							}else{
									$values[] = '"'.$value.'"';
							}

						}

						$stringValue .= '('.implode(", ",  $values).'),';

					}
					$stringValue = rtrim($stringValue, ", ");
					$tableColumn = implode(", ", $cols);

					if(COUNT($updateCols) > 0){
							$updateValue .= implode(", ",  $updateCols).',';
					}
					$updateValue = rtrim($updateValue, ", ");

					
					
					if(isset($version['id']) && $version['id'] >=  9){
						$query = 'INSERT INTO `'.$table.'` ('.$tableColumn.') VALUES '.$stringValue. ' AS tmp ON DUPLICATE KEY UPDATE '.$updateValue.';';
					}else{
						$query = 'INSERT INTO `'.$table.'` ('.$tableColumn.') VALUES '.$stringValue. ' ON DUPLICATE KEY UPDATE '.$updateValue.';';
					}
					$result = mysqli_query($this->MySQLconnection(),$query);
					return $result;

		}

		public function MySQLconnection() {
			$dbhandle = mysqli_connect($this->host, $this->user, $this->pass, $this->database);
		
			if (!$dbhandle) {
				die(json_encode(["error" => "Could not connect to database: " . mysqli_connect_error()]));
			}
		
			return $dbhandle;
		}
		

		public  function SelectQuery($query){
				$data = [];
				$query = $this->clean_string($query);
				$result = mysqli_query($this->MySQLconnection(),$query);
				while($rows = mysqli_fetch_assoc($result))
				{
						$data[] = $this->clean_string($rows);
				}	
				
				return $data;
		}

		public  function clean_string($data){
			if(is_array($data)){
				$data = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\x9F]/u', '',$data);
				foreach($data as $key => $value){
						$data[$key] = stripslashes($value);
				}

				return $data;
			}else{
				return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\x9F]/u', '',$data);
			}
		}

		public  function DeleteQuery($query){
				$query = $this->clean_string($query);

	     $result = mysqli_query($this->MySQLconnection(),$query);

	     return $result;
	    }

		public  function UpdateQuery($query){
				$query = $this->clean_string($query);

	      $result = mysqli_query($this->MySQLconnection(),$query);

		
		
	      return $result;
	    }

		public  function InsertQuery($table,$params){
			try{
				foreach ($params as $key => $value) {
					if($params[$key] == ""){
						unset($params[$key]);
					}
				}
	            foreach ($params as $key => $value) { 
	                      if($value != ""){
	                        $cols[] = "`$key`";
	                      $values[] = '"'.addslashes($this->clean_string($value)).'"';
	                      }
	            }
	            $query = 'INSERT INTO `'.$table.'` ('.implode(", ", $cols).') VALUES ('.implode(", ",  $values).') ';
				
	            $query = $this->clean_string($query);	

							// echo $query;
		  				// die();

	            $result = mysqli_query($this->MySQLconnection(),$query);
	      	            return $result;
	            }catch (Exception $e) {
					return "Caught exception: ".  $e->getMessage(). "\n";
				}
	    }

	
	    public  function InsertIgnoreQuery($table,$params){
			try{
				foreach ($params as $key => $value) {
					if($params[$key] == ""){
						unset($params[$key]);
					}
				}
	            foreach ($params as $key => $value) {
	                      if($value != ""){
	                        $cols[] = "`$key`";
	                      $values[] = '"'.addslashes($this->clean_string($value)).'"';
	                      }
	            }
	            $query = 'INSERT IGNORE INTO `'.$table.'` ('.implode(", ", $cols).') VALUES ('.implode(", ",  $values).') ';
			
				
				
	            $query = $this->clean_string($query);
	            $result = mysqli_query($this->MySQLconnection(),$query);
	      	            return $result;
	            }catch (Exception $e) {
					return "Caught exception: ".  $e->getMessage(). "\n";
				}
	    }

	    public function mysql_insert_on_duplicate_key_update($table,$insert,$update){
            foreach ($insert as $key => $value) {
                      if($value != "" && $value != "NULL" && $value != " "){
                        $cols[] = "`$key`";
                         $value = $this->clean_string($value);
                      $values[] = '"'.$value.'"';
                      }
            }

            foreach ($update as $key => $value) {
                if($value != "" && $value != "NULL" && $value != " "){
                   $value = addslashes($this->clean_string($value));
                    $updateCols[] = "`$key` = '$value'";
                }
            }

            $query = 'INSERT INTO `'.$table.'` ('.implode(", ", $cols).') VALUES ('.implode(", ",  $values).')
                                  ON DUPLICATE KEY UPDATE '.implode(", ", $updateCols);
                           
           	$result = mysqli_query($this->MySQLconnection(),$query);
	      	            return $result;
            return $result;
   		}


		public  function ReplaceQuery($table,$params){
				try{
				foreach ($params as $key => $value) {
					if($params[$key] == ""){
						unset($params[$key]);
					}
				}
	            foreach ($params as $key => $value) {

	                      if($value != ""){
	                        $cols[] = "`$key`";
	                      $values[] = '"'.addslashes($this->clean_string($value)).'"';
	                      }
	                }
	            $query = 'REPLACE INTO `'.$table.'` ('.implode(", ", $cols).') VALUES ('.implode(", ",  $values).') ';
	  			$query = $this->clean_string($query);
				
	            $result = mysqli_query($this->MySQLconnection(),$query);

	            return $result;
	            }catch (Exception $e) {
					return "Caught exception: ".  $e->getMessage(). "\n";
				}
	   }

		public function ReturnMySQLTableResult($result){
	        $final_response = array();
			
	        while($rows = mysqli_fetch_assoc($result)){
	             $final_response[] = $this->clean_string($rows);
	        }
	        return $final_response;
	   	}

	    public function StoredProcedureNullQuery($function,$parameters){
	   		for($a = 0; $a < count($parameters); $a++){
	   			if($parameters[$a] != ""){
	   				$parameters[$a] = "'".addslashes($this->clean_string($parameters[$a]))."'";
	   			}else{
	   				$parameters[$a] = "NULL";
	   			}
	   		}
          	$query = "call `".$function."`(".implode(", ",  $parameters).")";
						
						
						
			
          	 $result = mysqli_query($this->MySQLconnection(),$query);
      	return $result;
      }

	  	public function StoredProcedureQuery_SELECT($function,$parameters){
			for($a = 0; $a < count($parameters); $a++){
				$parameters[$a] = addslashes($this->clean_string($parameters[$a]));
			}
			$data = [];
			$query = "call `".$function."`('".implode("', '",  $parameters)."')";
					
			$result = mysqli_query($this->MySQLconnection(),$query);
			if (!$result) {
				return $data;
			}
			while($rows = mysqli_fetch_assoc($result))
				{
						$data[] = $this->clean_string($rows);
				}
			return $data;
		}

	  	public function StoredProcedureQuery($function,$parameters){
	   		for($a = 0; $a < count($parameters); $a++){
	   			$parameters[$a] = addslashes($this->clean_string($parameters[$a]));
	   		}

          	$query = "call `".$function."`('".implode("', '",  $parameters)."')";
					
						
      		$result = mysqli_query($this->MySQLconnection(),$query);
      		return $result;
      }

			public function StoredProcedureQueryWithoutParameters($function){
          	$query = "call 	".$function."()";
          	
          	 
      		$result = mysqli_query($this->MySQLconnection(),$query);
      		return $result;
      }

      public  function InsertQueryUpperCase($table,$params){
			try{
				foreach ($params as $key => $value) {
					if($params[$key] == ""){
						unset($params[$key]);
					}
				}
	            foreach ($params as $key => $value) {
	                      if($value != ""){
	                        $cols[] = "`$key`";
	                      $values[] = '"'.addslashes($this->clean_string(strtoupper($value))).'"';
	                      }
	            }
	            $query = 'INSERT INTO `'.$table.'` ('.implode(", ", $cols).') VALUES ('.implode(", ",  $values).') ';
	        	

	            $query = $this->clean_string($query);
	            $result = mysqli_query($this->MySQLconnection(),$query);
	      	            return $result;
	            }catch (Exception $e) {
					return "Caught exception: ".  $e->getMessage(). "\n";
				}
	    }
       public function mysql_insert_on_duplicate_key_update_UpperCase($table,$insert,$update){
            foreach ($insert as $key => $value) {
                      if($value != "" && $value != "NULL" && $value != " "){
                        $cols[] = "`$key`";
                         $value = $this->clean_string(strtoupper($value));
                      $values[] = '"'.$value.'"';
                      }
            }

            foreach ($update as $key => $value) {
                if($value != "" && $value != "NULL" && $value != " "){
                   $value = addslashes($this->clean_string(strtoupper($value)));
                    $updateCols[] = "`$key` = '$value'";
                }
            }

            $query = 'INSERT INTO `'.$table.'` ('.implode(", ", $cols).') VALUES ('.implode(", ",  $values).')
                                  ON DUPLICATE KEY UPDATE '.implode(", ", $updateCols);
                                
           	$result = mysqli_query($this->MySQLconnection(),$query);
	      	            return $result;
            return $result;
   		}

      public  function ReplaceQueryUpperCase($table,$params){
				try{
				foreach ($params as $key => $value) {
					if($params[$key] == ""){
						unset($params[$key]);
					}
				}
	            foreach ($params as $key => $value) {

	                      if($value != ""){
	                        $cols[] = "`$key`";
	                      $values[] = '"'.addslashes($this->clean_string(strtoupper($value))).'"';
	                      }
	                }
	            $query = 'REPLACE INTO `'.$table.'` ('.implode(", ", $cols).') VALUES ('.implode(", ",  $values).') ';

	  			$query = $this->clean_string($query);
	
	            $result = mysqli_query($this->MySQLconnection(),$query);

	            return $result;
	            }catch (Exception $e) {
					return "Caught exception: ".  $e->getMessage(). "\n";
				}
	   }

	    public function StoredProcedureNullQueryUpperCase($function,$parameters){
	   		for($a = 0; $a < count($parameters); $a++){
	   			if($parameters[$a] != ""){
	   				$parameters[$a] = "'".addslashes($this->clean_string(strtoupper($parameters[$a])))."'";
	   			}else{
	   				$parameters[$a] = "NULL";
	   			}
	   		}
          	$query = "call `".$function."`(".implode(", ",  $parameters).")";

          	 $result = mysqli_query($this->MySQLconnection(),$query);
      	return $result;
      }
	  public function StoredProcedureQueryUpperCase($function,$parameters){
	   		for($a = 0; $a < count($parameters); $a++){
	   			$parameters[$a] = addslashes($this->clean_string(strtoupper($parameters[$a])));
	   		}

          	$query = "call `".$function."`('".implode("', '",  $parameters)."')";

      		$result = mysqli_query($this->MySQLconnection(),$query);
      		return $result;
      }
	}
?>