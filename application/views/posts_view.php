<?php
    $isModerator = false;
    $isAdmin = false;
    if(isset($session['group_type']) && $session['group_type'] == 'Администратор') {
        // $privileges = $session['admin_privilegies'];
        $isAdmin = true;
        $isModerator = true;

    } else if(isset($session['moderator_for_forums']) && !empty($session['moderator_for_forums'])) {
        foreach($session['moderator_for_forums'] as $forum) {
            if(in_array($this->uri->segment(3), $forum['subforums_ids'])) {
                $isModerator = true;
                $privileges = $forum;
                break;
            }
        }
    } else if(isset($session['moderator_for_subforums']) && !empty($session['moderator_for_subforums'])) {
        foreach($session['moderator_for_subforums'] as $subforum) {
            if($subforum['subforum_id']->{'$id'} == $this->uri->segment(3)) {
                $isModerator = true;
                $privileges = $subforum;
                break;
            }
        }
    }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Finki Forum</title>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>iForum Admin Page</title>

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
<script src="<?php echo base_url();?>resources/js/libs/tinymce/tinymce.min.js"></script>
<script src="<?php echo base_url();?>resources/js/libs/bootstrap-paginator.min.js"></script>
<script src="<?php echo base_url();?>resources/js/global_actions_script.js"></script>
<script src="<?php echo base_url();?>resources/js/posts_script.js"></script>

