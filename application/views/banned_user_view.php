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
<script src="<?php echo base_url();?>resources/js/libs/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url();?>resources/js/libs/bootstrap.min.js"></script>

</head>
<body>
    <?php // echo '<pre>'; print_r($user_data); echo '</pre>'; ?>
    <div id="wrapper" class="clearfix">
        <div id="mainHeaderWrap">
            <?php forumHeader(); ?>
        </div>
        <div id="main_navigation" class="navbar">
            <?php
                loggedInNotification($session);
            ?>
        </div>
        
        <div class="clear"></div>
        <div id="content">
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4>Внимание!!</h4>
                <?php //echo "<pre>"; print_r($ban_data); echo "</pre>"; ?>
                <p>Вашиот пристап до форумот е забранет од страна на администраторот поради следната причина: </p>
                <p><b><?php echo $ban_data['ban_data']['ban_reason']; ?></b></p>
                <p>Вашиот пристап беше забранет на: <b><?php echo date('d-m-Y H:i:s', $ban_data['ban_data']['banned_on']->sec); ?></b></p>
                <p>Забраната истекува на: <b><?php echo date('d-m-Y H:i:s', $ban_data['ban_data']['ban_lift']->sec); ?></b></p>
                <br/>
                <p>врати се на <a href="<?php echo base_url(); ?>home" class="btn-link">почетна страна</a></p>
            </div>
        </div> <!-- end #content -->
        
        <?php forumFooter(); ?>
    </div> <!-- end #wrapper -->

    <!-- New post modal -->

</body>

</html>