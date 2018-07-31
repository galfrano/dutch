<?php /*by gabriel.perez@helloprint.com*/
//comments on Controller\Controller
namespace Controller;
use Model\Tags;
use Model\Words;

class TestController extends Controller{

	public $views = 'test';

	function __construct(){
		empty($_POST) ?: $this->post();
		empty($_SESSION['test']) ? $this->setTest() : $this->test();}

	protected function setTest(){
		$this->export['tags'] = (new Tags)->catalog();
		$this->export['numbers'] = [5=>5, 10=>10, 15=>15, 20=>20, 'a'=>'All'];
		$this->export['from'] = ['en'=>'English to Dutch', 'nl'=>'Nederlands naar Engels'];
		$this->render('set');}

	//get words for test, reset session
	protected function post(){
		if(!empty($_POST['number']) && !empty($_POST['tags']) && !empty($_POST['from'])){
			$_SESSION['test']['words'] = (new Words)->getTaggedWords($_POST['tags'], $_POST['number']);
			$_SESSION['test']['from'] = $_POST['from'];}
		elseif(!empty($_POST['reset'])){
			unset($_SESSION['test']);}}

	protected function test(){
		$this->export = $_SESSION['test']['from'] == 'nl' ? ['show'=>'dutch', 'hide'=>'english'] : ['show'=>'english', 'hide'=>'dutch'];
		$this->export['words'] = $_SESSION['test']['words'] ;

		$this->render('test');}}
