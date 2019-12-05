<?php
function db_connect() {
	// définition des variables de connexion à la base de données
	try {
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		// INFORMATIONS DE CONNEXION
		$host = 	'localhost';
		$dbname = 	'ndinfo';
		$user = 	'root';
		$password = 	'';
		// FIN DES DONNEES

		$db = new PDO('mysql:host='.$host.';dbname='.$dbname.'', $user, $password, $pdo_options);
    echo "<p>Connexion a la ddb...</p>";
		return $db;
	} catch (Exception $e) {
		die('Erreur de connexion : ' . $e->getMessage());
	}
}
?>