</head>
<body>
    <?php  // echo '<pre>'; print_r($session); echo '</pre>'; ?>
    <div id="wrapper" class="clearfix">
    
        <div class="clear"></div>    
    
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
            <li><a href="<?php echo base_url();?>home">Форуми</a><span class="divider">/</span></li>
            <li><a href="<?php echo base_url() . 'home/forums/' . $breadcrumbs[0]['id']->{'$id'};?>"><?php echo $breadcrumbs[0]['title']; ?></a> <span class="divider">/</span></li>
            <li><a href="<?php echo base_url() . 'topics/topicsList/' . $breadcrumbs[1]['id']->{'$id'};?>"><?php echo $breadcrumbs[1]['title']; ?></a> <span class="divider">/</span></li>
            <li id="topic_title_breadcrump" class="active"><?php echo $breadcrumbs[2]['title']; ?></li>
        </ul>

        <h3 id="topic_title"><?php echo $breadcrumbs[2]['title']; ?></h3>
        <input type="hidden" id="forum_id" value="<?php echo $breadcrumbs[0]['id']->{'$id'}; ?>">
        <input type="hidden" id="subforum_id" value="<?php echo $breadcrumbs[1]['id']->{'$id'}; ?>">

        <?php 
            if(isset($session['loggedin']) && $session['loggedin'] == TRUE) {
        ?>
            <div class="topicOptions">
                <?php
                    if(isset($topic_closed) && $topic_closed == 0) {
                ?>

                        <div class="postReply newPost_click">Испрати мислење</div>

                <?php
                    } else {
                ?>

                        <span>Оваа тема е затворена.</span>

                <?php
                    }
                ?>
                <!-- <div class="topicSettings"></div> -->
                <?php 
                    if($isModerator ) {

                        if($isAdmin || $privileges['can_open_topics'] || $privileges['can_close_topics'] || $privileges['can_edit_topics'] || $privileges['can_delete_topics']) {
                ?>
                        <div class="dropdown pull-right">
                            <a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#">
                                <span class="topicSettings"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">

                <?php
                            if(($isAdmin || $privileges['can_open_topics']) && (isset($topic_closed) && $topic_closed == 1)) {
                ?>
                                <li id="open_topic" role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="icon-folder-open"></i>&nbsp;&nbsp;&nbsp;Отвори тема</a></li>
                                <!-- <i class="icon-trash"></i> -->
                <?php
                            }

                            if(($isAdmin || $privileges['can_close_topics']) && (isset($topic_closed) && $topic_closed == 0)) {
                ?>
                                <li id="close_topic" role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="icon-ban-circle"></i>&nbsp;&nbsp;&nbsp;Затвори тема</a></li>
                                <!-- <i class="icon-trash"></i> -->
                <?php
                            }

                            if($isAdmin || $privileges['can_edit_topics']) {
                ?>
                                <li id="edit_topic" role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="icon-pencil"></i>&nbsp;&nbsp;&nbsp;Промени тема</a></li>
                <?php     
                            }

                            if($isAdmin || $privileges['can_delete_topics']) {

                ?>
                                <li id="delete_topic" role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="icon-trash"></i>&nbsp;&nbsp;&nbsp;Избриши тема</a></li>
                                <!-- <i class="icon-trash"></i> -->

                <?php
                            }
                ?>
                        </div>
                <?php
                        }
                    }
                ?>
            </div>
        <?php
            }
        ?>
   
        <div id="content"> 
            <div class="clear"></div>

            <!-- Posts list wraper -->
            <div id="posts_list_wrap">
                <!-- Posts list template -->
            </div>

            <div id="pagination" class="pagination" style="display:none"></div>
               
      <!-- <div id="replyBox"></div> -->
        </div> <!-- end #content -->

        <?php forumFooter(); ?>

    </div> <!-- end #wrapper -->

    <!-- New post modal -->
    <div id="newPostModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="newPostModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close close_modal" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="newPostModalLabel">Испрати мислење</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
                <div class="control-group">
                    <textarea id="newPostEditor" name="newPostEditor"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <span id="new_post_error" class="status_error_messages alert" style="display:none"></span>
            <button class="btn close_modal" data-dismiss="modal" aria-hidden="true">затвори</button>
            <button id="new_post_btn" class="btn btn-primary">испрати мислење</button>
        </div>
    </div>

    <!-- Edit post modal -->
    <div id="editPostModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="editPostModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close close_modal" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="editPostModalLabel">Промени мислење</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
                <div class="control-group">
                    <textarea id="editPostEditor" name="editPostEditor"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <input id="post_id" type="hidden"/>
            <span id="edit_post_error" class="status_error_messages alert" style="display:none"></span>
            <button class="btn close_modal" data-dismiss="modal" aria-hidden="true">затвори</button>
            <button id="edit_post_btn" class="btn btn-primary"<промени мислење</button>
        </div>
    </div>

    <!-- Quote post modal -->
    <div id="quotePostModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="quotePostModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close close_modal" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="quotePostModalLabel">Цитирај мислење</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
                <div class="control-group">
                    <textarea id="quotePostEditor" name="quotePostEditor"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <!-- <input id="post_id" type="hidden"/> -->
            <span id="quote_post_error" class="status_error_messages alert" style="display:none"></span>
            <button class="btn close_modal" data-dismiss="modal" aria-hidden="true">затвори</button>
            <button id="quote_post_btn" class="btn btn-primary">цитирај мислење</button>
        </div>
    </div>

    <!-- Edit topic modal -->
    <div id="editTopicModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="editTopicModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close close_modal" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="editTopicModalLabel">Промени тема</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="editTopicEditor">Наслов: </label>
                    <div class="controls">
                        <textarea id="editTopicEditor" name="editPostEditor" rows="10" cols="1550"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <span id="edit_topic_error" class="status_error_messages alert" style="display:none"></span>
            <button class="btn close_modal" data-dismiss="modal" aria-hidden="true">затвори</button>
            <button id="edit_topic_btn" class="btn btn-primary">промени мислење</button>
        </div>
    </div>

    <!-- Show more likes users -->
    <div id="moreUsersModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="moreUsersModalLabel" aria-hidden="true">
        <div class="modal-header">
            <!-- <button type="button" class="close close_modal" data-dismiss="modal" aria-hidden="true">×</button> -->
            <h3 id="moreUsersModalLabel">Членови на кои им се допаѓа ова мислење</h3>
        </div>
        <div id="more_users_likes" class="modal-body">
            
        </div>
        <div class="modal-footer">
            <span id="edit_topic_error" class="status_error_messages alert" style="display:none"></span>
            <button class="btn close_modal" data-dismiss="modal" aria-hidden="true">затвори</button>
        </div>
    </div>

    <!-- Modal window register -->
    <?php printRegisterUserModal(); ?>

    <!-- Modal window login -->
    <?php printLoginUserModal(); ?>

