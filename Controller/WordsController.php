<?php /*by gabriel.perez@helloprint.com*/
//comments on Controller\Controller & Controller\CrudController
namespace Controller;
use Model\Words;
use Model\Tags;

class WordsController extends CrudController{

	public $views = 'words';

	function __construct(){
		$this->entity = new Words;
		parent::__construct();}

	protected function add(){
		$this->export = ['tags'=>(new Tags)->catalog(true), 'word'=>['id'=>'To be created', 'english'=>'', 'dutch'=>'', 'tags'=>[]]];
		$this->render('edit');}

	protected function edit($id){
		$this->export = ['word'=>$this->entity->get($id)]+['tags'=>(new Tags)->catalog()];
		$this->render('edit');}

	protected function page($p){
		$this->export['class'] = function($color){
			$dec = hexdec($color[1].$color[2])+hexdec($color[3].$color[4])+hexdec($color[5].$color[6]);
			return $dec < 450 ? 'tagI '.$dec : 'tagII '.$dec ;};
		return parent::page($p);}}
