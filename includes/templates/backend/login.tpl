{include file='common/header.tpl'}

<div class="login-wrapper">
    {if isset($formErrors.main)}
        {$formErrors.main}
    {/if}
    <div class="login">
        <div class="well">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6><i class="font-user"></i>C4Powered Admin Panel</h6>
                </div>
            </div>
            <form action="" method="post" class="row-fluid">
                <div class="control-group">
                    <label class="control-label">Username</label>
                    <div class="controls"><input class="span12" type="text" name="username" placeholder="username" /></div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Password:</label>
                    <div class="controls"><input class="span12" type="password" name="password" placeholder="password" /></div>
                </div>

                <div class="login-btn"><input type="submit" value="Login" name="submit" class="btn btn-info btn-block btn-large" /></div>
            </form>
        </div>
    </div>
</div>

{include file='common/footer.tpl'}