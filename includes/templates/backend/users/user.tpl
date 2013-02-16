{include file='common/header.tpl'}

<div class="well">
	<div class="navbar">
		<div class="navbar-inner">
			<h5>{if (isset($user->id))}{$user->title}{else}New User{/if}</h5>
		</div>
	</div>
	{if (isset($user->id))}
		<ul class="toolbar">
			<li><a title="General" href="{$url}users/user.php?id={$user->id}">General</a></li>
			<li><a title="User Wall" href="{$url}users/user-wall.php?id={$user->id}">User Wall</a></li>
		</ul>
	{/if}
</div>

<form class="form-horizontal" method="post" action="">
    <fieldset>
        <div class="well row-fluid block">
            <div class="navbar">
                <div class="navbar-inner">
                    <h5>General Information</h5>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Username:</label>
                <div class="controls"><input class="span12" type="text" name="title" value="{$formValues.title}" /></div>
            </div>

            <div class="control-group">
                <label class="control-label">First name:</label>
                <div class="controls"><input class="span12" type="text" name="firstname" value="{$formValues.firstname}" /></div>
            </div>

            <div class="control-group">
                <label class="control-label">Surname:</label>
                <div class="controls"><input class="span12" type="text" name="lastname" value="{$formValues.lastname}" /></div>
            </div>

            <div class="control-group">
                <label class="control-label">Email:</label>
                <div class="controls"><input class="span12" type="text" name="email" value="{$formValues.email}" /></div>
            </div>

			<div class="control-group">
				<label class="for control-label"></label>
				<div class="controls">
					<label class="checkbox inline">
						<input class="style" type="checkbox"{if $formValues.activated} checked="checked"{/if} value="1" name="activated"> Activated
					</label>
				</div>
			</div>

			<div class="control-group">
				<label class="for control-label"></label>
				<div class="controls">
					<label class="checkbox inline">
						<input class="style" type="checkbox"{if $formValues.is_admin} checked="checked"{/if} value="1" name="is_admin"> Is Administrator
					</label>
				</div>
			</div>
        </div>
   </fieldset>

	<div class="form-actions align-right">
		<input class="btn btn-primary" type="submit" value="Save" name="action">
	</div>
</form>

{include file='common/footer.tpl'}