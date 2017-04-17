<!DOCTYPE html>
<html lang="ja">
  <head>
    <!--metalist-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="男性美容初心者の方から、男性美容を常に意識されている方まで納得して実践できる「スキンケア」「ダイエット」「筋トレ」「デオドラント」「脱毛」の情報を提供していきます。一緒に美しさと紳士的な上品さを兼ね備えた「BiDAN」になりましょう">
    <?php if (is_home()):?>
      <meta property="og:title" content="BiDAN[ビダン]|美容の悩みを解決する日本で唯一の男性美容専門メディア">
    <?php else:?>
      <meta property="og:title" content="<?php the_title();?>">
    <?php endif;?>
    <title><?php wp_title('|',true,'right'); bloginfo('name');?></title>
    <!-- Bootstrap -->
    <link href="<?php echo get_template_directory_uri();?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri();?>/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_uri(); echo '?' . filemtime( get_stylesheet_directory() . '/style.css'); ?>" type="text/css" rel="stylesheet" />
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- User Heat Tag -->
    <script type="text/javascript">
    (function(add, cla){window['UserHeatTag']=cla;window[cla]=window[cla]||function(){(window[cla].q=window[cla].q||[]).push(arguments)},window[cla].l=1*new Date();var ul=document.createElement('script');var tag = document.getElementsByTagName('script')[0];ul.async=1;ul.src=add;tag.parentNode.insertBefore(ul,tag);})('//uh.nakanohito.jp/uhj2/uh.js', '_uhtracker');_uhtracker({id:'uhhCTogLSa'});
    </script>
    <!-- End User Heat Tag -->
  </head>
  <body>
<!--Header-->
<div class="wrapper">
    <div class="container-fluid">
      <nav>
          <header class="row">
            <ul class="clearfix list-unstyled header-logo list-inline">
              <li class="col-md-4 col-sm-4 col-xs-4 search-button">
                  <div class="hidden-xs"><?php get_template_part("searchform");?></div>
                  <button id="humbarger-button" class="navbar-toggle humbarger humbarger-button">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
              </li>
              <li class="col-md-4 col-sm-4 col-xs-4 text-center logo-text">
                <a href="<?php echo home_url("/");?>">BiDAN</a>
              </li>
              <li class="col-md-4 col-sm-4 col-xs-4 text-right login-button">
                <span class="hidden-xs"></span>
                <div id="search-icon" class="col-xs-4 collapsed visible-xs" data-toggle="collapse" data-target="#sp-search"><span id="button"><i class="sp-search-button glyphicon glyphicon-search color-gold"></i></span></div>
              </li>
              <li class="col-md-12 col-sm-12 col-xs-12 text-center logo-caption">美容のコンプレックスを正しく解消</li>
            </ul>
            <?php $categories = get_categories('parent=0');?>
            <ul class="clearfix col-md-12 col-sm-12 col-xs-12 list-unstyled list-inline text-center category-list">
              <?php foreach($categories as $category): ?>
                <?php echo "<li><a href='" . get_category_link($category->cat_ID) . "'>" .$category->cat_name ."</a></li>";?>
              <?php endforeach;?>
            </ul>
          </header>
          <ul id="nav-list" class="row clearfix navbar-collapse col-xs-5 list-unstyled text-left slide-sidemenu open visible-xs">
            <li id="slidemenu-hider" class="col-xs-12 slidemenu-hider text-right humbarger-button"><span>☓</span></li>
            <li class="col-xs-12 border-liner"></li>
            <li class="col-xs-12 slidemenu-title">カテゴリ</li>
            <?php foreach($categories as $category): ?>
              <?php echo "<li class='col-xs-12 slidemenu-category'><a href='" . get_category_link($category->cat_ID) . "'>" .$category->cat_name ."</a></li>";?>
            <?php endforeach;?>
          </ul>
      </nav>
    </div>
<!--End Header-->
