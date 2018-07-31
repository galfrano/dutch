<?php /*by gabriel.perez@helloprint.com*/
//extending from Entity for homologation only. for now, CRUD functionality not required
namespace Model;

class Users extends Entity{

	protected static $tableName = 'users';

	function getList($offset, $lines, $filters = []){
		}

	function get($id){
		}

	function delete($id){
		}

	function add($post){
		}

	function edit($post, $id){
		}

	//returns names only if credentials match
	function login($email, $password){
		$user = $this->db->query('select name from users where email=? and password=?', [$email, $password])->fetchAll();
		return count($user) ? current($user) : false ;}}
