<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Finki Forum</title>

<!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=latin,cyrillic' rel='stylesheet' type='text/css'>         -->
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>resources/css/bootstrap.css" />
<!-- <link rel="stylesheet" type="text/css" media="all" href="<?php // echo base_url(); ?>resources/css/bootstrap.min.css" /> -->
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>resources/css/bootstrap-responsive.css" />
<!-- <link rel="stylesheet" type="text/css" media="all" href="<?php // echo base_url(); ?>resources/css/bootstrap-responsive.min.css" /> -->
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>resources/css/select2.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>resources/css/style.css" />

<script type="text/javascript">
    var BASE_URL = "<?php echo base_url(); ?>";
</script>

<script src="<?php echo base_url();?>resources/js/libs/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url();?>resources/js/libs/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>resources/js/admin_login_script.js"></script>
</head>
<body>
    <?php // echo '<pre>'; print_r($user_data); echo '</pre>'; ?>
    <div id="wrapper" class="clearfix">
        <div id="mainHeaderWrap">
            <?php forumHeader(); ?>
        </div>

        <div class="clear"></div>
        <div id="content">

			<form class="form-horizontal admin-login-form">
				<div class="control-group">
					<h3>Администраторски панел</h3>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail">Корисничко име: </label>
					<div class="controls">
						<input type="text" id="username" name="username" placeholder="Корисничко име"/><br/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword">Лозинка: </label>
					<div class="controls">
						<input type="password" id="password" name="password" placeholder="Лозинка"/><br/>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button id="submit" name="submit" type="button" class="btn">најави се</button>
						<span id="error_message" class="alert alert-error status_error_messages" style="display:none"></span>
						<br/>
						<br/>
						<p>врати се на <a href="<?php echo base_url(); ?>" class="btn-link">почетна страна</a></p>
					</div>
				</div>
			</form>

        </div> <!-- end #content -->
        
        <?php forumFooter(); ?>
    </div> <!-- end #wrapper -->

    <!-- New post modal -->

</body>

</html>