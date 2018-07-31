

		<div class="wrapper">
			<a href="?section=Words&edit=0&page=<?=$page?>"><button class="btn btn-success">New</button></a><br /><br />
			<div class="search">
				<form class="form-inline" method=post>
<?=$searchFields?>
					<button name="search" value="true" class="btn btn-info">Search</button>
				</form>
			</div>
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>English</th>
					<th>Dutch</th>
					<th>Tags</th>
					<th>Edit</th>
				</tr><?php while(list($k, $word) = each($entities)){ ?>
				<tr>
					<td><?=$word['id']?></td>
					<td><?=$word['english']?></td>
					<td><?=$word['dutch']?></td>
					<td><?php list($tags, $colors) = [explode(', ', $word['tags']), explode(', ', $word['colors'])];
						while(list($k, $tag) = each($tags)){ ?>
						<div class="<?=$class($colors[$k])?>" style="background-color:<?=$colors[$k]?>;" styff="<?=hexdec(str_replace('#', '', $colors[$k]))?>"><?=$tag?></div><?php } ?></td>
					<td><a href="?section=Words&page=<?=$page?>&edit=<?=$word['id']?>"><button class="btn btn-info btn-xs">click</button></a></td>
				</tr>
<?php ;} ?>			</table>
			<div class="pager"><?php static::pager($page, $pages)?></div>
		</div>
