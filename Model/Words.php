<?php /*by gabriel.perez@helloprint.com*/
//more comments on Model\Entity
namespace Model;

class Words extends Entity{

	protected static $tableName = 'wordlist', $pk = 'id',  $allowedFilters = ['english'=>'fstring', 'dutch'=>'fstring', 'tags'=>'fstring'];

	function get($id){
		$word = $this->db->query('select * from words where id=?', [$id])->fetchAll();
		count($word) or self::kill('No word with id '.$id);
		return current($word)+['tags'=>$this->db->query('select * from word_tags where word=?', [$id])->fetchAll()];}

	function getTaggedWords($tags, $number){
		$limit = (int)$number ? 'limit '.$number : '' ;
		return $this->db->query('select * from words where id in (select word from word_tags where tag in('.substr(str_repeat('?, ', count($tags)), 0, -2).')) order by rand() '.$limit, $tags)->fetchAll();}

	function addTags($id, $post){
		if(!empty($post['new_tag'])){
			for($this->db->query('insert into word_tags (word, tag) values (?, ?)', false); list($k, $v) = each($post['new_tag']); $this->db->execute([$id, $post['new_tag'][$k]]));}
		return $this;}

	function delete($id){
		$this->db->query('delete from words where id=?', [$id]);}

	function add($post){
		$id = $this->db->query('insert into words (english, dutch) values (?, ?)', [$post['english'], $post['dutch']])->id();
		$this->addTags($id, $post);}

	function edit($post, $id){
		if(!empty($post['toDelete']) && count($toDelete = explode(',', $post['toDelete']))){
			for($this->db->query('delete from word_tags where id=?', false); list($k, $v) = each($toDelete); $this->db->execute([$v]));}
		$this->db->query('update words set english=?, dutch=? where id=?', [$post['english'], $post['dutch'], $id]);
		$this->db->query('update word_tags set word=?, tag=? where id=?', false);
		while(list($k, $v) = each($post['tags'])){
			$this->db->execute([$id, $post['tags'][$k], $post['ids'][$k]]);}
		$this->addTags($id, $post);}}
