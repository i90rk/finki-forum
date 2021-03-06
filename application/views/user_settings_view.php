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
<script src="<?php echo base_url();?>resources/js/user_settings_script.js"></script>

</head>
<body>
    <?php // echo '<pre>'; print_r($user_data); echo '</pre>'; ?>
    <div id="wrapper" class="clearfix">
        <div id="mainHeaderWrap">
            <?php forumHeader(); ?>
            <?php 
                if(isset($session['loggedin']) && $session['loggedin'] == TRUE) {
                    afterLoginMenu($session);
                } else {
                    beforeLoginMenu();
                } 
            ?>
        </div>
        <div id="main_navigation" class="navbar">
            <!-- <div class="navbar-inner">
                <ul class="nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                </ul>
                <form class="navbar-search pull-right">
                  <div class="controls">
                        <div id="append_input" class="input-append">
                            <input id="inputIcon" type="text" placeholder="Search">
                            <button class="btn"><i class="icon-search"></i></button>
                        </div>
                    </div>
                </form>
            </div> -->

            <?php
                loggedInNotification($session);
            ?>
        </div>

        <ul class="breadcrumb">
            <li><a href="<?php echo base_url();?>home">????????????</a> <span class="divider">/</span></li>
            <li class="active">???????????????????? ????????????????????</li>
        </ul>
        
        <div class="clear"></div>
        <div id="content">
        	<div class="user_profile_wrapper clearfix">

        		<div class="user_profile_details_settings clearfix">
        			<div class="user_profile_avatar"><img id="user_avatar" src="<?php echo base_url() . $session['avatar_image'];?>" class="img-polaroid"></div>

        			<div class="user_profile_name"><?php echo $user_data['username'] ?></div>

        			<div class="user_profile_type"><?php echo $user_data['group_type'] ?></div>
                    
                    <div class="user_profile_type">?????????????? ??????: 
                        <span id="fullname">
                             <b>
                            <?php echo $user_data['firstname'] . ' ' . $user_data['lastname'] ?>
                              </b>
                        </span>
                    </div>
                    
                    <div class="user_profile_type">?????????? ???? ????????????:<br/> 
                        <span id="birthday">
                             <b>
                            <?php echo $user_data['birth_day'] . ' ' . $user_data['birth_month'] . ' ' . $user_data['birth_year'] ?>
                             </b>
                        </span>
                    </div>

                    <div class="user_profile_type">E-mail:
                     <b>
                      <?php echo $user_data['email']; ?>
                       </b>
                    </div>

        			<div class="user_profile_joined">???????? ???? <?php echo $user_data['join_date']; ?></div>

                    <div class="user_profile_activity">???????????????? ??????????????????: <br/><?php echo $user_data['last_activity']; ?></div>

        		</div>


                <div class="user_profile_settings">
                    <div id="user_profile_posts_wrap">


                        <div class="accordion" id="accordion2">

                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseBasicSettings">
                                    ?????????????? ???? ?????????????????? ????????????????????
                                    </a>
                                </div>
                                <div id="collapseBasicSettings" class="accordion-body collapse in">
                                    <div class="accordion-inner customPadding">
                                        <form id="basic_settings_form" class="form-horizontal">
                                            <div class="control-group">
                                                <label class="control-label">??????: </label>
                                                <div class="controls">
                                                    <input type="text" id="add_firstname" name="add_firstname" placeholder="??????" value="<?php echo $user_data['firstname']; ?>">
                                                    <span id="add_firstname_error" class="status_error_messages alert" style="display:none"></span>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">??????????????: </label>
                                                <div class="controls">
                                                    <input type="text" id="add_lastname" name="add_lastname" placeholder="??????????????" value="<?php echo $user_data['lastname']; ?>">
                                                    <span id="add_lastname_error" class="status_error_messages alert" style="display:none"></span>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">?????????? ???? ????????????: </label>
                                                <div class="controls">
                                                    <select id="add_birth_month" name="add_birth_month">
                                                        <option></option>
                                                        <option value="??????????????" <?php echo ($user_data['birth_month'] == '??????????????') ? 'selected' : '' ; ?>>??????????????</option>
                                                        <option value="????????????????" <?php echo ($user_data['birth_month'] == '????????????????') ? 'selected' : '' ; ?>>????????????????</option>
                                                        <option value="????????" <?php echo ($user_data['birth_month'] == '????????') ? 'selected' : '' ; ?>>????????</option>
                                                        <option value="??????????" <?php echo ($user_data['birth_month'] == '??????????') ? 'selected' : '' ; ?>>??????????</option>
                                                        <option value="??????" <?php echo ($user_data['birth_month'] == '??????') ? 'selected' : '' ; ?>>??????</option>
                                                        <option value="????????" <?php echo ($user_data['birth_month'] == '????????') ? 'selected' : '' ; ?>>????????</option>
                                                        <option value="????????" <?php echo ($user_data['birth_month'] == '????????') ? 'selected' : '' ; ?>>????????</option>
                                                        <option value="????????????" <?php echo ($user_data['birth_month'] == '????????????') ? 'selected' : '' ; ?>>????????????</option>
                                                        <option value="??????????????????" <?php echo ($user_data['birth_month'] == '??????????????????') ? 'selected' : '' ; ?>>??????????????????</option>
                                                        <option value="????????????????" <?php echo ($user_data['birth_month'] == '????????????????') ? 'selected' : '' ; ?>>????????????????</option>
                                                        <option value="??????????????" <?php echo ($user_data['birth_month'] == '??????????????') ? 'selected' : '' ; ?>>??????????????</option>
                                                        <option value="????????????????" <?php echo ($user_data['birth_month'] == '????????????????') ? 'selected' : '' ; ?>>????????????????</option>
                                                    </select>
                                                    <input type="text" id="add_birth_day" name="add_birth_day" placeholder="??????" class="input-mini" value="<?php echo $user_data['birth_day']; ?>">
                                                    <input type="text" id="add_birth_year" name="add_birth_year" placeholder="????????????" class="input-mini" value="<?php echo $user_data['birth_year']; ?>">
                                                    <span id="add_birthday_error" class="status_error_messages alert" style="display:none"></span>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <div class="controls">
                                                    <button id="submit_basic_settings" type="button" class="btn btn-primary">??????????????</button>
                                                    <span id="submit_basic_settings_message" class="status_error_messages alert" style="display:none"></span>
                                                </div>
                                            </div>
                                        </form>   
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseAvatar">
                                    ?????????????? ???? ????????????????
                                    </a>
                                </div>
                                <div id="collapseAvatar" class="accordion-body collapse">
                                    <div class="accordion-inner customPadding">
                                        <form id="change_avatar_form" class="form-horizontal" enctype="multipart/form-data">
                                            <div class="control-group">
                                                <label class="control-label">????????????: </label>
                                                <div class="controls">
                                                    <div class="input-append">
                                                        <button id="upload_image_btn" name="upload_image_btn" class="btn" type="button">???????????? ????????????????</button>
                                                        <span id="upload_image_name" name="upload_image_name" class="input-large uneditable-input"></span>
                                                        <input id="upload_image_sim" name="upload_image_sim" type="file" style="display:none"/>
                                                    </div>
                                                    <span id="add_avatar_error" class="status_error_messages alert" style="display:none"></span>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <button id="change_avatar_btn" type="button" class="btn btn-primary">?????????????? ????????????</button>
                                                    <span id="change_avatar_message" class="status_error_messages alert" style="display:none"></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-group">
                                <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapsePassword">
                                    ?????????????? ???? ??????????????????
                                    </a>
                                </div>
                                <div id="collapsePassword" class="accordion-body collapse">
                                    <div class="accordion-inner customPadding">
                                        <form id="change_password_form" class="form-horizontal">
                                            <div class="control-group">
                                                <label class="control-label">?????????? ?????????????? </label>
                                                <div class="controls">
                                                    <input type="password" id="old_password" class="old_password" placeholder="?????????? ??????????????">
                                                    <span id="old_password_error" class="status_error_messages alert" style="display:none"></span>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">???????? ??????????????: </label>
                                                <div class="controls">
                                                    <input type="password" id="new_password" class="new_password" placeholder="???????? ??????????????">
                                                    <span id="new_password_error" class="status_error_messages alert" style="display:none"></span>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">?????????????? ??????????????: </label>
                                                <div class="controls">
                                                    <input type="password" id="password_confirm" class="password_confirm" placeholder="?????????????? ??????????????">
                                                    <span id="password_confirm_error" class="status_error_messages alert" style="display:none"></span>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <button id="change_password_btn" type="button" class="btn btn-primary">?????????????? ??????????????</button>
                                                    <span id="change_password_message" class="status_error_messages alert" style="display:none"></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>

        	</div>





        </div> <!-- end #content -->
        
        <?php forumFooter(); ?>
    </div> <!-- end #wrapper -->


    <!-- Modal window register -->
    <?php printRegisterUserModal(); ?>

    <!-- Modal window login -->
    <?php printLoginUserModal(); ?>

</body>

</html>