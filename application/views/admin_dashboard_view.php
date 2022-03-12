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
<script src="<?php echo base_url();?>resources/js/admin_dashboard_script.js"></script>

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
                <li class="active"><a href="<?php echo base_url() . 'admin_dashboard' ?>">Форуми</a></li>
                <li><a href="<?php echo base_url() . 'admin_dashboard_users' ?>">Корисници</a></li>
            </ul>
            <ul class="nav pull-right">
                <li><a href="<?php echo base_url();?>home">Почетна страна</a></li>
            </ul>
        </div>
    </div>

    
    <div class="clear"></div>    
    <div id="content_admin"> 
        <div id="panel-left">
            <!-- <ul class="left-panel-list">
                <li id="new_forum"><a href="#" class="link_active">Додади нов форум</a><i class="icon-chevron-right"></i></li>
                <li id="manage_forums"><a href="#">Менаџирај форуми</a></li>
                <li id="new_subforum"><a href="#">Додади нови подфоруми</a></li>
                <li id="manage_subforums"><a href="#">Менаџирај подфоруми</a></li>
            </ul> -->
            <ul class="nav nav-list nav-nav-list">
                <li id="new_forum" class="active"><a href="#">Додади нов форум <i style="float:right" class="icon-chevron-right icon-white"></i></a></li>
                <li id="manage_forums"><a href="#">Менаџирај форуми <i style="float:right" class="icon-chevron-right icon-white"></i></a></li>
                <li id="new_subforum"><a href="#">Додади нов подфорум <i style="float:right" class="icon-chevron-right icon-white"></i></a></li>
                <li id="manage_subforums"><a href="#">Менаџирај подфоруми <i style="float:right" class="icon-chevron-right icon-white"></i></a></li>
            </ul>
        </div>
        <div id="panel-right">



            <!-- Forums -->



            <!-- Add new forum -->
            <div id="new_forum_wrap" class="form_wrap">
            	<h4>Додади нов форум</h4><br/>
                <form id="create_new_forum_form" class="form-horizontal">
                	<div class="control-group">
                        <label class="control-label">Наслов: </label>
                        <div class="controls">
                            <input type="text" id="title" name="title" placeholder="Наслов"/>
                            <span id="title_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>

					<div class="control-group">
                        <label class="control-label">Опис: </label>
                        <div class="controls">
					       <textarea type="text" id="description" name="description" rows="5" placeholder="Опис"></textarea>
					       <span id="description_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
					</div>

					<div class="control-group">
                        <label class="control-label">Редослед на појавување:
                            <br/>
                            <span style="font-size: 11px; font-style: italic">(внеси '0' за да не се појави)</span> 
                        </label>
                        <div class="controls">
        					<input type="text" id="display_order" name="display_order" class="input_size40" placeholder="Ред"/>
                            <span id="display_order_error" class="status_error_messages  alert" style="display:none"></span>
				        </div>
                    </div>

					<div class="control-group">
                        <div class="controls">
    						<button type="button" id="submit_new_forum" class="btn btn-primary" name="submit_new_forum">додади форум</button>
    						<span id="new_forum_status_message" class="status_error_messages alert" style="display:none"></span>
				        </div>
                    </div>
				</form>
            </div>



            <!-- Manage forums -->
            <div id="manage_forums_wrap" class="form_wrap" style="display:none">
                <h4>Менаџирај форуми</h4><br/>
                <div id="forums_list">
                </div>
            </div>



            <!-- Edit forum -->
            <div id="edit_forum_wrap" class="form_wrap" style="display:none">
                <h4>Промени форум</h4><br/>
                <form id="edit_forum_form" class="form-horizontal">
                    <input type="hidden" id="edit_id" name="edit_id" />
                    <div class="control-group">
                        <label class="control-label">Наслов: </label>
                        <div class="controls">
                            <input type="text" id="edit_title" name="edit_title" placeholder="Наслов"/>
                            <span id="edit_title_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Опис: </label>
                        <div class="controls">
                            <textarea type="text" id="edit_description" name="edit_description" rows="5" placeholder="Опис"></textarea>
                            <span id="edit_description_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Редослед на појавување:
                            <br/>
                            <span style="font-size: 11px; font-style: italic">(внеси '0' за да не се појави)</span> 
                        </label>
                        <div class="controls">
                            <input type="text" id="edit_display_order" name="edit_display_order" class="input_size40" placeholder="Редослед"/>
                            <span id="edit_display_order_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="button" id="submit_edit_forum" class="btn btn-primary" name="submit_edit_forum">промени форум</button>
                            <span id="edit_forum_status_message" class="status_error_messages alert" style="display:none"></span>
                        </div>  
                    </div>
                </form>
            </div>



            <!-- Subforums -->



            <!-- Add new subforum -->
            <div id="new_subforum_wrap" class="form_wrap" style="display:none">
                <h4>Додади нов подфорум</h4><br/>
                <form id="create_new_subforum_form" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label">Форум родител: </label>
                        <div class="controls">
                            <select id="select_parent_forum">
                            </select>
                            <span id="parent_forum_error" class="status_error_messages alert" style="display:none"></span>
                        </div>  
                    </div>
                    <div class="control-group">
                        <label class="control-label">Наслов: </label>
                        <div class="controls">
                            <input type="text" id="subforum_title" name="subforum_title" placeholder="Наслов"/>
                            <span id="subforum_title_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Опис: </label>
                        <div class="controls">
                            <textarea type="text" id="subforum_description" name="subforum_description" rows="5" placeholder="Опис"></textarea>
                            <span id="subforum_description_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Редослед на појавување:
                            <br/>
                            <span style="font-size: 11px; font-style: italic">(внеси '0' за да не се појави)</span> 
                        </label>
                        <div class="controls">
                            <input type="text" id="subforum_display_order" name="subforum_display_order" class="input_size40" placeholder="Ред"/>
                            <span id="subforum_display_order_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="button" id="submit_new_subforum" class="btn btn-primary" name="submit_new_subforum">додади подфорум</button>
                            <span id="new_subforum_status_message" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                </form>
            </div>



            <!-- Manage subforums -->
            <div id="manage_subforums_wrap" class="form_wrap" style="display:none">
                <h4>Менаџирај подфоруми</h4><br/>
                <div id="subforums_list">
                </div>
            </div>



            <!-- Edit subforum -->
            <div id="edit_subforum_wrap" class="form_wrap" style="display:none">
                <h4>Промени подфорум</h4><br/>
                <form id="edit_subforum_form" class="form-horizontal">
                    <input type="hidden" id="edit_forum_id" name="edit_forum_id" />
                    <input type="hidden" id="edit_subforum_id" name="edit_subforum_id" />
                    <div class="control-group">
                        <label class="control-label">Форум родител: </label>
                        <div class="controls">
                            <select id="edit_select_parent_forum">
                            </select>
                            <span id="edit_parent_forum_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Наслов: </label>
                        <div class="controls">
                            <input type="text" id="edit_subforum_title" name="edit_subforum_title" placeholder="Наслов"/>
                            <span id="edit_subforum_title_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Опис: </label>
                        <div class="controls">
                            <textarea type="text" id="edit_subforum_description" name="edit_subforum_description" rows="5" placeholder="Опис"></textarea>
                            <span id="edit_subforum_description_error" class="status_error_messages alert" style="display:none"></span>
                        </div>   
                    </div>

                    <div class="control-group">
                        <label class="control-label">Редослед на појавување:
                            <br/>
                            <span style="font-size: 11px; font-style: italic">(внеси '0' за да не се појави)</span> 
                        </label>
                        <div class="controls">
                            <input type="text" id="edit_subforum_display_order" name="edit_subforum_display_order" class="input_size40" placeholder="Ред"/>
                            <span id="edit_subforum_display_order_error" class="status_error_messages alert" style="display:none"></span>
                        </div>  
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="button" id="submit_edit_subforum" class="btn btn-primary" name="submit_edit_subforum">промени форум</button>
                            <span id="edit_subforum_status_message" class="status_error_messages alert" style="display:none"></span>
                        </div>  
                    </div>
                </form>
            </div>



            <!-- Moderators management -->



            <!-- Add new moderator -->
            <div id="add_new_moderator_wrap" class="form_wrap" style="display:none">
                <h4>Додади нов модератор</h4><br/><br/>
                <div class="header_title"></div><br/><br/>
                <form class="form-horizontal">
                    <input type="hidden" id="new_moderator_module" />
                    <input type="hidden" id="new_moderator_forumid" />
                    <input type="hidden" id="new_moderator_subforumid" />
                    <div class="control-group">
                        <label class="control-label">Одбери корисник: </label>
                        <div class="controls">
                            <select id="new_moderator_select">
                            </select>
                            <span id="new_moderator_select_error" class="status_error_messages alert" style="display:none"></span>
                        </div>
                    </div>

                    <br/><h5>Менаџирање на мислења</h5>

                    <div class="control-group">
                        <label class="control-label">Може да менува мислења </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_edit_posts" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_edit_posts" value="0">не
                            </label>
                        </div>
                    </div>

                    <!-- <div class="control-group">
                        <label class="control-label">Can hide posts: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_hide_posts" value="1" checked>yes
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_hide_posts" value="0">no
                            </label>
                        </div>
                    </div> -->

                    <div class="control-group">
                        <label class="control-label">Може да брише мислења: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_delete_posts" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_delete_posts" value="0">не
                            </label>
                        </div>
                    </div>

                    <br/><h5>Менаџирање на тема</h5>

                    <div class="control-group">
                        <label class="control-label">Може да отвори тема: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_open_topics" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_open_topics" value="0">не
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Може да затвори теми: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_close_topics" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_close_topics" value="0">не
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Може да менува теми: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_edit_topics" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_edit_topics" value="0">не
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Може да брише теми: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_delete_topics" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_delete_topics" value="0">не
                            </label>
                        </div>
                    </div>

                    <!-- <br/><h5>Менаџирање на корисници</h5>

                    <div class="control-group">
                        <label class="control-label">Може да банира корисници: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_ban_users" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_ban_users" value="0">не
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Може да одбанира корисници: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_restore_banned_users" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_restore_banned_users" value="0">не
                            </label>
                        </div>
                    </div> -->

                    <div class="control-group">
                        <div class="controls">
                            <button type="button" id="submit_new_moderator" class="btn btn-primary" name="submit_new_moderator">додади модератор</button>
                            <span id="add_new_moderator_status" class="status_error_messages alert" style="display:none"></span>
                        </div>  
                    </div>                    
                </form>
            </div>


            <!-- Edit moderator -->
            <div id="edit_moderator_wrap" class="form_wrap" style="display:none">
                <h4>Промени модератор</h4><br/><br/>
                <div class="header_title"></div><br/>
                <div><b>Корисник: </b><span class="header_user"></span></div><br/><br/>
                <form class="form-horizontal">
                    <input type="hidden" id="edit_moderator_module" />
                    <input type="hidden" id="edit_moderator_forumid" />
                    <input type="hidden" id="edit_moderator_subforumid" />
                    <input type="hidden" id="edit_moderator_userid" />
                    <br/><h5>Менаџирање на мислења</h5>

                    <div class="control-group">
                        <label class="control-label">Може да менува мислења: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_edit_posts_edit" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_edit_posts_edit" value="0">не
                            </label>
                        </div>
                    </div>

                    <!-- <div class="control-group">
                        <label class="control-label">Can hide posts: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_hide_posts_edit" value="1" checked>yes
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_hide_posts_edit" value="0">no
                            </label>
                        </div>
                    </div> -->

                    <div class="control-group">
                        <label class="control-label">Може да брише мислења: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_delete_posts_edit" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_delete_posts_edit" value="0">не
                            </label>
                        </div>
                    </div>

                    <br/><h5>Менаџирање на теми</h5>

                    <div class="control-group">
                        <label class="control-label">Може да отвори теми: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_open_topics_edit" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_open_topics_edit" value="0">не
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Може да затвори теми: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_close_topics_edit" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_close_topics_edit" value="0">не
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Може да менува теми: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_edit_topics_edit" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_edit_topics_edit" value="0">не
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Може да брише теми: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_delete_topics_edit" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_delete_topics_edit" value="0">не
                            </label>
                        </div>
                    </div>

                    <!-- <br/><h5>Менаџирање на корисници</h5>

                    <div class="control-group">
                        <label class="control-label">Може да банира корисници: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_ban_users_edit" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_ban_users_edit" value="0">не
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Може да одбанира корисници: </label>
                        <div class="controls">
                            <label class="radio">
                                <input type="radio" name="can_restore_banned_users_edit" value="1" checked>да
                            </label>
                            <label class="radio">
                                <input type="radio" name="can_restore_banned_users_edit" value="0">не
                            </label>
                        </div>
                    </div> -->

                    <div class="control-group">
                        <div class="controls">
                            <button type="button" id="submit_edit_moderator" class="btn btn-primary" name="submit_edit_moderator">промени модератор</button>
                            <span id="edit_moderator_status" class="status_error_messages alert" style="display:none"></span>
                        </div>  
                    </div>                    
                </form>
            </div>


            <!-- List of moderators -->
            <div id="list_moderators_wrap" class="form_wrap" style="display:none">
                <h4>Листа на модератори</h4><br/><br/>
                <div class="header_title"></div><br/><br/>
                <input type="hidden" id="list_moderator_module" />
                <input type="hidden" id="list_moderator_forumid" />
                <input type="hidden" id="list_moderator_subforumid" />
                <table id="list_moderators_table" class="table table-hover" style="font-size:13px">
                </table>
            </div>

        </div>
    </div> <!-- end #content -->


    
    <?php forumFooter(); ?>
