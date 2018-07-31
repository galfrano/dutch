<?php /*by gabriel.perez@helloprint.com*/

namespace Controller;

abstract class CrudController extends Controller{

	//fetches needed catalogs, shows form to add.
	protected abstract function add();
	//fetches item to edit, shows form.
	protected abstract function edit($id);

	const DS = DIRECTORY_SEPARATOR;

	protected $rpp = 15;

	//controller routing. extending class should set $this->entity before calling parent::__construct() 
	function __construct(){
		!empty($this->entity) or self::kill('Initialize entity first');
		if($_POST){
			$this->post();}
		elseif(key_exists('edit', $_GET)){
			$_GET['edit'] == 0 ? $this->add() : $this->edit($_GET['edit']) ;}
		else{
			$this->page(!empty($_GET['page']) ? $_GET['page'] : 1);}}

	protected function section(){
		return str_replace(['Controller', '\\'], '', get_class($this));}

	//fetch items and show list
	protected function page($page){
		$filter = empty($_GET['search']) ? [] : json_decode(base64_decode($_GET['search']), 1);
		$this->export['searchFields'] = $this->searchFields();
		$this->export['pages'] = ceil($this->entity->pages($filter)/$this->rpp);
		$this->export['page'] = $page>0 ? $page : $this->export['pages'];
		$this->export['entities'] = $this->entity->getList(($this->export['page']*$this->rpp-$this->rpp), $this->rpp, $filter);
		$this->render('list');}

	//handle post (CUD) and redirect
	protected function post(){
		if(!empty($_POST['search'])){
			header('location: ./?section='.$this->section().'&search='.(base64_encode(json_encode($_POST))));}
		elseif(!empty($_POST['deleteAll'])){
			$this->entity->delete($_GET['edit']);
			header('location: ./?section='.$this->section().'&page='.$_GET['page']);}
		elseif($_GET['edit'] == 0){
			$id = $this->entity->add($_POST);
			header('location: ./?section='.$this->section().'&page=-1');}
		else{
			$this->entity->edit($_POST, $_GET['edit']);
			header('location: ./?section='.$this->section().'&page='.$_GET['page']);}}

	protected function searchFields(){
		$allowed = $this->entity->allowedFilters();
		for($html = ''; list($col, $type) = each($allowed); $html .= "\t\t\t\t\t".ucwords(str_replace('_', ' ', $col)).': '.$this->$type($col));
		return $html;}

	protected function fstring($col){
		return '<input class="form-control" name="'.$col.'" />'."\n";}

	protected function farray($col){
		return '<select class="form-control" name="'.$col.'[]" multiple=1>'.substr(self::options($this->entity->catalog($col)), 17).'</select>';}

	protected function fint($col){
		return '<input class="int-input form-control" name="'.$col.'" />'."\n";}

	//print pages TODO: include controller picker
	static function pager($page, $pages){
		for($get = ''; list($k, $v) = each($_GET); $k == 'page' ?: $get .= $k.'='.$v.'&');
//$p = $page>10 ? $page-11 : 0 , $pages = $page+10 <= $pages ? $page+10 : $pages ;
		for($p = $page>10 ? $page-11 : 0 , $pages = $page+10 <= $pages ? $page+10 : $pages ; $p++ < $pages; print'<a href="?'.$get.'page='.$p.'" class="btn btn-xs '.($page == $p ? 'btn-default active' : 'btn-primary').'">'.$p.'</a>');}}
