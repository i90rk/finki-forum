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
<script src="<?php echo base_url();?>resources/js/global_actions_script.js"></script>
<script src="<?php echo base_url();?>resources/js/home_script.js"></script>

</head>
<body>
    <?php // echo '<pre>'; print_r($session); echo '</pre>'; ?>
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
            <li><a href="<?php echo base_url();?>home">Форуми</a> <span class="divider">/</span></li>
        </ul>
        
        <div class="clear"></div>
        <div id="content">
            <?php if (isset($forums) && !empty($forums)) { ?>
                
                <?php foreach ($forums as $forum) { ?>
                    <div class="singleCategoryWrap">                
                        <div class="headerWrap">            
                            <ul>            
                                <li class="headerList">         
                                    <dl>            
                                        <dt class="singleCategoryTitle">
                                            <p class="categoryTitle">
                                                <a class="headerLink" href="<?php echo base_url() . 'home/forums/' . $forum['_id']->{'$id'}; ?>"><?php echo $forum['title'] ?></a>
                                            
                                            </p>
                                        </dt>

                                        <dd class="singleCategoryTopics">
                                            <p class="categoryThreadsNumber">Теми</p>
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

                        <?php foreach($forum['subforums'] as $subforum) { ?>
                            <div class="singleThreadWrap">       
                                <ul>
                                    <li class="headerList">
                                        <dl>
                                            <dt class="singleThreadTitle">
                                                <p class="threadTitle">
                                                    <a class="customLink" href="<?php echo base_url() . 'topics/topicsList/' . $subforum['id']->{'$id'} ?>"><?php echo $subforum['title'] ?></a>
                                                </p>    
                                                <span class="threadDescription"><?php echo $subforum['description'] ?></span>
                                                
                                            </dt>

                                            <dd class="singleThreadTopics">
                                                <p class="threadNumber"><?php echo $subforum['topics_num']; ?></p>
                                            </dd>

                                            <dd class="singleThreadPosts">
                                                <p class="threadPostNumber"><?php echo $subforum['posts_num']; ?></p>
                                            </dd>

                                            <dd class="singleThreadLastPost">
                                                <?php
                                                    if(isset($subforum['last_post']) && !empty($subforum['last_post'])) {
                                                ?>
                                                    <p class="posterName">
                                                        <a class="posterName" href="<?php echo base_url() . 'user_profile/userProfile/' . $subforum['last_post']['id']->{'$id'}; ?>">
                                                            <?php echo $subforum['last_post']['username']; ?>
                                                        </a>
                                                    </p>
                                                    <p class="postTimestamp"><?php echo $subforum['last_post']['date']; ?></p>
                                                <?php
                                                    } else {
                                                ?>
                                                    <p class="noTopicsMessage">Нема теми.</p>
                                                <?php
                                                    }
                                                ?>
                                            </dd>
                                        </dl>
                                    </li>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                
            <?php } ?>
        </div> <!-- end #content -->
        
        <?php forumFooter(); ?>
    </div> <!-- end #wrapper -->


    <!-- Modal window register -->
    <?php printRegisterUserModal(); ?>

    <!-- Modal window login -->
    <?php printLoginUserModal(); ?>

</body>

</html>