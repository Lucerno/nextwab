<?php
include "nextwab.class.php";

$email = "";

$mdp = "";

$cleapi = "";

$nextwab = new Nextwab();
if($nextwab->connection($email, $mdp, $cleapi)){
	echo $nextwab->commanderdomaine("freeservices.tk");
	echo "Connection Ok !";
}else{
	echo "Connection Impossible";
	echo $nextwab->connection($email, $mdp, $cleapi);
}
//echo $nextwab->prixsms("Sujet", "Numéro", "Message");
//echo $nextwab->statusdomaine("nextwab.fr");