</div> <!-- end #wrapper -->


</body>


<!-- Manage forums table -->
<script id="forumsListTemplate" type="text/x-handlebars-template">
    {{#if this}}
    <table id="manage_forums_table" class="table table-hover" style="font-size:13px">
        <tr>
            <th>Форум</th>
            <th>Акција</th>
            <th>Редослед</th>
            <th>Модератори</th>
        </tr>
    {{#each this}}
        <tr>
            <td class="customTdWidth">{{title}}</td>
            <td data-id="{{_id.$id}}">
                <select class="select_manage_forum_action input_size120">
                    <option value="edit">Промени</option>
                    <option value="delete">Избриши</option>
                </select>
                <button type="button" class="action_button btn">Оди</button>
            </td>
            <td data-id="{{_id.$id}}">
                <input type="text" placeholder="Ред" class="quick_edit_forum_order input_size40" value="{{display_order}}"/>
            </td>
            <td data-id="{{_id.$id}}">
                <select class="forum_manage_moderators">
                    <option value="moderators">Модератори ({{forum_moderators_num}})</option>
                    
                        {{#if moderators}}
                            <option disabled></option>
                            <optgroup label="Моментални модератори">
                                {{#each moderators}}
                                    <option value="{{user_id.$id}}">{{firstname}} {{lastname}} ({{username}})</option>
                                {{/each}}
                            </optgroup>
                            <option disabled></option>
                        {{/if}}
                    
                    <option value="add_moderator">Додади модератор</option>
                </select>   
                <button type="button" class="forum_manage_moderators_btn btn">Оди</button>
            </td>
        </tr>
    {{/each}}
    <tr>
        <td colspan="5">
            <button type="button" id="save_forum_order" class="btn btn-primary">зачувај редослед</button>
            <span id="manage_forums_error_msgs" class="status_error_messages alert" style="display:none"></span>
        </td>
    </tr>
    </table>
    {{/if}}
</script>


<!-- Select moderator(user) dropdown -->
<script id="addModeratorSelectTmpl" type="text/x-handlebars-template">
    <option></option>
    {{#each this}}
        <option value="{{_id.$id}}">{{firstname}} {{lastname}} ({{username}})</option>
    {{/each}}
</script>



<!-- Add new subforum select-option -->
<script id="parentForumsListTemplate" type="text/x-handlebars-template">
    <option value=""></option>
    {{#each this}}
        <option value="{{_id.$id}}">{{title}}</option>
    {{/each}}
</script>



<!-- Manage subforums table -->
<script id="subforumsListTemplate" type="text/x-handlebars-template">
    {{#each this}}
    <table id="manage_subforums_table{{_id.$id}}" class="table table-hover" style="font-size:13px">
        <tr><th colspan="5">Форум родител: {{title}}</th></tr>
        <tr>
            <th>Подфорум</th>
            <th>Акција</th>
            <th>Редослед</th>
            <th>Модератори</th>
        </tr>
        {{#each this.subforums}}
        <tr>
            <td class="customTdWidth">{{title}}</td>
            <td data-id="{{id.$id}}" data-forum_id="{{../this._id.$id}}">
                <select class="select_manage_subforum_action input_size120">
                    <option value="edit">Промени</option>
                    <option value="delete">Избриши</option>
                </select>
                <button type="button" class="action_button btn">Оди</button>
            </td>
            <td data-id="{{id.$id}}" data-forum_id="{{../this._id.$id}}">
                <input type="text" placeholder="Ред" class="quick_edit_subforum_order input_size40" value="{{display_order}}"/>   
            </td>
            <td data-id="{{id.$id}}" data-forum_id="{{../this._id.$id}}">
                <select class="subforum_manage_moderators">
                    <option value="moderators">Модератори ({{subforum_moderators_num}})</option>
                    
                        {{#if moderators}}
                            <option disabled></option>
                            <optgroup label="Моментални модератори">
                                {{#each moderators}}
                                    <option value="{{user_id.$id}}">{{firstname}} {{lastname}} ({{username}})</option>
                                {{/each}}
                                </optgroup>
                            <option disabled></option>
                        {{/if}}
                    
                    <option value="add_moderator">Додади модератор</option>
                </select>  
                <button type="button" class="subforum_manage_moderators_btn btn">Оди</button>
            </td>
        </tr>
        {{/each}}
        <tr>
            <td data-forum_id="{{_id.$id}}" colspan="5">
                <button type="button" class="btn btn-primary save_subforum_order btn">зачувај редослед</button>
                <span id="manage_subforums_error_msgs{{_id.$id}}" class="status_error_messages alert" style="display:none"></span>
            </td>
        </tr>
        </table>
    {{/each}}
</script>



<!-- List forum moderators -->
<script id="moderatorsListTmpl" type="text/x-handlebars-template">
    <tr>
        <th>Целосно име</th>
        <th>Корисничко име</th>
        <th>Промени привилегии</th>
        <th>Избриши модератор</th>
    </tr>
    {{#if this}}
        {{#each this}}
            <tr>    
                <td>{{firstname}} {{lastname}}</td>
                <td>{{username}}</td>
                <td data-id="{{user_id.$id}}"><button class="btn btn-link edit_abilities">промени</button></td>
                <td data-id="{{user_id.$id}}"><button class="btn btn-link delete_moderator">избриши</button></td>
            </tr>
        {{/each}}
    {{else}}
        <tr>
            <td colspan="4" class="alignTableText">Нема модератори.</td>
        </tr>
    {{/if}}
</script>

</html>