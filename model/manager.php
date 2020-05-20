<?php

class Manager{
	static function dbConnect(){
		$db = new PDO('mysql:hist=localhost;dbname=blog;charset=utf8', 'root', '');
		//$db = new PDO('mysql:host=db5000439863.hosting-data.io;dbname=dbs420502','dbu593303','MaxDadarks27*');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}
}