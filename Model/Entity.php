<?php /*by gabriel.perez@helloprint.com*/

namespace Model;

abstract class Entity{

	protected $db, $tokens, $languages = false;
	protected static $tableName, $pk, $columns = '*', $allowedFilters = [];

	//fetch specific entity to edit along with relations
	abstract function get($id);
	//insert new data to db
	abstract function add($post);
	//update data to db, should also add/delete pertinent related lines
	abstract function edit($post, $id);
	//delete entity along with relations
	abstract function delete($id);

	//create db object
	function __construct(){
		$this->db = new Pdoh(_DB_USER_, new \PDO('mysql:host='._DB_SERVER_.';dbname='._DB_NAME_, _DB_USER_, _DB_PASSWD_));}

	//fetch list from database
	function getList($offset, $lines, $filters = []){
		list($where, $tokens) = $this->filter($filters);
		return $this->db->query(static::listQuery(static::$columns).$where.' order by '.static::$pk.' limit '.$offset.', '.$lines, $tokens)->fetchAll();}

	//return number of pages
	function pages($filter = []){
		list($where, $tokens) = $this->filter($filter) ;
		return current(current($this->db->query(static::listQuery('count(*)').$where, $tokens)->fetchAll()));}

	//language catalog - TODO: remove strpos
	function languages(){
		return $this->languages ?: ($this->languages = $this->db->query('select id_lang, name from ps_lang')->fetchAll(function($line){
			return [$line['id_lang']=>(strpos(__DIR__, 'www') ? $line['name'] : utf8_encode($line['name']))];}));}

	//TODO: correct this
	function allowedFilters(){
		return static::$allowedFilters;}

	protected static function listQuery($columns){
		return sprintf('select %s from %s', $columns, static::$tableName);}

	//builds where
	protected function filter($filters = []){
		for($w = $this->tokens = []; list($column, $value) = each($filters); !key_exists($column, static::$allowedFilters) || empty($value) ?/*self::kill('wtf'.var_export($column, 1))*/: $w[] = $this->{static::$allowedFilters[$column]}($column, $value));
		return count($w) ? [' WHERE '.implode(' AND ', $w), $this->tokens] : ['', []];}

	protected function fstring($column, $value){
		$this->tokens[] = '%'.$value.'%';
		return ' '.$column.' LIKE ?';}

	protected function fint($column, $value){
		$this->tokens[] = $value;
		return ' '.$column.'=?';}

	protected function farray($column, $values){
		$this->tokens = array_merge($this->tokens, $values);
		return ' '.$column.' IN ('.substr(str_repeat('?, ', count($values)), 0, -2).')';}

	//throw exception
	protected static function kill($message){
		throw new \Exception($message);}}
