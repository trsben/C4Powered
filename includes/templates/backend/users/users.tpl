{include file='common/header.tpl'}

<div class="well">
	<div class="navbar">
		<div class="navbar-inner">
			<h5>Users</h5>
		</div>
	</div>
	<ul class="toolbar">
		<li>
			<a title="" href="{$url}users/user.php"><i class="font-plus"></i><span>New User</span></a>
		</li>
	</ul>
	<div class="table-overflow">
		<table class="table table-striped" id="data-table">
			<thead>
				<tr>
					<th>#</th>
					<th>Username</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$users item=user}
					<tr{if (!$user->activated)} class="error"{elseif ($user->is_admin)} class="info"{/if}>
						<td>{$user->id}</td>
						<td><a href="{$url}users/user.php?id={$user->id}">{$user->title}</a></td>
						<td>{$user->firstname}</td>
						<td>{$user->lastname}</td>
						<td>
							<ul class="table-controls">
								<li>
									<a class="btn hovertip" href="{$url}users/user.php?id={$user->id}" data-original-title="Edit entry"><i class="icon-pencil"></i></a>
								</li>
								<li>
									<a class="btn hovertip" href="{$url}users/user.php?id={$user->id}&action=delete" data-original-title="Delete entry" onclick="return confirm('Are you sure you wish to delete this user?');"><i class="icon-remove"></i></a>
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