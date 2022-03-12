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
<script src="<?php echo base_url();?>resources/js/libs/tinymce/tinymce.min.js"></script>
<script src="<?php echo base_url();?>resources/js/libs/bootstrap-paginator.min.js"></script>
<script src="<?php echo base_url();?>resources/js/global_actions_script.js"></script>
<script src="<?php echo base_url();?>resources/js/topics_script.js"></script>

</head>
<body>
    <?php // echo '<pre>'; var_dump($topics); echo '</pre>'; ?>
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
            <li><a href="<?php echo base_url();?>home">Форуми</a><span class="divider">/</span></li>
            <li><a href="<?php echo base_url() . 'home/forums/' . $breadcrumbs[0]['id']->{'$id'};?>"><?php echo $breadcrumbs[0]['title']; ?></a> <span class="divider">/</span></li>
            <li class="active"><?php echo $breadcrumbs[1]['title']; ?></li>
        </ul>

        <h3><?php echo $breadcrumbs[1]['title']?></h3>
        <input type="hidden" id="forum_id" value="<?php echo $breadcrumbs[0]['id']->{'$id'}; ?>">
        <input type="hidden" id="subforum_id" value="<?php echo $breadcrumbs[1]['id']->{'$id'}; ?>">

        <?php 
            if(isset($session['loggedin']) && $session['loggedin'] == TRUE) {
        ?>
            <div class="topicOptions">
                <div class="postReply newTopic_click">Нова тема</div>
            </div>
        <?php
            }
        ?>

        <div class="clear"></div>
        <div id="content"> 
            <div class="singleCategoryWrap">    
                <div class="headerWrap">
                    <ul>
                        <li class="headerList">
                            <dl>
                                <dt class="singleCategoryTitle">
                                     <p class="categoryTitle">Теми</p>
                                </dt>

                                <dd class="singleCategoryTopics">
                                    <p class="categoryThreadsNumber">Прегледи</p>
                                </dd>

                                <dd class="singleCategoryPosts">
                                     <p class="categoryPostNumber">Мислења</p>
                                </dd>

                                <dd class="singleCategoryLastPost">
                                    <p class="categoryLastPost">Последно мислење</p>
                                </dd>
                            </dl> 
                       </li>
                    </ul>
                </div>

                <!-- Topics list wraper -->
                <div id="topics_list_wrap">
                    <!-- Topics list template -->
                </div>

                <div id="pagination" class="pagination" style="display:none;"></div>

            </div>
        </div> <!-- end #content -->
        <?php forumFooter(); ?>
    </div> <!-- end #wrapper -->

    <!-- New topic modal -->
    <div id="newTopicModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="newTopicModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close close_modal" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="newTopicModalLabel">Нова тема</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
                <div class="control-group">
                    <input id="inputTitle" class="span5" type="text" placeholder="Наслов ...">
                </div>
                <div class="control-group">
                    <textarea id="newTopicEditor" name="newTopicEditor"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <span id="new_topic_error" class="status_error_messages alert" style="display:none;"></span>
            <button class="btn close_modal" data-dismiss="modal" aria-hidden="true">затвори</button>
            <button id="add_topic_btn" class="btn btn-primary">додади тема</button>
        </div>
    </div>

    <!-- Modal window register -->
    <?php printRegisterUserModal(); ?>

    <!-- Modal window login -->
    <?php printLoginUserModal(); ?>

</body>

<script id="topicsListTemplate" type="text/x-handlebars-template">
    {{#if this}}
        {{#each this}}
            <div class="singleThreadWrap">       
                <ul>
                    <li class="headerList">
                        <dl>
                            <dt class="singleThreadTitle">
                               <p class="threadTitle"><a class="customLink" href="<?php echo base_url() . 'posts/postsList/' . $breadcrumbs[1]['id']->{'$id'} . '/'; ?>{{_id.$id}}">{{title}}</a></p>
                               <span class="threadDescription">
                                    <a href="<?php echo base_url(); ?>user_profile/userProfile/{{creation_data.id.$id}}" class="posterName">{{creation_data.username}}</a> &gt;&gt; {{creation_data.date}}
                               </span>
                            </dt>

                            <dd class="singleThreadTopics">
                                <p class="threadNumber">{{views_num}}</p>
                            </dd>

                            <dd class="singleThreadPosts">
                               <p class="threadPostNumber">{{posts_num}}</p>
                            </dd>

                            <dd class="singleThreadLastPost">
                                <p class="posterName">
                                    <a class="posterName" href="<?php echo base_url(); ?>user_profile/userProfile/{{last_post.id.$id}}">
                                        {{last_post.username}}
                                    </a>
                                </p>
                                <p class="postTimestamp">{{last_post.date}}</p>
                            </dd>
                        </dl>
                    </li>
                </ul>
            </div>
        {{/each}}
    {{else}}
    <div class="alignTableText">Нема теми во овој подфорум.</div>
    {{/if}}
</script>

</html>