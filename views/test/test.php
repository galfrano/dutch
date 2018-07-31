<div class="wrapper"><ol id="dutch-test">
<?php while(list($k, $word) = each($words)){ ?>
<li><span><?=$word[$show]?></span><input /> <button class="btn btn-xs btn-info" value="<?=$word[$hide]?>">check</button></li>
<?php } ?>
</ol>
<form method=post>
<button class="btn btn-danger" name="reset" value="1">Start another test</button>
</form>
</div>
