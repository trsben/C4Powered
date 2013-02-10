{include file='common/header.tpl'}

<div class="row">
	{if isset($formErrors.submit)}
		<div class="alert-box error">
			{$formErrors.submit}
			<a href="" class="close">&times;</a>
		</div>
	{/if}
	
	<div class="panel">
		<form action="" method="post" class="nice">
			<fieldset>
				<h5>Login</h5>
				<p>Please login using your username and password.</p>
				
				<div class="six column">
					<label for="niceFieldsetInput">Username:</label>
					<input type="text" class="input-text" placeholder="Username" name="username" />
				</div>
				
				<div class="six column">
					<label for="niceFieldsetInput">Password:</label>
					<input type="password" class="input-text" placeholder="Password" name="password" />
				</div>
			</fieldset>
			
			<input type="submit" class="nice small radius white button" value="Login" name="submit" />
		</form>
	</div>
</div>

{include file='common/footer.tpl'}