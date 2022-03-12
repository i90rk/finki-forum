<?php
    $isAdmin = false;
        if(isset($session['group_type']) && $session['group_type'] == 'Администратор') {
            $isAdmin = true;
    }
?>
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
<script src="<?php echo base_url();?>resources/js/libs/handlebars.js"></script>
<script src="<?php echo base_url();?>resources/js/libs/select2.min.js"></script>
<script src="<?php echo base_url();?>resources/js/libs/bootstrap-paginator.min.js"></script>
<script src="<?php echo base_url();?>resources/js/global_actions_script.js"></script>
<script src="<?php echo base_url();?>resources/js/user_profile_script.js"></script>

</head>
<body>
    <?php // echo '<pre>'; print_r($user_data); echo '</pre>'; ?>
    <div id="wrapper" class="clearfix">
        <div id="mainHeaderWrap">
            <?php forumHeader(); ?>
            <?php 
                if(isset($session['loggedin']) && $session['loggedin'] == true) {
                    afterLoginMenu($session);
                } else {
                    beforeLoginMenu();
                } 
            ?>
        </div>
        <div id="main_navigation" class="navbar">
            <?php
                loggedInNotification($session);
            ?>
        </div>

        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>home">Форуми</a> <span class="divider">/</span></li>
            <li class="active">Кориснички профил</li>
        </ul>
        
        <div class="clear"></div>
        <div id="content">
        	<div class="user_profile_wrapper clearfix">

        		<div class="user_profile_details clearfix">
                    <div class="user_profile_avatar"><img src="<?php echo base_url() . $user_data['avatar_image'];?>" class="img-polaroid"/></div>

        			<div class="user_profile_name">
                        <?php echo $user_data['username'] ?>
                    </div> 
                        <?php
                            if($isAdmin && ($session['id']->{'$id'} != $this->uri->segment(3))) {
                        ?>
                                <div class="user_profile_ban">
                                    <?php 
                                        if(isset($user_data['ban_data']) && !empty($user_data['ban_data'])) {
                                    ?>
                                            <button id="ban_user_btn" class="btn btn-link" style="display:none">(Банирај член)</button>
                                            <button id="unban_user_btn" class="btn btn-link">(Укини забрана)</button>
                                    <?php 
                                        } else {
                                    ?>
                                            <button id="ban_user_btn" class="btn btn-link">(Банирај член)</button>
                                            <button id="unban_user_btn" class="btn btn-link" style="display:none">(Укини забрана)</button>
                                    <?php 
                                        }
                                    ?>
                                </div>
                        <?php
                            }
                        ?>

        			<div class="user_profile_type"><?php echo $user_data['group_type'] ?></div>
                    
                    <div class="user_profile_type">Целосно име: 
                        <span id="fullname">
                             <b>
                            <?php echo $user_data['firstname'] . ' ' . $user_data['lastname'] ?>
                             </b>
                        </span>
                    </div>
                    
                    <div class="user_profile_type">Датум на раѓање: <br/> 
                        <span id="birthday">
                             <b>
                            <?php echo $user_data['birth_day'] . ' ' . $user_data['birth_month'] . ' ' . $user_data['birth_year'] ?>
                            </b>
                        </span>
                    </div>
                    
                    <div class="user_profile_type">E-mail:  <b><?php echo $user_data['email']; ?></b></div>

        			<div class="user_profile_joined">Член од <?php echo $user_data['join_date']; ?></div>

                    <div class="user_profile_activity">Последна активност: <br/><?php echo $user_data['last_activity']; ?></div>

        		</div>


                <div class="user_profile_posts">
                    <div id="user_profile_posts_wrap"></div>
                    <div id="pagination" class="pagination" style="display:none"></div>
                </div>



        	</div>





        </div> <!-- end #content -->
        
        <?php forumFooter(); ?>
    </div> <!-- end #wrapper -->

    <!-- New post modal -->
    <div id="banUserModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="banUserModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close close_modal" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="banUserModalLabel">Банирај член</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Укини ја забраната после: </label>
                        <div class="controls">
                            <select id="ban_select_period">
                                <option></option>
                                <option value="day_1">1 Ден</option>
                                <option value="day_2">2 Дена</option>
                                <option value="day_3">3 Дена</option>
                                <option value="day_4">4 Дена</option>
                                <option value="day_5">5 Дена</option>
                                <option value="day_6">6 Дена</option>
                                <option value="day_7">7 Дена</option>
                                <option value="week_2">2 Недели</option>
                                <option value="week_3">3 Недели</option>
                                <option value="month_1">1 Месец</option>
                                <option value="month_2">2 Месеци</option>
                                <option value="month_3">3 Месеци</option>
                                <option value="month_4">4 Месеци</option>
                                <option value="month_5">5 Месеци</option>
                                <option value="month_6">6 Месеци</option>
                                <option value="year_1">1 Година</option>
                                <option value="year_2">2 Години</option>                           
                            </select>
                            <span id="ban_select_period_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Причина за банирање: </label>
                        <div class="controls">
                            <textarea id="ban_reason" placeholder="Причина за банирање ..." rows="10"></textarea>
                            <span id="ban_reason_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                </form>
        </div>
        <div class="modal-footer">
            <span id="ban_user_msgs" class="status_error_messages alert" style="display:none"></span>
            <button class="btn close_modal" data-dismiss="modal" aria-hidden="true">затвори</button>
            <button id="ban_user_submit" class="btn btn-primary">банирај член</button>
        </div>
    </div>


    <!-- Modal window register -->
    <?php printRegisterUserModal(); ?>

    <!-- Modal window login -->
    <?php printLoginUserModal(); ?>

</body>

<script id="userPostsListTemplate" type="text/x-handlebars-template">
    {{#if this}}
        {{#each this}}
            <div class="media user_profile_post_wrapper">
                <a class="pull-left" href="#">
                    <img src="<?php echo base_url();?>{{user_data.avatar}}" class="media-object custom_image">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">
                        <a href="<?php echo base_url(); ?>posts/postsList/{{subforum_id.$id}}/{{topic_data.topic_id.$id}}">
                            {{topic_data.topic_title}}
                        </a>
                    </h4>
                    <h6 class="media-heading">{{date}}</h6>
                    {{{post}}}
                    {{!<button class="btn btn-link customLinkButton">read the whole post</button>}}
                </div>
                <hr/>
            </div>
        {{/each}}
    {{/if}}
</script>

</html>