<?php /*by gabriel.perez@helloprint.com*/

namespace Controller;

abstract class Controller{

	//handles $_POST. called from parent::__construct()
	protected abstract function post();

	const DS = DIRECTORY_SEPARATOR;

	protected $entity, $views, $export = [];

	//throw exception
	protected static function kill($message){
		throw new \Exception($message);}

	//inject variables to template and display it
	protected function render($view){
		extract($this->export);
		$title = str_replace(['Controller', '\\'], '', get_class($this));
		$menuView = __DIR__.self::DS.'..'.self::DS.'views'.self::DS.'menu.php';
		$userSession = LoginController::activeUser();
		$view = __DIR__.self::DS.'..'.self::DS.'views'.self::DS.(empty($this->views)?'':$this->views.self::DS).$view.'.php';
		include(__DIR__.self::DS.'..'.self::DS.'views'.self::DS.'html.php');}

	//print options from array
	static function options($array, $pre = null){
		for(reset($array), $op = '<option></option>'."\n"; list($value, $display) = each($array); $op .= '<option value="'.$value.'"'.($pre == $value ? ' selected=1' : '').'>'.$display.'</option>'."\n");
		return $op;}}
