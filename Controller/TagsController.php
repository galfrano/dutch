<?php /*by gabriel.perez@helloprint.com*/
//comments on Controller\Controller & Controller\CrudController
namespace Controller;
use Model\Tags;

class TagsController extends CrudController{

	public $views = 'tags';

	function __construct(){
		$this->entity = new Tags;
		parent::__construct();}

	protected function add(){
		//$this->export = ['categories'=>$this->entity->catalog(), 'languages'=>$this->entity->languages(), 'category'=>['id_chili_categories'=>'To be created', 'parent_category_id'=>0], 'names'=>[]];
		$this->export = ['tag'=>['id'=>'To be created', 'name'=>'', 'color'=>'']];
		$this->render('edit');}

	protected function edit($id){
		$this->export = $this->entity->get($id);
		$this->render('edit');}}
