<div class="wrapper">
<form method="post">
<table class="table">
<tr><th>Tag(s): </th><td><select class="form-control" name="tags[]" multiple=1><?=substr(self::options($tags), 17)?></select></td></tr>
<tr><th>Number of words: </th><td><select class="form-control" name="number"><?=self::options($numbers)?></select></td></tr>
<tr><th>From: </th><td><select class="form-control" name="from"><?=self::options($from)?></select></td></tr>
<tr><th colspan="2"><button class="btn btn-success">Start Test</button></th></tr>
</table>
</form>
<br />

</div>
