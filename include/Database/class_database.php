<?php

// Class used for MySQL DB communcation
// Connects to DB on object creation
// Escape all user data with Database::escape( $str )
// Query with Database::query( $query )
// result are returned as an object row by row with Database::fetch_object()

class Database 
{
		private $db;
		private $host; 
		private $user;
		private $pass;
		private $name;
		private $result;

		
		public function __construct( )
		{
			$this->host = 'mysql.ecn.purdue.edu'; 
			$this->user = 'strat_prod';
			$this->pass = 'br3ndanfr@sier';
			$this->name = 'strat_prod';
			$this->result = null;

			$this->db = mysqli_connect( $this->host, $this->user, $this->pass, $this->name );	

			if( !$this->db )
				Log::doLog( "Database Connection Error: " . mysqli_error($this->db), true );

			//if( !mysql_select_db( $this->name, $this->db ) )
		//		Log::doLog( "Could not select the required database: " .  mysql_error(), true );
		}

		public function query( $query )
		{
			$this->free();

			$this->result = mysqli_query($this->db, $query );

			if( !$this->result )
			{
				$this->result = false;
				Log::doLog( "MySQL Error: " . mysql_error(), true );
			}
		}

		public function num_rows()
		{
			if( !$this->result )
				return false;

			return mysqli_num_rows( $this->result );
		}

		public function fetch_object()
		{
			if( !$this->result )
				return false;

			return mysqli_fetch_object( $this->result ); 
		}

		public function free()
		{
			if( !$this->result )
				return false;

			mysqli_free_result( $this->result );
			$this->result == false;
		}
		
		public function escape( $str )
		{
			return mysqli_real_escape_string( $this->db, $str);
		}	

}
