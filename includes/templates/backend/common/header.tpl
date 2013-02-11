<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	
	<title>C4Powered.co.uk{if isset($pageTitle)} - {$pageTitle}{/if}</title>
	
	<link href="{$cssurl}main.css" rel="stylesheet" type="text/css" />
	<!--[if IE]>
		<link href="{$cssurl}ie.css" rel="stylesheet" type="text/css">
	<![endif]-->

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script type="text/javascript" src="{$jsurl}jquery_ui_custom.js"></script>

	<script type="text/javascript" src="{$jsurl}plugins/charts/excanvas.min.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/charts/jquery.flot.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/charts/jquery.flot.resize.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/charts/jquery.sparkline.min.js"></script>

	<script type="text/javascript" src="{$jsurl}plugins/forms/jquery.tagsinput.min.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/forms/jquery.inputlimiter.min.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/forms/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/forms/jquery.autosize.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/forms/jquery.ibutton.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/forms/jquery.dualListBox.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/forms/jquery.validate.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/forms/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/forms/jquery.select2.min.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/forms/jquery.cleditor.js"></script>

	<script type="text/javascript" src="{$jsurl}plugins/uploader/plupload.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/uploader/plupload.html4.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/uploader/plupload.html5.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/uploader/jquery.plupload.queue.js"></script>

	<script type="text/javascript" src="{$jsurl}plugins/wizard/jquery.form.wizard.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/wizard/jquery.form.js"></script>

	<script type="text/javascript" src="{$jsurl}plugins/ui/jquery.collapsible.min.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/ui/jquery.timepicker.min.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/ui/jquery.jgrowl.min.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/ui/jquery.pie.chart.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/ui/jquery.fullcalendar.min.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/ui/jquery.elfinder.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/ui/jquery.fancybox.js"></script>

	<script type="text/javascript" src="{$jsurl}plugins/tables/jquery.dataTables.min.js"></script>

	<script type="text/javascript" src="{$jsurl}plugins/bootstrap/bootstrap.min.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/bootstrap/bootstrap-bootbox.min.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/bootstrap/bootstrap-progressbar.js"></script>
	<script type="text/javascript" src="{$jsurl}plugins/bootstrap/bootstrap-colorpicker.js"></script>

	<script type="text/javascript" src="{$jsurl}functions/custom.js"></script>
	<script type="text/javascript" src="{$jsurl}charts/chart.js"></script>
</head>
<body class="{$pageClass}">
{if $isLoggedIn && $currentMember->is_admin}
<div class="wrapper">
    <div class="sidebar">
        <a class="logo"><img src="{$imageurl}logo.png" alt="" /></a>
        
        {include file='common/navigation.tpl'}
    </div>

    <div class="content">
        <div class="page-header">
            <h5><i class="font-home"></i>{$dashboardTitle}</h5>
            <ul class="topnav">
                <li class="topuser">
                    <a title="#" data-toggle="dropdown"><span>{$currentMember->title}</span><i class="caret"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{$url}users/user.php?id={$currentMember->id}" title=""><span class="user-profile"></span>My profile</a></li>
                    </ul>
                </li>
                <li><a href="{$url}settings.php" title=""><b class="settings"></b></a></li>
                <li class="sidebar-button"><a href="#" title=""><b class="responsive-nav"></b></a></li>
                <li><a href="{$url}logout.php" title=""><b class="logout"></b></a></li>
            </ul>
        </div>

        <div class="body">
{/if}