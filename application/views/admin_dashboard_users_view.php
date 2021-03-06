<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Finki Forum</title>

<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=latin,cyrillic' rel='stylesheet' type='text/css'>        
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
<script src="<?php echo base_url();?>resources/js/libs/handlebars.js"></script>
<script src="<?php echo base_url();?>resources/js/libs/select2.min.js"></script>
<script src="<?php echo base_url();?>resources/js/admin_dashboard_users_script.js"></script>

</head>
<body>
<div id="wrapper" class="clearfix">
    <div id="mainHeaderWrap">
        <?php 
            forumHeader();                  
            afterLoginMenu($this->userdata);
        ?>
    </div>
    <div id="main_navigation" class="navbar">

        <?php
            loggedInNotification($this->userdata);
        ?>

        <div class="navbar-inner">
            <ul class="nav">
                <li><a href="<?php echo base_url() . 'admin_dashboard' ?>">????????????</a></li>
                <li class="active"><a href="<?php echo base_url() . 'admin_dashboard_users' ?>">??????????????????</a></li>
            </ul>
            <ul class="nav pull-right">
                <li><a href="<?php echo base_url();?>home">?????????????? ????????????</a></li>
            </ul>
        </div>
    </div> 
    
    <div class="clear"></div>    
    <div id="content_admin"> 
        <div id="panel-left">
            <!-- <ul class="left-panel-list">
                <li id="add_user"><a href="#" class="link_active">Add new user</a></li>
                <li id="manage_users"><a href="#">Manage users</a></li>
                <li id="ban_user"><a href="#">Ban user</a></li>
                <li id="banned_users"><a href="#">View banned users</a></li>
                <li id="send_email"><a href="#">Send email to user</a></li>
            </ul> -->

            <ul class="nav nav-list nav-nav-list">
                <li id="add_user" class="active"><a href="#">???????????? ?????? ???????? <i style="float:right" class="icon-chevron-right icon-white"></i></a></li>
                <li id="manage_users"><a href="#">?????????????????? ?????????????? <i style="float:right" class="icon-chevron-right icon-white"></i></a></li>
                <li id="ban_user"><a href="#">?????????????? ???????? <i style="float:right" class="icon-chevron-right icon-white"></i></a></li>
                <li id="banned_users"><a href="#">???????????????? ?????????????? <i style="float:right" class="icon-chevron-right icon-white"></i></a></li>
            </ul>
        </div>

        <div id="panel-right">


            <!-- Add new user -->
            <div id="add_user_wrap" class="form_wrap">
                <h4>???????????? ?????? ????????</h4><br/>
                <form class="form-horizontal" enctype='multipart/form-data'>
                    <div class="control-group">
                        <label class="control-label">??????: </label>
                        <div class="controls">
                            <input type="text" id="add_firstname" name="add_firstname" placeholder="??????">
                            <span id="add_firstname_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">??????????????: </label>
                        <div class="controls">
                            <input type="text" id="add_lastname" name="add_lastname" placeholder="??????????????">
                            <span id="add_lastname_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">???????????????????? ??????: </label>
                        <div class="controls">
                            <input type="text" id="add_username" class="add_username" placeholder="???????????????????? ??????">
                            <span id="add_username_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">??????????????: </label>
                        <div class="controls">
                            <input type="password" id="add_password" class="add_password" placeholder="??????????????">
                            <span id="add_password_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">?????????????? ??????????????: </label>
                        <div class="controls">
                            <input type="password" id="add_password_confirm" class="add_password_confirm" placeholder="?????????????? ??????????????">
                            <span id="add_password_confirm_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Email ????????????: </label>
                        <div class="controls">
                            <input type="text" id="add_email" class="add_email" placeholder="Email ????????????">
                            <span id="add_email_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">?????????? ???? ????????????: </label>
                        <div class="controls">
                            <select id="add_birth_month" name="add_birth_month">
                                <option></option>
                                <option value="??????????????">??????????????</option>
                                <option value="????????????????">????????????????</option>
                                <option value="????????">????????</option>
                                <option value="??????????">??????????</option>
                                <option value="??????">??????</option>
                                <option value="????????">????????</option>
                                <option value="????????">????????</option>
                                <option value="????????????">????????????</option>
                                <option value="??????????????????">??????????????????</option>
                                <option value="????????????????">????????????????</option>
                                <option value="??????????????">??????????????</option>
                                <option value="????????????????">????????????????</option>
                            </select>
                            <input type="text" id="add_birth_day" name="add_birth_day" placeholder="??????" class="input-mini">
                            <input type="text" id="add_birth_year" name="add_birth_year" placeholder="????????????" class="input-mini">
                            <span id="add_birthday_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">????????????: </label>
                        <div class="controls">
                            <div class="input-append">
                                <button id="upload_image_btn" name="upload_image_btn" class="btn" type="button">???????????????? ??????????</button>
                                <span id="upload_image_name" name="upload_image_name" class="input-large uneditable-input"></span>
                                <input id="upload_image_sim" name="upload_image_sim" type="file" style="display:none"/>
                            </div>
                            <span id="add_avatar_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button id="submit_new_user" type="button" class="btn btn-primary">???????????? ????????</button>
                            <span id="add_user_status_message" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                </form>
            </div>


            <!-- Manage users -->
            <div id="manage_users" class="form_wrap" style="display:none">
                <h4>?????????????????? ??????????????</h4><br/>

                <form class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">???????????? ????????:</label>
                        <div class="controls">
                            <select id="manage_users_select_action">
                            </select>
                            <button id="edit_user_btn" type="button" class="btn btn-primary">??????????????</button>
                            <button id="delete_user_btn" type="button" class="btn">??????????????</button><!-- <br/><br/> -->
                            <span id="edit_action_status_message" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                </form>

                <br/><br/><br/>

                <form id="edit_user_form" class="form-horizontal" style="display:none">
                    <h4>?????????????? ????????????????</h4><br/>
                    <input type="hidden" id="edit_user_form_id" />
                    <div class="control-group">
                        <label class="control-label">??????: </label>
                        <div class="controls">
                            <input type="text" id="edit_firstname" name="edit_firstname" placeholder="??????">
                            <span id="edit_firstname_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">??????????????: </label>
                        <div class="controls">
                            <input type="text" id="edit_lastname" name="edit_lastname" placeholder="??????????????">
                            <span id="edit_lastname_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">???????????????????? ??????: </label>
                        <div class="controls">
                            <input type="text" id="edit_username" name="edit_username" placeholder="???????????????????? ??????" disabled>
                            <span id="edit_username_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <!-- <div class="control-group">
                        <label class="control-label">??????????????: </label>
                        <div class="controls">
                            <input type="password" id="edit_password" name="edit_password" placeholder="??????????????">
                            <span id="edit_password_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">?????????????? ??????????????: </label>
                        <div class="controls">
                            <input type="password" id="edit_password_confirm" name="edit_password_confirm" placeholder="?????????????? ??????????????">
                            <span id="edit_password_confirm_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div> -->
                    <div class="control-group">
                        <label class="control-label">Email ????????????: </label>
                        <div class="controls">
                            <input type="text" id="edit_email" name="edit_email" placeholder="Email ????????????" disabled>
                            <span id="edit_email_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">?????????? ???? ????????????: </label>
                        <div class="controls">
                            <select id="edit_birth_month" name="edit_month">
                                <option></option>
                                <option value="??????????????">??????????????</option>
                                <option value="????????????????">????????????????</option>
                                <option value="????????">????????</option>
                                <option value="??????????">??????????</option>
                                <option value="??????">??????</option>
                                <option value="????????">????????</option>
                                <option value="????????">????????</option>
                                <option value="????????????">????????????</option>
                                <option value="??????????????????">??????????????????</option>
                                <option value="????????????????">????????????????</option>
                                <option value="??????????????">??????????????</option>
                                <option value="????????????????">????????????????</option>
                            </select>
                            <input type="text" id="edit_birth_day" name="edit_birth_day" placeholder="??????" class="input-mini">
                            <input type="text" id="edit_birth_year" name="edit_birth_year" placeholder="????????????" class="input-mini">
                            <span id="edit_birthday_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">????????????: </label>
                        <div class="controls">
                            <div class="input-append">
                                <button id="edit_upload_image_btn" name="edit_upload_image_btn" class="btn" type="button">???????????????? ??????????</button>
                                <span id="edit_upload_image_name" name="edit_upload_image_name" class="input-large uneditable-input"></span>
                                <input id="edit_upload_image_sim" name="edit_upload_image_sim" type="file" style="display:none"/>
                            </div>
                            <span id="edit_avatar_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button id="submit_edit_user" type="button" class="btn btn-primary">??????????????</button>
                            <span id="edit_user_status_message" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                </form>
            </div>


            <!-- Ban user -->
            <div id="ban_user_wrap" class="form_wrap" style="display:none">
                <h4>?????????????? ????????</h4><br/>
                <form class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">???????????? ????????</label>
                        <div class="controls">
                            <select id="ban_select_user">
                            </select>
                            <span id="ban_select_user_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">?????????? ?????????????? ??????????: </label>
                        <div class="controls">
                            <select id="ban_select_period">
                                <option></option>
                                <option value="day_1">1 ??????</option>
                                <option value="day_2">2 ????????</option>
                                <option value="day_3">3 ????????</option>
                                <option value="day_4">4 ????????</option>
                                <option value="day_5">5 ????????</option>
                                <option value="day_6">6 ????????</option>
                                <option value="day_7">7 ????????</option>
                                <option value="week_2">2 ????????????</option>
                                <option value="week_3">3 ????????????</option>
                                <option value="month_1">1 ??????????</option>
                                <option value="month_2">2 ????????????</option>
                                <option value="month_3">3 ????????????</option>
                                <option value="month_4">4 ????????????</option>
                                <option value="month_5">5 ????????????</option>
                                <option value="month_6">6 ????????????</option>
                                <option value="year_1">1 ????????????</option>
                                <option value="year_2">2 ????????????</option>                           
                            </select>
                            <span id="ban_select_period_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">?????????????? ???? ??????????????: </label>
                        <div class="controls">
                            <textarea id="ban_reason" placeholder="?????????????? ???? ?????????????? ..." rows="10"></textarea>
                            <span id="ban_reason_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button id="ban_user_submit" type="button" class="btn btn-primary">?????????????? ????????</button>
                            <span id="ban_user_status_message" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                </form>
            </div>


            <!-- List of banned users -->
            <div id="banned_users_wrap" class="form_wrap" style="display:none">
                <h4>?????????????? ???? ???????????????? ??????????????</h4><br/>
                <table id="banned_users_list" class="table table-hover" style="font-size:13px">
                </table>
            </div>


            <!-- Send email to user -->
            <!-- <div id="send_email_wrap" class="form_wrap" style="display:none">
                <h4>Send email to user</h4><br/>
                <form class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Subject:</label>
                        <div class="controls">
                            <input type="text" id="inputEmail" placeholder="Subject">
                            <span class="alert">error message</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">From:</label>
                        <div class="controls">
                            <input type="text" id="inputPassword" placeholder="From">
                            <span class="alert">error message</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Select user:</label>
                        <div class="controls">
                            <input type="text" id="inputPassword" placeholder="Select user">
                            <span class="alert">error message</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">To:</label>
                        <div class="controls">
                            <input type="text" id="inputPassword" placeholder="To">
                            <span class="alert">error message</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Message:</label>
                        <div class="controls">
                            <textarea placeholder="Message ..." rows="15"></textarea>
                            <span class="alert">error message</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="button" class="btn">send message</button>
                            <span class="alert">status message</span>
                        </div>
                    </div>
                </form>
            </div> -->

        </div>
    </div> <!-- end #content -->
    <?php forumFooter(); ?>
