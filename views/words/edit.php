<div class="wrapper">
<a href="./?section=Words&page=<?=$_GET['page']?>"><button class="btn btn-primary">Back to list</button></a><br /><br />

<div id="newTag">
<div>
	<select class="form-control" name="new_tag[]">
		<?=static::options($tags); ?>
	</select>
	<span class="btn btn-danger btn-xs">-</span>
	<input name="new_id[]" value="0" type="hidden" />
</div>
</div>

<form method="post">
<table class="table">
<tr><th>ID</th><td><input class="form-control" disabled="1" value="<?=$word['id'];?>"></td></tr>
<tr><th>Dutch</th><td><input class="form-control" name="dutch" value="<?=$word['dutch']?>" /></td></tr>
<tr><th>English</th><td><input class="form-control" name="english" value="<?=$word['english']?>" /></td></tr>
<tr><th rowspan=2>Tags</th><td>Add a tag <span type="button" class="btn btn-success btn-xs" id="plus">+</span></td></tr>
<tr><td id="tags">
<?php while(list($k, $tag) = each($word['tags'])){ ?>
<div>
	<select class="form-control" name="tags[]">
		<?=static::options($tags, $tag['tag']); ?>
	</select>
	<span class="btn btn-danger btn-xs">-</span>
	<input name="ids[]" value="<?=$tag['id']?>" type="hidden" />
</div>
<?php } ?>
</td></tr>
<tr><th colspan="2"><input type="hidden" name="toDelete" id="toDelete" /><button class="btn btn-info">Submit</button></th></tr>
</table>
</form>
<br />
<form method=post><button name="deleteAll" class="btn btn-danger" value="1">DELETE</button></form>
</div>
