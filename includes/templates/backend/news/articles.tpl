{include file='common/header.tpl'}

<div class="well">
	<div class="navbar">
		<div class="navbar-inner">
			<h5>News Articles</h5>
		</div>
	</div>
	<ul class="toolbar">
		<li>
			<a title="" href="{$url}news/article.php"><i class="font-plus"></i><span>New Article</span></a>
		</li>
	</ul>
	<div class="table-overflow">
		<table class="table table-striped" id="data-table">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Category</th>
					<th>Created</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$articles item=article}
					<tr{if (!$article->display)} class="error"{/if}>
						<td>{$article->id}</td>
						<td><a href="{$url}news/article.php?id={$article->id}">{$article->title}</a></td>
						<td>{$article->categoryId}</td>
						<td>{$article->created}</td>
						<td>
							<ul class="table-controls">
								<li>
									<a class="btn hovertip" href="{$url}news/article.php?id={$article->id}" data-original-title="Edit entry"><i class="icon-pencil"></i></a>
								</li>
								<li>
									<a class="btn hovertip" href="{$url}news/article.php?id={$article->id}&action=delete" data-original-title="Delete entry"><i class="icon-remove"></i></a>
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