<?php

class Manager{
	static function dbConnect(){
		//Permet de se connecter à la bdd
		$db = new PDO('mysql:host=nomDeLHost;dbname=nomDeLaBDD;charset=utf8', 'nomUtilisatuer', 'MotDePasse');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}
}