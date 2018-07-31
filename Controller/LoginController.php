<?php /*by gabriel.perez@helloprint.com*/
//comments on Controller\Controller
namespace Controller;
use Model\Users;

class LoginController extends Controller{

	public $views = 'login';

	function __construct(){
		$this->entity = new Users;
		empty($_POST) && empty($_SESSION['dutch']) ? $this->login() : $this->post() ;
		self::activeUser() or exit;}

	//login, logout, login error
	protected function post(){
		if(empty($_SESSION['dutch']) && !empty($_POST['login'])){
			is_bool($user = $this->entity->login($_POST['username'], $_POST['password'])) ? $this->login('Bad login') : $this->session($user) ;}
		elseif(!empty($_POST['logout'])){
			unset($_SESSION['dutch']);
			header('location: ./');}}

	//display login form
	protected function login($loginError = ''){
		$this->export['loginError'] = $loginError;
		$this->render('login');}

	//create session, reset $_POST and reload
	protected function session($user){
		list($_SESSION['dutch'], $_POST) = [$user, []];
		header('location: ./');}

	//validate session
	public static function activeUser(){
		return empty($_SESSION['dutch']) ? false : $_SESSION['dutch'] ;}}
