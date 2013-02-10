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
				<h5>Register</h5>
				<p>Complete the below form to become a C4Powered member.</p>
				
				<div class="six column">
					<label for="niceFieldsetInput">Username: <span class="label white">Required</span></label>
					<input type="text" class="input-text" placeholder="Username" name="username" value="{$formValues.username}" />
					{if isset($formErrors.username)}<small class="error">{$formErrors.username}</small>{/if}
				</div>
				<div class="six column">
					<label for="niceFieldsetInput">Email: <span class="label white">Required</span></label>
					<input type="text" class="input-text" placeholder="Email" name="email" value="{$formValues.email}" />
					{if isset($formErrors.email)}<small class="error">{$formErrors.email}</small>{/if}
				</div>
				
				<div class="six column">
					<label for="niceFieldsetInput">First name: <span class="label white">Required</span></label>
					<input type="text" class="input-text" placeholder="First name" name="firstname" value="{$formValues.firstname}" />
					{if isset($formErrors.firstname)}<small class="error">{$formErrors.firstname}</small>{/if}
				</div>
				<div class="six column">
					<label for="niceFieldsetInput">Last name: <span class="label white">Required</span></label>
					<input type="text" class="input-text" placeholder="Last name" name="lastname" value="{$formValues.lastname}" />
					{if isset($formErrors.lastname)}<small class="error">{$formErrors.lastname}</small>{/if}
				</div>
				
				<div class="six column">
					<label for="niceFieldsetInput">Password: <span class="label white">Required</span></label>
					<input type="password" class="input-text" placeholder="Password" name="password" />
					{if isset($formErrors.password)}<small class="error">{$formErrors.password}</small>{/if}
				</div>
				<div class="six column">
					<label for="niceFieldsetInput">Confirm Password: <span class="label white">Required</span></label>
					<input type="password" class="input-text" placeholder="Confirm Password" name="confirm_password" />
					{if isset($formErrors.confirm_password)}<small class="error">{$formErrors.confirm_password}</small>{/if}
				</div>
			</fieldset>
			
			<input type="submit" class="nice small radius white button" value="Register" name="submit" />
		</form>
	</div>
</div>
	
{include file='common/footer.tpl'}