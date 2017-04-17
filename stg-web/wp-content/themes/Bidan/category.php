
<!--headerを読み込み-->
<?php require_once('variable.php'); ?>
<?php get_header() ;?>
<div id="search-form" class="search-button"><?php get_template_part("searchform");?></div>
<?php $cat_info = get_category( $cat );?>
    <!--記事の表示箇所-->
    <div class=" hidden-xs bread-list">
      <ul class="breadcrumb">
        <li><a href="<?php echo home_url();?>">Bidan</a></li>
          <?php if($cat_info->category_parent == 0):?>
            <?php $category_id = get_cat_ID( $cat_info->name );?>
            <?php echo "<li><a href='" . get_category_link( $category_id ) . "'>" . wp_specialchars( $cat_info->name ) ."</a></li>";?>
          <?php else:?>
            <?php $category_id = get_cat_ID( $cat_info->name );$parent_category_id = get_cat_ID( $parentCat->name );$parentCat = get_category($cat_info->category_parent);?>
            <?php echo "<li><a href='" . get_category_link( $parentCat ) ."'>" . wp_specialchars( $parentCat->name) . "</a></li>";?>
            <?php echo "<li><a href='" . get_category_link( $category_id ) . "'>" . wp_specialchars( $cat_info->name ) ."</a></li>";?>
          <?php endif;?>
      </ul>
    </div>
    <div class="container-fuild category-description">
      <div class="clearfix description-child">
        <img class="row img-responsive col-md-3 col-sm-3" src="<?php echo $categoryThumnail[wp_specialchars( $cat_info->name )]?>">
        <p class="category-title">▶<?php echo wp_specialchars( $cat_info->name );?></p>
        <p class="category-description"><?php echo category_description();?></p>
        <ul class="list-unstyled list-inline">
          <?php foreach(get_term_children($cat_info->cat_ID , 'category') as $childCategory):?>
            <?php $childCategoryName = get_the_category_by_ID($childCategory); ?>
            <?php $childCategoryId = get_cat_ID($childCategoryName);?>
            <?php $childCategoryPath = get_category_link($childCategoryId); ?>
            <?php echo '<li><a href= ' . "$childCategoryPath" .  '><span><i class="glyphicon glyphicon-tag">' . $childCategoryName . '</i></span></a></li>';?>
          <?php endforeach;?>
        </ul>
      </div>
    </div>
    <div class="container-fluid">
      <div class="col-md-8 col-sm-8 article-list">
        <div class="col-md-12 col-sm-12 top_title"><h1 class="row">カテゴリ:<?php echo wp_specialchars( $cat_info->name );?>のピックアップ</h1></div>
          <?php if(have_posts()): while(have_posts()):the_post(); ?>
              <div class="row article_box_wrapper">
                <article class="row col-md-12 col-sm-12 article_box">
                  <?php if ( has_post_thumbnail() ) : ?>
                    <div class="col-md-3 col-sm-3 col-xs-4"><?php the_post_thumbnail('thumbnail', array('class' => 'img-responsibe'));?></div>
                  <?php  else: ?>
                    <div class="col-md-3 col-sm-3 col-xs-4"><img src="<?php echo get_template_directory_uri();?>/img/noimage.png" class="img-responsibe"></img></div>
                  <?php endif;?>
                  <?php $cats = get_the_category(); $cat = $cats[0]; ?>
                  <?php if($cat->parent): ?>
                    <div class="col-md-9 col-sm-9 hidden-xs"><p class="row article_category"><span><a href=""><?php $parent = get_category($cat->parent);echo $parent->cat_name;?></a></span></p></div>
                  <?php else:?>
                    <div class="col-md-9 col-sm-9 hidden-xs"><p class="row article_category"><span><a href=""><?php echo $cat->cat_name;?></a></span></p></div>
                  <?php endif;?>
                  <div class="col-md-9 col-sm-9 col-xs-8"><h2 class="row"><span><a href="<?php the_permalink();?>"><?php the_title();?></a></span></h2></div>
                  <div class="col-md-9 col-sm-9">
                    <p class="row article_summary text-muted hidden-xs">
                      みなさんは除毛クリームで髭の処理をしたことがありすか?髭に使う場合は正しく使わないと肌は荒れ、使う前よりひどくなってしまうこともあります。そこで今回は除毛クリームで髭を処理するときの、失敗しないポイントを紹介します。ポイントを押さえて髭を綺麗に除毛しましょう。
                    </p>
                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-8"><p class="row writer_name text-muted">ライター:<?php the_author();?></p></div>
                </article>
              </div>
          <?php endwhile; endif; ?>
      </div>
      <div class="visible-xs pagination-wrapper text-center">
      <?php wp_pagination(); ?>
      </div>
      <?php get_sidebar();?>
      <?php get_footer();?>
