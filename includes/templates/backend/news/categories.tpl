{include file='common/header.tpl'}

<div class="well">
	<div class="navbar">
		<div class="navbar-inner">
			<h5>News Categories</h5>
		</div>
	</div>
	<ul class="toolbar">
		<li>
			<a title="" href="{$url}news/category.php"><i class="font-plus"></i><span>New Category</span></a>
		</li>
	</ul>
	<div class="table-overflow">
		<table class="table table-striped" id="data-table">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$categories item=category}
					<tr{if (!$category->display)} class="error"{/if}>
						<td>{$category->id}</td>
						<td><a href="{$url}news/category.php?id={$category->id}">{$category->title}</a></td>
						<td>
							<ul class="table-controls">
								<li>
									<a class="btn hovertip" href="{$url}news/category.php?id={$category->id}" data-original-title="Edit entry"><i class="icon-pencil"></i></a>
								</li>
								<li>
									<a class="btn hovertip" href="{$url}news/category.php?id={$category->id}&action=delete" data-original-title="Delete entry"><i class="icon-remove"></i></a>
								</li>
							</ul>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
</div>

{include file='common/footer.tpl'}