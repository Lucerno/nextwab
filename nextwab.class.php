<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *   fichier              :  nextwab.class.php
 *   version              :  0.1
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *   author               :  LucernoPower
 *   copyright            :  (C) 2017 LucernoPower
 *   email                :  lucernopower@gmail.com
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

class Nextwab {
	private $email;
	private $pass;
	private $cleapi;
	private $cookie = "777/cookies.txt";
	
	public function __construct() {
		return true;
	}
	public function connection($email, $pass, $cleapi) {
		global $cookie;
		
		$lien = 'https://www.nextwab.com/account/connect-trait.php';
		$post = array(
			'mail' => $email,
			'password' => $pass
		);
		$this->email = $email;
		$this->pass = $pass;
		$this->cleapi = $cleapi;
 
		$curl = curl_init();
 
		curl_setopt($curl, CURLOPT_URL, $lien);
		curl_setopt($curl, CURLOPT_COOKIESESSION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		//curl_setopt($curl, CURLOPT_COOKIEJAR, realpath($cookie));
		curl_setopt($curl, CURLOPT_COOKIE, $cookie);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept-Language: fr']);
		curl_setopt($curl, CURLOPT_USERAGENT,'LucernoPower\'s Bot');
 
		$retour = curl_exec($curl);
		curl_close($curl);
		if(strpos($retour, "Mon Panel Client")){
			return true;
		}else{
			return $retour;
		}
	}
  

	public function statusdomaine($domaine){
		global $cookie;
		$url = 'https://www.nextwab.com/domaines/ajax-domain_check_index.php';
		$array = explode('.', $domaine); 
		$post = array(
			'domain' => $domaine,
			'extension' => $array[1]
		);
		$retour = $this->request($url, "POST", $post);
		if(strpos($retour, "semble disponible")){
			return true;
		}else{
			return false;
		}
	}
	
	public function envoyersms($nom, $numero, $message){
		global $cookie;
		//https://www.nextwab.com/forum/sources/432-api-php-envoyer-un-sms-a-partir-de-son-site-web.html
		$Configuration = array( 
			'user_mail'         => $this->email, 
			'user_password'     => $this->cleapi,
			'Nom' => $nom, //11 Caracteres maxi
			'Numero' => $numero, 
			'Message'    => $message, 
			'Action' => "Send"  
		); 
		$POST_Chaine = ""; 
		foreach($Configuration as $Cle => $Valeur) {$POST_Chaine .= $Cle.'='.$Valeur.'&amp;';} 
		rtrim($POST_Chaine, '&amp;'); 
		$url="http://api.nextwab.com/sms/"; 
		$retour = $this->request($url, "POST", $POST_Chaine);
		return $retour;
	}
	
	public function prixsms($nom, $numero, $message){
		global $cookie;
		//https://www.nextwab.com/forum/sources/432-api-php-envoyer-un-sms-a-partir-de-son-site-web.html
		$Configuration = array( 
			'user_mail'         => $this->email, 
			'user_password'     => $this->cleapi,
			'Nom' => $nom, //11 Caracteres maxi
			'Numero' => $numero, 
			'Message'    => $message, 
			'Pricing' => "Send"  
		); 
		$POST_Chaine = ""; 
		foreach($Configuration as $Cle => $Valeur) {$POST_Chaine .= $Cle.'='.$Valeur.'&amp;';} 
		rtrim($POST_Chaine, '&amp;'); 
		$url="http://api.nextwab.com/sms/"; 
		$retour = $this->request($url, "POST", $POST_Chaine);
		return $retour;
	}
	
	public function commanderdomaine($domaine){
		global $cookie;
		$url = 'https://www.nextwab.com/account/reserve_domain?domain='.$domaine.'&action=create';
		$retour = $this->request($url, "GET", null);
		return $retour;
	}

  
	private function request($url, $method, $post) {
		global $cookie;
 
		$curl = curl_init();
 
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_COOKIESESSION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_COOKIEFILE, realpath($cookie));
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		if($method == "POST"){
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		}
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept-Language: fr']);
		curl_setopt($curl, CURLOPT_USERAGENT,'LucernoPower\'s Bot');
 
		$retour = curl_exec($curl);
			
		curl_close($curl);
		
		return $retour;
	}

}