</body>

<script type="text/javascript">
    var userSessionId = <?php echo (isset($session['id'])) ? json_encode($session['id']->{'$id'}) : json_encode('') ?>;
    var userPostLikesIds = <?php echo (isset($session['likes_posts_ids'])) ? json_encode($session['likes_posts_ids']) : json_encode(''); ?>;
</script>

<script id="postsListTemplate" type="text/x-handlebars-template">
    {{#if this}}
        {{#each this}}
            <div data-id="{{_id.$id}}" class="post_wrapper">
                <div class="post_left_segment">
                    <div class="avatar"><img src="<?php echo base_url();?>{{user_data.avatar}}"></img></div> 
                    <div class="clear"></div>
                    
                    <div class="username">
                        <a href="<?php echo base_url(); ?>user_profile/userProfile/{{user_data.id.$id}}" class="headerLink username_link">
                            {{user_data.username}}
                        </a>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="userType">{{user_data.group_type}}</div>
                    <div class="clear"></div>
                    
                    <div class="joinDate">Член од {{user_data.join_date}}</div>
                    <div class="clear"></div>
                    
                    <div class="postCount">Мислења: {{user_data.posts_num}}</div>
                    <div class="clear"></div>

                    <div class="postCount">Допаѓања: {{user_data.likes_num}}</div>
                    <div class="clear"></div>

                    <input class="user_id" type="hidden" value="{{user_data.id.$id}}">
                    <div class="clear"></div>
                </div>
          
                <div class="post_right_segment">
                    <div class="postDetails">
                        <span class="postingTime" data-timestamp="{{timestamp}}">Објавено {{date}}</span>
                        <span class="postNr">#{{order_number}}</span>
                    </div>
                    <div class="clear"></div>

                    <div class="postContent">
                        {{{post}}}
                    </div>

                    <div class="clear"></div>

                    <div class="postOptions">

                        <div class="likes">
                            {{#if likes_users}}

                                {{determine_user_like _id.$id likes_users.0.id.$id likes_users.0.username}}

                                {{determine_likes_num _id.$id likes_num}}

                            {{/if}}
                        </div>

                        <?php 
                            if(isset($session['loggedin']) && $session['loggedin'] == TRUE) {
                        ?>
                                {{determine_like_unlike _id.$id}}
                                <div class="quotePost"><button class="btn btn-link">Цитирај</button></div>
                        <?php
                            }
                        ?>

                        <?php 
                            if($isModerator) {
                                if($isAdmin || $privileges['can_edit_posts']) {
                        ?>
                                    <div class="deletePost"><button class="btn btn-link">Избриши</button></div>
                        <?php
                                }
                            }
                        ?>

                        <?php 
                            if($isModerator) {
                                if($isAdmin || $privileges['can_edit_posts']) {
                        ?>
                                    <div class="editPost"><button class="btn btn-link">Промени</button></div>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>
                      <div class="clear"></div>
            </div>
        {{/each}}
    {{else}}
        <div id="topics_list_wrap">

            <div class="alignTableText">Нема мислења во оваа тема.</div>

        </div>
    {{/if}}
</script>

<script id="onePostsLikesTemplate" type="text/x-handlebars-template">
    {{#if likes_users}}
        
        {{determine_user_like_one_post op_type likes_users.0.id.$id likes_users.0.username}}
        
        {{determine_likes_num_one_post op_type _id.$id likes_num}}

    {{/if}}
</script>

<script id="moreUsersLikesTemplate" type="text/x-handlebars-template">
    {{#if likes_users}}
        {{#each likes_users}}
            <div class="media">
                <a class="pull-left" href="#">
                    <img src="<?php echo base_url() ?>{{avatar_image}}" class="media-object custom_image">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">
                        <a href="<?php echo base_url() ?>user_profile/userProfile/{{id.$id}}">{{username}}</a>
                    </h4>
                    {{group_type}} | Мислења: {{posts_num}} | Допаѓања: {{likes_num}}
                </div>
                <hr/>
            </div>
        {{/each}}
    {{/if}}
</script>

</html>