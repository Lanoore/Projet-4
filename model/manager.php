<?php

class Manager{
	static function dbConnect(){
		//Permet de se connecter à la bdd
		$db = new PDO('mysql:hist=localhost;dbname=blog;charset=utf8', 'root', '');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}
}