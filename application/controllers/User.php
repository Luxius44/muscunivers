<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR."UserEntity.php";
class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
        $this->load->model('UserModel');
		$this->load->library('session');
		$this->load->model('ProductModel');
		$this->load->model('OrderModel');
		$this->load->model('OrderProductModel');
	}

	//redirige vers la page "login" si la session['user'] est vide (si personne n'est connecté)
	//redirige vers la page "profil" si la session['user'] contient des éléments (si un client est connecté),
	//on récupère alors l'id de l'utilisateur dans les variables de sessions et on applique la fonction "findById"
	//pour récupérer les informations concernant l'utilisateur et les envoyer a la page "profil" pour les afficher
	function login(){
		if ( isset($_SESSION['user'])) {
			$id=$_SESSION['user']['id'];
			$user=$this->UserModel->findById($id);
			$_SESSION['user']['verif']=$user->getCompteVerifie();
			$_SESSION['user']['Statut']=$user->getStatut();
			$this->load->view('profile',array('user'=>$user));
		} else {
			$this->load->view('login');
		}
	}
	
	//redirige vers la page 'mp_oublie'.
	function mp_oublie_redirect(){
		$this->load->view('mp_oublie');
		
	}


	//Fonction qui vérifie qu'il n'existe pas de variable de session user et redirige vers add.
	function add(){
		if ( isset($_SESSION['user'])) {
			$id=$_SESSION['user']['id'];
			$user=$this->UserModel->findById($id);
			$this->load->view('profile',array('user'=>$user));
		} else {
			$this->load->view('add');
		}
	}

	//redirige vers la page "modificationProfil"
	//en envoyant les information du client courant à cette page.
	function modificationProfil_redirection(){
		if (isset($_SESSION["user"])){
			$id=$_SESSION['user']['id'];
			$client=$this->UserModel->findById($id);
			$this->load->view('modificationProfil',array('client'=>$client));
		}else{
			redirect('home');
		}
	}


	//Modifie le nom et prenom grace aux valeurs rentré sur la page "modificationProfil" dans les inputs "CliNom" et "CliPrenom"	
	function modificationNomPrenom(){
		if (isset($_SESSION["user"])){
		//On charge la bibliothèque "form validation" a chaque input pour s'assurer que l'utilisateur rentre bien ses informations 
		//Avec le bon nombre de caractères.
		$this->load->library('form_validation');
		$this->form_validation->set_rules('CliNom', 'CliNom','required|max_length[31]|regex_match[/^[^{\"]*$/]');
		$this->form_validation->set_rules('CliPrenom', 'CliPrenom','required|max_length[31]|regex_match[/^[^{\"]*$/]');

		if ($this->form_validation->run() == FALSE){
			$id=$_SESSION['user']['id'];
			$client=$this->UserModel->findById($id);
			$error="* Veuillez remplir tout les champs avec moins de 32 caractères";
			$this->load->view('modificationProfil',array("error"=>$error,"client"=>$client));
		}
		else{
			$id=$_SESSION['user']['id'];
			$client=$this->UserModel->findById($id);
			$client->setClinom($this->input->post('CliNom'));
			$client->setCliPrenom($this->input->post('CliPrenom'));
			$client=$this->UserModel->modification_Client($id,$client);
			$_SESSION['user']['prenom']=$client->getCliPrenom();
			redirect('user/login');
		}
	}
	else{
		redirect('home');
	}
	}

	//redirige vers la page "home" si la session['user'] est vide (si personne n'est connecté).
	//redirige vers la page "nouveauMail" si la session['user'] contient des éléments (si un client est connecté).
	function nouveauMail_redirection(){
		if (isset($_SESSION["user"])){
		$this->load->view('nouveauMail');
	}else{
		redirect('home');
	}
	}

	//redirige vers la page "home" si la session['user'] est vide (si personne n'est connecté).
	//redirige vers la page "nouveauMotDePasse" si la session['user'] contient des éléments (si un client est connecté).
	function nouveauMotDePasse_redirection(){
		if (isset($_SESSION["user"])){
		$this->load->view('nouveauMotDePasse');
		}
		else{
			redirect('home');
		}
	}

	// redirige vers la page MessageEnvoye,
	// change le contenue du message en fonction de l'id renseigné.
	function messageEnvoye_redirection(int $id){
		if ($id == 1){
			$message1 = "L'envoi du mail a été réussi avec succès !";
			$message2 = "Muscunivers vous remercie !";
			$this->load->view('messageEnvoye',array('message1'=>$message1,'message2'=>$message2));
		}
		if ($id == 2){
			$message1 = "La demande de réinitialisation de votre mot de passe a bien été prise en compte !";
			$message2 = "Veuillez ouvrir votre boîte mail";
			$this->load->view('messageEnvoye',array('message1'=>$message1,'message2'=>$message2));
		}
		if ($id == 3){
			$message1 = "Votre commande a bien été prise en compte !";
			$message2 = "Un récapitulatif de la commande est disponible sur votre boîte mail";
			$message3= "Muscunivers vous remercie !";
			$this->load->view('messageEnvoye',array('message1'=>$message1,'message2'=>$message2,'message3'=>$message3));
		}
	}


	//change le mot de passe du client 
	//on utilise la librairie 'form_validation' pour définir les règles de ce que le client rentre dans l'input
	//ici il faut que le client rentre deux fois son mot de passe et que les deux mots de passe renseignés correspondent
	//si il ne correspondent pas, on affiche l'erreur 'Veuillez remplir tout les champs'
	//si il correspondent, on enregistre le nouveau mot de passe dans la base de donnée.
	function nouveau_MotDePasse(){
		if (isset($_SESSION["user"])){
		$id=$_SESSION['user']['id'];
		$client=$this->UserModel->findById($id);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Mot de passe','required|matches[confpassword]');
		$this->form_validation->set_rules('confpassword', 'Confirmation mot de passe','required');

		if ($this->form_validation->run() == FALSE){
			$error="* Veuillez remplir tout les champs";
			$this->load->view('nouveauMotDePasse',array("error"=>$error));
		}
		else {
			$client->setClipassword(password_hash($this->input->post('password'), PASSWORD_DEFAULT));
			$client=$this->UserModel->modification_Client($id,$client);
			redirect('user/login');
			die();
		}
	}
	else{
		redirect('home');
	}
	}
	
	//redirige vers la page "home" si la session['user'] est vide (si personne n'est connecté)
	//redirige vers la page "verification_mail" si la session['user'] contient des éléments et si la ['variable verif'] est bien à 0,
	//ce qui signifie que le client n'a pas encore vérifier son adresse mail.
	function verification(){
		if ( isset($_SESSION['user']) ){
			if ( $_SESSION['user']['verif']=="0") {
				$this->load->view('verification_mail');
			} else {
				redirect('home');
			}
		} else {
			redirect('home');
		}
	}

	//vérifie si le mot de passe correspond à l'adresse mail.
	public function CheckLog(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('login', 'Login','required|valid_email');
		$this->form_validation->set_rules('password', 'Mot de passe','required');

		if ($this->form_validation->run() == FALSE){
			$error="* Veuillez remplir tout les champs et renseigner une email valide";
			$this->load->view('login',array("error"=>$error));
		}
		else {
			$email = $this->input->post('login');
			$password = $this->input->post('password');
			$user = $this->UserModel->findByEmail($email);

			//Si l'utilisateur est bien enregistré et que son mot de passe corresponds a celui présent dans la base de donnée 
			if ($user !=null && $user->isValidPassword($password)) {
				//On initialise la variable de session avec les informations nécessaires : le prenom du client,l'id du client, si son compte est vérifier, et son statut. 
				$_SESSION['user']=array("prenom"=>$user->getCliPrenom(), "id"=>$user->getCliId(),"verif"=>$user->getCompteVerifie(),"Statut"=>$user->getStatut());
				if ($user->getPanier()!="") {
					$client = new UserModel();
					$client->RecupCookie($user);
				} else {
					if (!$_SESSION['panier']) {
						$_SESSION['panier']=array();
					}
				}
				redirect("home");
				die();
			} else {
				$error="* Email ou mot de passe non valide!";
				$this->load->view('login',array("error"=>$error));
			}
		}
    }

	// Fonction qui envoie la variable de session Panier,
	// Unset les variables de session,
	// Détruit la session et redirige home.
	function logout(){
		$client = new UserModel();
		$client->EnvoieCookie();
		unset($_SESSION['panier']);
		unset($_SESSION['user']);
		$this->session->sess_destroy();
		redirect("home");
	}
	
	//fonction qui ajoute un client suivant les informations rentrés par le client sur la page 'add'
	//et qui envoie le mail de confirmation
	//si l'email a bien été envoyé, on crée les variables de session lié au compte
	//sinon on redirige vers la page 'error_mail'
	function addUser(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('prenom', 'Prenom','required|max_length[31]');
		$this->form_validation->set_rules('nom', 'Nom','required|max_length[31]');
		$this->form_validation->set_rules('date', 'Date','required');
		$this->form_validation->set_rules('email', 'Email','required|valid_email|max_length[63]');
		$this->form_validation->set_rules('password', 'Mot de passe','required');

		if ($this->form_validation->run() == FALSE){
			$error="* Veuillez remplir tout les champs";
			$this->load->view('add',array("error"=>$error));
		}
		else{

			// on recupère la date de naissance
			$date_of_birth = $this->input->post('date');
			//on convertit la date en seconde.
			$timestamp = strtotime($date_of_birth);

			//on calcul ensuite la différence entre la date actuelle et la date de naissance de l'utilisateur. 
			$current_timestamp = time();
			$age = floor(($current_timestamp - $timestamp) / (60 * 60 * 24 * 365.25));//la division permet de passer des secondes au années.
			
			//si l'utilisateur a moins de 16 ans, on affiche une erreur.
			if ($age<=16){
				$error="* Veuillez avoir plus de 16 ans";
				$this->load->view('add',array("error"=>$error));
			}
			//si l'email est déjà enregistré, on affiche une erreur.
			if( $this->UserModel->findByEmail($this->input->post('email'))!=null){
				$error="* Email déjà éxistante";
				$this->load->view('add',array("error"=>$error));
			}
			
			// on crée ensuite un client de type "UserEntity" avec les informations de l'utilisateur et on l'ajoute a la base de donnée.
			else{
				$clients = $this->UserModel->findAll();
				$client = new UserEntity();
				$client->setClinom($this->input->post('nom'));
				$client->setCliPrenom($this->input->post('prenom'));
				$client->setCliDateDeNaissance($this->input->post('date'));
				$client->setEmail($this->input->post('email'));

				//le mot de passe est Haché pour plus de sécruité.
				$client->setClipassword(password_hash($this->input->post('password'), PASSWORD_DEFAULT));

				//l'id de l'utilisateur est généré de façon aléatoire pour plus de sécurité.
				$rand=random_int(1,999999999);

				//Si l'id existe déjà, un autre est calculé.
				while($this->UserModel->findById($rand)!=null){
					$rand=random_int(1,999999999);
				}
				$client->setCliId($rand);
				$client->setCompteVerifie("0");
				$client->setStatut("Client");
				$client = $this->UserModel->add($client);
				// une clé est crée et envoyé par mail au client pour vérifier son compte.
				$cle = random_int(100000,999999);
				
				//envoie du mail grâce a la bibliothèque "email"
				$from_email = "muscunivers.shop@gmail.com";
				$to_mail = $this->input->post('email');
				$this->load->library("email");
				$this->email->from($from_email);
				$this->email->to($to_mail);
				$this->email->subject("Clé de vérification compte Muscunivers");
				$this->email->message('
					<html>
					<body>
						<div align="center">
						<section>
							<img src="https://zupimages.net/up/23/01/vb91.png">
						</section>
							Bienvenue sur le site <h2>Muscunivers</h2> veuillez entrez la clé <br>
							ci dessous pour pouvoir valider votre compte et pouvoir passez aux achats. <br>
							<h1>'.$cle.'</h1> <br><br>
							<button style="border-radius:5%;">
								<a href="http://172.26.82.59/index.php/user/verification">Lien vers la page de confirmation</a>
							</button>
							<br>
							Merci, Muscunivers.
						</div>
						
					</body>
				</html>
				');
				
				//l'email a bien été envoyé, on crée alors les variables de session lié au compte
				if ($this->email->send()){
					$_SESSION['user']=array("prenom"=>$client->getCliPrenom(), "id"=>$client->getCliId(),"verif"=>$client->getCompteVerifie(),"Statut"=>$client->getStatut());
					//on crée une variable de session "clé" qui permettra de vérifier que la clé que le client rentrera dans la page "verification" est la même que la clé générée plus haut. 
					$_SESSION['cle']=$cle;
					redirect('user/verification');
					die();
				}
				else{
					redirect('error_mail');
					die();
				} 
				redirect('home');
				die();
			}
	}

		
	}
	
	//fonction qui vérifie si la clé rentré par le client est la meme que celle envoyé par mail
	//si oui, la colonne 'compte verifier' de la base de donnee passe a vrai 
	//sinon on affiche l'erreur 'La clé d'activation n'est pas la bonne'
	function verif_mail(){
		if (isset($_SESSION["user"])){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cle', 'cle','required|numeric');

			if ($this->form_validation->run() == FALSE){
				$error="* Veuillez saisir uniquement des chiffres";
				$this->load->view('verification_mail',array("error"=>$error));
			}
			else{
				if ($this->input->post('cle')== $_SESSION['cle']){
					$data=array('CompteVerifie'=>true);
					$this->db->set($data);
					$this->db->where('CliId', $_SESSION['user']['id']);
					$this->db->update('Client');
					$_SESSION['user']['verif']="1";
					redirect('home');
				}
				else{
					$error="* La clé d'activation n'est pas la bonne";
					$this->load->view('verification_mail',array("error"=>$error));
				}
			}
		}
		else{
			redirect('home');
		}
	}


	//envoie un mail au client si celui ci veut changer d'adresse mail
	//on envoie le mail a l'adresse mail renseigné par le client sur la page 'nouveau_mail'
	//le client est ensuite redirigé vers la page de vérification 
	//si le mail ne s'est pas bien envoyé, on redirige sur la page 'error_mail'
	function nouveau_mail(){
		if (isset($_SESSION["user"])){
			$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email','required|valid_email|max_length[63]');

		if ($this->form_validation->run() == FALSE){
			$error="* Veuillez renseigner une adresse mail valide <br>et de moins de 64 caractères";
			$this->load->view('nouveauMail',array("error"=>$error));
		} else if($this->UserModel->findByEmail($this->input->post('email'))!=null){
			$error="* adresse mail déjà existante";
			$this->load->view('nouveauMail',array("error"=>$error));		
		}else{
			$id=$_SESSION['user']['id'];
			$client=$this->UserModel->findById($id);
			$client->setEmail($this->input->post('email'));
			$cle = random_int(100000,999999);

			$from_email = "muscunivers.shop@gmail.com";
			$to_mail = $this->input->post('email');;
			$this->load->library("email");
			$this->email->from($from_email);
			$this->email->to($to_mail);
			$this->email->subject("changement de mail Muscunivers");
			$this->email->message('
			<html>
			<body>
				<div align="center">
				<section>
					<img src="https://zupimages.net/up/23/01/vb91.png">
				</section>
					Bienvenue sur le site <h2>Muscunivers</h2> veuillez entrez la clé <br>
					ci dessous pour pouvoir valider votre compte et pouvoir passez aux achats. <br>
					<h1>'.$cle.'</h1> <br><br>
					<button style="border-radius:5%;">
						<a href="http://172.26.82.59/index.php/user/verification">Lien vers la page de confirmation</a>
					</button>
					<br>
					Merci, Muscunivers.
				</div>
				
			</body>
			</html>
				');
				
				//Si l'email a bien été envoyé enregistre le nouveau mail dans la bd.
				if ($this->email->send()){
					$_SESSION['cle']=$cle;
					$client->setEmail($this->input->post('email'));
					$client->setCompteVerifie(0);
					$_SESSION['user']['verif']="0";
					$client=$this->UserModel->modification_Client($id,$client);
					redirect('user/verification');
					die();
				}
				else{
					redirect('error_mail');
					die();
				} 
		}
		}else{
			redirect("home");
		}			
	}

	//envoie un mail pour que le client change de mot de passe
	//on envoie a l'adresse mail renseigné sur la page 'mp_oublie'
	//on envoie le lien pour changer de mot de passe dans le mail
	//et on redirige sur la page 'envoie_mail_mp'
	//si le mail ne s'est pas bien envoyé, on redirige sur la page 'error_mail'
	function mail_mp(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('login','Login','required|valid_email|max_length[63]');

		if ($this->form_validation->run() == FALSE){
			$error="* Veuillez renseigner une adresse mail valide <br>et de moins de 64 caractères";
			$this->load->view('mp_oublie',array("error"=>$error));
		}
		else{
			$email=$this->input->post('login');
			if ($this->UserModel->findByEmail($email)){
			$client=$this->UserModel->findByEmail($email);
			$id=$client->getCliId();
			//On génère une clé qui permettra de vérifier que la personne qui clique sur le lien du mail, est la même que celle qui veut changer son mot de passe.
			$cle = random_int(1000000000,9999999999);
			//On hache ensuite la clé pour plus de sécurité
			//et on remplace les "$" par des espace pour qu'on puisse ajouter la variable dans le lien.
			$cle = str_replace('$','',password_hash($cle, PASSWORD_DEFAULT));
			$cle = str_replace('/','',$cle);
			//On initialise ensuite la variable de session "modifMp" avec la clé crée et le mail de l'utilisateur.
			$_SESSION['modifMp']=array("cle"=>$cle,"mail"=>$email);

			$from_email = "muscunivers.shop@gmail.com";
			$to_mail = $email;
			$this->load->library("email");
			$this->email->from($from_email);
			$this->email->to($to_mail);
			$this->email->subject("muscunivers changement de mot de passe");
			$this->email->message('
			<body>
				<div align="center">
				<section>
					<img src="https://zupimages.net/up/23/01/vb91.png">
				</section>
					Bienvenue sur le site <h2>Muscunivers</h2> veuillez cliquer <br>
					ci dessous pour pouvoir changer votre mot de passe <br>
					<br><br>
					<button style="border-radius:5%;">
						<a href="http://172.26.82.59/index.php/user/verif_mpoublie/'.$cle.'">Lien vers la page</a>
					</button>
					<br>
					Merci, Muscunivers.
					<br>
				<br>
					si le lien ne fonctipnne plus, veillez réitérer la demande
				</div>				
			</body>
			</html>
				');
				
				if ($this->email->send()){
					redirect('user/messageEnvoye_redirection/2');
					
					die();
				}
				else{
					redirect('error_mail');
					die();
				}
			}
			else {
				redirect('user/add');
			}
		}		
	}
	//fonction qui vérifie si la clé envoyer par l'url est la même que celle dans la varaible de session.
	function verif_mpoublie($cle){
		if (isset($_SESSION['modifMp'])){
			if ($cle == $_SESSION['modifMp']["cle"] ){
				$client=$this->UserModel->findByEmail($_SESSION['modifMp']["mail"]);
				$_SESSION['user']=array("prenom"=>$client->getCliPrenom(), "id"=>$client->getCliId(),"verif"=>$client->getCompteVerifie(),"Statut"=>$client->getStatut());
				$_SESSION['panier']=array();
				redirect('user/nouveauMotDePasse_redirection');
			}
		}
		redirect('home');
	}


	//fonction qui renvoie le mail quand le client clique sur le bouton 'renoyer le mail' de la page 'verification_mail'
	function renvoie_mail(){
			if (isset($_SESSION["user"])){
				if (isset($_COOKIE["cooldown"])){
					$this->load->view("verification_mail");
				}else{
					$id=$_SESSION['user']['id'];
					$client=$this->UserModel->findById($id);
					$cle = random_int(100000,999999);

					$from_email = "muscunivers.shop@gmail.com";
					$to_mail = $client->getEmail();
					$this->load->library("email");
					$this->email->from($from_email);
					$this->email->to($to_mail);
					$this->email->subject("muscunivers_renvoie_mail");
					$this->email->message('
					<html>
					<body>
						<div align="center">
						<section>
							<img src="https://zupimages.net/up/23/01/vb91.png">
						</section>
							Bienvenue sur le site <h2>Muscunivers</h2> veuillez entrez la clé <br>
							ci dessous pour pouvoir valider votre compte et pouvoir passez aux achats. <br>
							<h1>'.$cle.'</h1> <br><br>
							<button style="border-radius:5%;">
								<a href="http://172.26.82.59/index.php/user/verification">Lien vers la page de confirmation</a>
							</button>
							<br>
							Merci, Muscunivers.
						</div>
						
					</body>
					</html>
						');
					if ($this->email->send()){
						$this->session->set_userdata("cle",$cle);
						setcookie("cooldown","cooldown",time()+300);
						$this->load->view("verification_mail",array("alerte"=>""));
					}else{
						redirect('error_mail');
						die();
					}
				}
			}else{
				redirect('home');
		}
	}


	// Fonction qui redirige vers plusieurs page en fonction de l'id renseigné.
	function apropos(int $id) {
		if ($id==1){
			$this->load->view('nousconnaitre');
		} elseif ($id==2) {
			$this->load->view('nouscontacter');
		} elseif ($id==3) {
			$this->load->view('faq');
		}else {
			redirect("home/apropos");
		}
	}

	// Fonction qui nous envoie un mail à nous avec les informations
	// que le User à remplit dans le form "nouscontacter".
	function nousContacter(){
		$titre=$this->input->post('titre');
		$prenomNom=$this->input->post('prenomNom');
		$adresse=$this->input->post('mail');
		$contenu=$this->input->post('contenu');
		$genre=$this->input->post('genre');

		$from_email = "muscunivers.shop@gmail.com";
		$to_mail = "muscunivers.shop@gmail.com";
		$this->load->library("email");
		$this->email->from($from_email);
		$this->email->to($to_mail);
		$this->email->subject($titre);
		$this->email->message('
		<html>
		<body>
			<div align="center">
			<section>
				<img src="https://zupimages.net/up/23/01/vb91.png">
			</section>
				'.$genre.' '.$prenomNom.' vous a contacté,<br>
				objet : '.$titre.'<br>
				adresse mail du client :<br>
				'.$adresse.'
				Message : <br>
				'.$contenu.' <br>
				<br>
				Merci, Muscunivers.
			</div>
			
		</body>
		</html>
			');
			// Si le mail a bien été envoyé renvoye sur page confirmation.
			// Sinon renvoye sur error_mail.
			if ($this->email->send()){
				redirect('user/messageEnvoye_redirection/1');
				die();
			}
			else{
				redirect('error_mail');
				die();
			} 
	}



	/* ****************
		PANIER CLIENT
	**************** */

	// Fonction qui récupère tous les Id contenue dans la variable de session panier,
	// et charge tous les produits depuis la BD et charge la view cart en lui donnant 
	// l'array de produits chargés.
	function cart(){
		$products=array();
		if (isset($_SESSION['panier'])) {
			foreach ( $_SESSION['panier'] as $product) :
				$prod=$this->ProductModel->findByID($product['id']);
				if ( $prod!=null) {
					$products[]=$prod;
				} else {
					$_SESSION['panier']=array_diff($_SESSION['panier'],$product);
				}
			endforeach;
		}
		$this->load->view('cart',array('products'=>$products));
	}

	// Fonction qui ajoute un produit au panier,
	// Si la quantité du produit est supérieur à 0,
	// Et que la quantite dans le panier est inférieur
	// A la quantité disponible.
	function panier(int $id,int $qtd) {
		if ($this->ProductModel->findByID($id)!=null) {
			if($qtd>0) {
				if (!isset($_SESSION['panier'])) {
					$_SESSION['panier']=array();
				}
				$i=0;
				foreach ($_SESSION['panier'] as $product) {
					if ($product['id'] == $id) {
						if ( $_SESSION['panier'][$i]['qtd']<$qtd){
							$_SESSION['panier'][$i]['qtd']+=1;
						}
						redirect("user/cart");
					}
					$i=$i+1;
				}
				array_unshift($_SESSION['panier'],array("id"=>$id,"qtd"=>1));
				redirect("user/cart");
			}
		}
		redirect("user/cart");
	}

	// Fonction qui modifie la quantite stocké,
	// Dans la variable de session panier associé à l'Id.
	// En fonction du Post récupéré.
	function modifcookie(int $id) {
		if(isset($_POST['quantite'])) {
			if ($_POST['quantite']==null || $_POST['quantite']<0) {
				redirect("user/cart");
			}
			$i=0;
			foreach ($_SESSION['panier'] as $product) {
				if ($product['id'] == $id) {
					$_SESSION['panier'][$i]['qtd']=$_POST['quantite'];
					break;
				}
				$i+=1;
			}
		}
		redirect("user/cart");
	}

	// Fonction qui supprime le produit associé à l'Id,
	// Dans la variable de session Panier.
	function delete(int $id) {
		$temp= array();
		foreach ($_SESSION['panier'] as $product) {
			if ($product['id'] != $id) {
				$temp[]=$product;
			}
		}
		$_SESSION['panier']=$temp;
		redirect("user/cart");
	}

	// Fonction qui ré-initialise la variable de session Panier.
	function delete_all(){
		$_SESSION['panier']=array();
		redirect("user/cart");
	}

	// Fonction qui vérifie le panier et redirige si il y a un panier actif,
	// Qu'il y a un User de connecter et qu'il ai vérifé son compte.
	// Et charge les produits valide dans une variable $products et 
	// Mets les cookies associés dans la variable de session panier_achat
	// Et charge la page Commander avec la variable $products.
	function commander(){
		if (isset($_SESSION['panier'])) {
			if ($_SESSION['panier']!=array()){
				if (isset($_SESSION['user'])){
					if($_SESSION['user']['verif']){
						$products=array();
						$_SESSION['panier_achat']=array();
						foreach ( $_SESSION['panier'] as $product) :
							$produc=$this->ProductModel->findByID($product['id']);
							if ( $produc!=null && $produc->getStock()>0 && $product['qtd']>0) {
								$products[]=$produc;
								$_SESSION['panier_achat'][]=$product;
							}else if ($produc==null) {
								$_SESSION['panier']=array_diff($_SESSION['panier'],$product);
							}
						endforeach;
						if ($products==array()) {
							redirect("user/cart");
						}
						$this->load->view('Commander',array('products'=>$products));
					}else{
						redirect('user/verification');
					}
				}else{
					redirect('user/login');
				}
			}else{
				redirect('user/cart');
			}
		} else {
			redirect('user/cart');
		}
	}

	// Regarde si il y a une variable de session panier_achat, vérifie si les résultat du form sont satisfaisant,
	// Mets la DB en Trans_Start, vérifie si il y à assez de stock dans la BD pour commander,
	// Création de la commande, ajout des produits à la commande,
	// Envoie du email de confirmation de commande, mise a jour de la variable de session panier, unset de la variable de session panier_achat
	// Mets la DB en Trans_Complete(Envoie des modifications) et redirige vers la page messageEnvoye.
	function valider_commande() {
		if ( isset($_SESSION['panier_achat'])) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('Adresse', 'Adresse','required|max_length[50]');
			$this->form_validation->set_rules('Ville', 'Ville','required|max_length[30]');
			$this->form_validation->set_rules('Commune', 'Commune','required|max_length[30]');
			$this->form_validation->set_rules('Pays', 'Pays','required|max_length[30]');
			
			if ($this->form_validation->run() == FALSE){
				// Charge les produits pour la page cart et une erreur
				$error="* Veuillez remplir tout les champs";
				$products=array();
				$_SESSION['panier_achat']=array();
				foreach ( $_SESSION['panier'] as $product) :
					$produc=$this->ProductModel->findByID($product['id']);
					if ( $produc!=null && $produc->getStock()>0 && $product['qtd']>0) {
						$products[]=$produc;
						$_SESSION['panier_achat'][]=$product;
					}else if ($produc==null) {
						$_SESSION['panier']=array_diff($_SESSION['panier'],$product);
					}
				endforeach;
				$this->load->view('Commander',array('products'=>$products,'error'=>$error));
			}else{
				$this->db->trans_start();
				$procedure = New ProductModel;
				$bool=$procedure->commande($_SESSION['panier_achat']);
				if ( !$bool) {
					$products=array();
					if (isset($_SESSION['panier'])) {
						foreach ( $_SESSION['panier'] as $product) :
						$prod=$this->ProductModel->findByID($product['id']);
						if ( $prod!=null) {
							$products[]=$prod;
						} else {
							$_SESSION['panier']=array_diff($_SESSION['panier'],$product);
						}
					endforeach;
					}
					$this->load->view("cart",array("products"=>$products,"error"=>"Problème lors de la commande veuillez réessayer. Vérifier votre panier !"));
				} else {

				$client=$this->UserModel->findById($_SESSION['user']['id']);

				$adresse1=$this->input->post('Adresse');
                $ville=$this->input->post('Ville');
                $Code=$this->input->post('Commune');
                $Pays=$this->input->post('Pays');

                $adresse=''.$adresse1.',  '.$ville.',  '.$Code.',  '.$Pays.'';
				$adresse=strtoupper($adresse);

				
				$procedure2 = New OrderModel;
				$procedure3= New OrderProductModel;
				$commande=$procedure2->createCommande($client->getCliId(),$adresse);
				$procedure3->remplirCommande($commande->getCmdId());

				$from_email = "muscunivers.shop@gmail.com";
				$to_mail = $client->getEmail();
				$this->load->library("email");
				$this->email->from($from_email);
				$this->email->to($to_mail);
				$this->email->subject("Commande Muscunivers n°".$commande->getCmdId()."");
				$this->email->message('
				<html>
				<body>
					<div align="center">
					<section>
						<img src="https://zupimages.net/up/23/01/vb91.png">
					</section>
						Merci <h3>'.$client->getCliPrenom().'</h3> De la confiance que vous nous accorder.<br>
						Ci dessous vous pouvez voir le récapitulatif de votre commande passez chez nous. <br>
						La commande arrivera sous 2 semaine ouvrable. <br>
						<h1> Commande n°'.$commande->getCmdId().'</h1> <br>
						Nom :'.$client->getCliNom().'<br>
						Prenom :'.$client->getCliPrenom().'<br>
						Adresse :'.$adresse.'<br>
						Prix :'.$_POST['prix'].'.00€<br>
						Nombre articles :'.$_POST['quantite'].'<br><br>
						<br>
						Merci, Muscunivers.
					</div>
					
				</body>
				</html>
				');

				if ($this->email->send()){
					$newpanier=array();
					foreach ($_SESSION['panier'] as $product) {
						if ( in_array($product,$_SESSION['panier_achat'])) {
						} else {
							$newpanier[]=$product;
						}
					}
					$_SESSION['panier']=$newpanier;
					unset($_SESSION['panier_achat']);
					$this->db->trans_complete();
					redirect('user/messageEnvoye_redirection/3');
				}else{
					redirect('error_mail');
				}
			}
		}
		} else {
			// Charge les produits pour la page cart et une erreur
			$products=array();
			if (isset($_SESSION['panier'])) {
				foreach ( $_SESSION['panier'] as $product) :
					$prod=$this->ProductModel->findByID($product['id']);
					if ( $prod!=null) {
						$products[]=$prod;
					} else {
						$_SESSION['panier']=array_diff($_SESSION['panier'],$product);
					}
				endforeach;
			}
			$this->load->view("cart",array("products"=>$products,"error"=>"Problème lors de la commande veuillez réessayer. Vérifier votre panier !"));
		}
	}
}
?>