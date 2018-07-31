<?php /*by gabriel.perez@helloprint.com*/
//TODO: move ajax to post
namespace Controller;
use Model\ChiliFolders;

class AjaxController extends Controller{

	function __construct(){
		in_array(($action = $_GET['action']), ['getSizeDirs']) or self::kill('Function '.var_export($action, 1).' not implemented.');
		$this->$action();}

	protected function post(){}

	protected function getSizeDirs(){
		static::options((new ChiliFolders)->sizeCatalog($_GET['product']));}}
