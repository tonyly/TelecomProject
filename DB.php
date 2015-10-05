<?php

class DB{
	public static function connect($db, $username, $password, $table, $column, $var){
		$con = mysql_connect('localhost',$username,$password) or die("Unable to login to database");
		@mysql_select_db($database,$con) or die("Unable to connect");


		$query = "SELECT * FROM $table WHERE $column = '$var'";
		$result = mysql_query($query);
		return $result;
	}
}