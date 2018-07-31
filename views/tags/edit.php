<div class="wrapper">
<a href="./?section=Tags&page=<?=$_GET['page']?>"><button class="btn btn-primary">Back to list</button></a><br /><br />

<form method="post">
<table class="table">
<tr><th>ID</th><td><input class="form-control" disabled="1" value="<?=$tag['id'];?>"></td></tr>
<tr><th>Name</th><td><input class="form-control" name="name" value="<?=$tag['name']?>" /></td></tr>
<tr><th>Color</th><td><input class="form-control" name="color" value="<?=$tag['color']?>" /></td></tr>
<tr><th colspan="2"><button class="btn btn-info">Submit</button></th></tr>
</table>
</form>
<br />
<form method=post><button name="deleteAll" class="btn btn-danger" value="1">DELETE</button></form>
</div>
