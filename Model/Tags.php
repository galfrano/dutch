<?php /*by gabriel.perez@helloprint.com*/
//more comments on Model\Entity
namespace Model;

class Tags extends Entity{

	protected static $tableName = 'tags';

	function getList($offset, $lines, $filters = []){
		return $this->db->query('select * from tags limit '.$offset.', '.$lines, [1, 1])->fetchAll();}

	function get($id){
		$category = $this->db->query('select * from tags where id=?', [$id])->fetchAll();
		count($category) or self::kill('No tag with id '.$id);
		return ['tag'=>current($category)];}

	function catalog(){
		return $this->db->query('select * from tags')->fetchAll(function($line){
			return [$line['id']=>$line['name']];});}

	function delete($id){
		$this->db->query('delete from tags where id=?', [$id]);}

	function add($post){
		$this->db->query('insert into tags (name, color) values (?, ?)', [$post['name'], $post['color']])->id();}

	function edit($post, $id){
		$this->db->query('update tags set name=?, color=? where id=?', [$post['name'], $post['color'], $id]);}}
