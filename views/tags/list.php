		<div class="wrapper">
			<a href="?section=Tags&edit=0&page=<?=$page?>"><button class="btn btn-success">New</button></a><br /><br />
			<table class="table table-striped">
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Color</th>
					<th>Edit</th>
				</tr><?php while(list($k, $tag) = each($entities)){ ?>
				<tr>
					<td><?=$tag['id']?></td>
					<td><?=$tag['name']?></td>
					<td><div class="tag-color" style="background-color:<?=$tag['color']?>; padding:10px;"></div></td>
					<td><a href="?section=Tags&page=<?=$page?>&edit=<?=$tag['id']?>"><button class="btn btn-info btn-xs">click</button></a></td>
				</tr>
<?php ;} ?>			</table>
			<div class="pager"><?php static::pager($page, $pages)?></div>
		</div>

