<?php 

 require_once("restLib/Rest.inc.php");


  class API extends REST {
	
		public  $data = ""; 
		public  $server_path = "";
		private $db = NULL;
		public  $access_token= "";
		
		//Local Development Settings
		const DB_SERVER = "localhost";
		const DB_USER = "root"; 
		const DB_PASSWORD = "root";
		const DB = "samex_db";
		
		//API Response Status
		const STATUS_FAILED = "Failed";
		const STATUS_SUCCESS = "Success";
		
		
	
		public function __construct(){
			parent::__construct();				// Initializing parent contructor
			$this->dbConnect();	// Initiating Database connection
			$headers = getallheaders();
			
		}
		
		
		
		/*
		 *  Database connection 
		*/
		private function dbConnect(){
		
			$this->db = mysqli_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
		
			if($this->db){
				mysqli_select_db($this->db,self::DB);
			} 
			else { die("Connection failed: " . $this->db->connect_error); exit;}
		}
		
		
		
		
		/* Handle Dynamic calls through method query strings */
		
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['request'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404); // If the method not exist with in this class "Page?Method not found".
		}
		
		
		
	/*	private function testHeader()
		{
			echo $this->access_token;
		}*/
		
			private function testHeader()
		{
		
			
			 $this->_status['status'] = self::STATUS_SUCCESS;
			 $this->_status['message'] = "{'data': 'Waah jee waah'}"; 
			 $this->response($this->json($this->_status), 200);
			 exit();
		}
		
	
			
		
		/* Login Function for Mobile & Web*'end here'*/
		private function checkDB() {
		  		   
		  // Checking incoming request whether its POST or not, POST is allowed only
			if($this->get_request_method() != "POST"){
			   $this->_status['status'] = self::STATUS_FAILED;
			   $this->_status['message'] = "This is POST call, PUT and GET not acceptable";
  		       $this->_status['data'] = '';
			   $this->response($this->json($this->_status), 406);
			   exit();	
			
			}
			
			$username = $this->data_check($this->_request['username'],'Username');		
			$password = $this->data_check($this->_request['password'],'Password');
			$db_name = $this->data_check($this->_request['db_name'],'Database Name');		
		
			
			if(!empty($username) && !empty($password) && !empty($db_name) ){
			
			$auth_sql = mysqli_query($this->db,"Select * from user_auth WHERE username= '$username' AND password = '".md5($password)."' LIMIT 1");
					
					if(mysqli_num_rows($auth_sql) > 0){
						
						#checking db_name db_entries table
					    $db_sql = mysqli_query($this->db,"Select db_name from db_entries WHERE db_name='".$db_name."'");
						
						if(mysqli_num_rows($db_sql) > 0){
							
							//If record found then send header of "Found with 302" with user details
							 $this->_status['status'] = self::STATUS_FAILED;
							 $this->_status['message'] = "Database with the name ". $db_name . " already exist". "-". $this->access_token;
							 $this->response($this->json($this->_status), 302);
							 exit();	
							
						}
						else 
						{
							 	#create database with mentioned db_name
								 $sql_createDB = mysqli_query($this->db,"CREATE DATABASE ".$db_name);
								 
								 # checking database created successfully and inserting the record in db_entries
								 if($sql_createDB ==1)
								 {
									 mysqli_query($this->db,"insert into db_entries (db_name) values ('".$db_name."')");
									 
									 #reading sql dump file located in folder
									  $filename = "db_script.sql";
									  
									  $link = mysqli_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD,$db_name) or 
									  die('Error connecting to MySQL Database:  '. $db_name. " - " . mysqli_error());

									  
									     $tempLine = '';
									  
										// Read in the full file
										$lines = file($filename);
										// Loop through each line
										foreach ($lines as $line) {
										
											// Skip it if it's a comment
											if (substr($line, 0, 2) == '--' || $line == '')
												continue;
										
											// Add this line to the current segment
											$tempLine .= $line;
											
											// If its semicolon at the end, so that is the end of one query
											if (substr(trim($line), -1, 1) == ';')  {
												// Perform the query
												
												mysqli_query($link, $tempLine) or print("Error in " . $tempLine .":". mysqli_error());
												// Reset temp variable to empty
												$tempLine = '';
											}
									}
        
								# sending response  of successful creation on database with status:201
								 $this->_status['status'] = self::STATUS_SUCCESS;
								 $this->_status['message'] = "Database created successfully";
								 $this->response($this->json($this->_status), 201);
								 exit();	
							    }
						  }
					
					}
					
					# sending response of API authentication failed
					 $this->_status['status'] = self::STATUS_FAILED;
			   		 $this->_status['message'] = "Invalid Username or Password";
  		      		 $this->_status['data'] = '';
			  		 $this->response($this->json($this->_status), 401);
			   		 exit();	
				
				
			}
			
				// If invalid params "Bad Request" status message with reason
			   $this->_status['status'] = self::STATUS_FAILED;
			   $this->_status['message'] = "Unknown Error Occured";
  		       $this->_status['data'] = '';
			   $this->response($this->json($this->_status), 400);
			   exit();	
			
		 	
		}
		
		private function data_check($param, $field)
		{
			
		   if($param ==''  )
		   {
			
			  $this->_status['status'] = 'Failed';
			  $this->_status['message'] = $field ." Is Required";
			  $this->_status['data'] = '';
			  
			  $this->response($this->json($this->_status), 406);
			  exit();
		   }
		   else
		   {
		  //  return mysqli_real_escape_string($this->db,$param);
			 return mysqli_real_escape_string($this->db,$param);
		   }
		  
		}

	
	/*	turn normal array into JSON array	*/
	   private function json($data){
		if(is_array($data)){
			return json_encode($data,JSON_UNESCAPED_UNICODE);
		}
	}
		
  }
  
  // Initiiate Library
	$api = new API;
	$api->processApi();
?>