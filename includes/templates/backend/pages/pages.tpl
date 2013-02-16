{include file='common/header.tpl'}

<div class="well">
	<div class="navbar">
		<div class="navbar-inner">
			<h5>Pages</h5>
		</div>
	</div>
	<ul class="toolbar">
		<li>
			<a title="" href="{$url}pages/page.php"><i class="font-plus"></i><span>New Page</span></a>
		</li>
	</ul>
	<div class="table-overflow">
		<table class="table table-striped" id="data-table">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Slug</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$pages item=page}
					<tr{if (!$page->display)} class="error"{/if}>
						<td>{$page->id}</td>
						<td><a href="{$url}pages/page.php?id={$page->id}">{$page->title}</a></td>
						<td>{$page->slug}</td>
						<td>
							<ul class="table-controls">
								<li>
									<a class="btn hovertip" href="{$url}pages/page.php?id={$page->id}" data-original-title="Edit entry"><i class="icon-pencil"></i></a>
								</li>
								<li>
									<a class="btn hovertip" href="{$url}pages/page.php?id={$page->id}&action=delete" data-original-title="Delete entry"><i class="icon-remove"></i></a>
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