</div> <!-- end #wrapper -->


</body>

<!-- Add new subforum select-option -->
<script id="manageUsersSelectActionTmpl" type="text/x-handlebars-template">
    <option></option>
    {{#each this}}
        <option value="{{_id.$id}}">{{firstname}} {{lastname}} ({{username}})</option>
    {{/each}}
</script>

<!-- List of banned users -->
<script id="listOfBannedUsersTmpl" type="text/x-handlebars-template">
    <tr>
        <th>???????????????????? ??????</th>
        <th>?????????????? ????</th>
        <th>?????????????? ????</th>
        <th>??????????????????????</th>
        <th>?????????????????? ???????????????? ????</th>
        <th>?????????? ??????????????</th>
        <th>??????????????</th>
    </tr>
    {{#each this}}
        <tr>
            <td>{{firstname}} {{lastname}} ({{username}})</td>
            <td>{{ban_data.banned_by.firstname}} {{ban_data.banned_by.lastname}} ({{ban_data.banned_by.username}})</td>
            <td>{{ban_data.banned_on}}</td>
            <td>{{ban_data.ban_period}}</td>
            <td>{{ban_data.ban_lift}}</td>
            <td data-id="{{_id.$id}}"><a href="#" class="lift_ban btn-link">?????????? ??????????????</a></td>
            <td>{{ban_data.ban_reason}}</td>
        </tr>
    {{/each}}
</script>

</html>