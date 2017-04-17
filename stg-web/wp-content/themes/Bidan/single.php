
<!--headerを読み込み-->
<?php get_header() ;?>
<div id="search-form" class="search-button"><?php get_template_part("searchform");?></div>
<div class="hidden-xs bread-list">
  <ul class="breadcrumb">
    <li><a href="<?php echo home_url();?>">Bidan</a></li>
    <?php $cats = get_the_category(); $cat_1 = get_the_category()[0]; $cat_2 = get_the_category()[1];?>
        <?php //cat_1とcat_2の方で、親カテゴリでの方を$parentに代入;?>
        <?php if($cat_1->parent):?>
          <?php //もしそのカテゴリが親カテゴリを持っていたら;?>
          <?php $parent = get_category($cat_1->parent);$parent_category =  $parent->cat_name;$parent_category_id = $cat_2->cat_ID;$child_category = $cat_1->cat_name;$child_category_id = $cat_1->cat_ID;?>
          <?php echo "<li><a href='" . get_category_link( $parent_category_id ) . "'>" . $parent_category ."</a></li>";?>
          <?php echo "<li><a href='" . get_category_link( $child_category_id ) . "'>" . $child_category ."</a></li>";?>
        <?php else:?>
          <?php $parent = get_category($cat_2->parent);$parent_category =  $parent->cat_name;$parent_category_id = $cat_1->cat_ID;$child_category = $cat_2->cat_name;$child_category_id = $cat_2->cat_ID;?>
          <?php echo "<li><a href='" . get_category_link( $parent_category_id ) . "'>" . $parent_category ."</a></li>";?>
          <?php echo "<li><a href='" . get_category_link( $child_category_id ) . "'>" . $child_category ."</a></li>";?>
        <?php endif;?>
    <li><a href=""><?php the_title();?></a></li>
  </ul>
</div>
<?php $counter = 0;?>
<?php if(have_posts()): while(have_posts()): the_post(); ?>
  <?php if($counter == 0):?>
<div class="clearfix container-fluid article-wrapper">
  <div class="col-md-8 col-sm-8 article-content">
    <ul class="tags-list list-inline list-unstyled text-right">
      <?php $posttags = get_the_tags(); $count=0;?>
      <?php if ($posttags):foreach($posttags as $tag) :?>
        <?php $count++; ?>
        <?php if (3 >= $count) :?>
          <?php echo  "<li><span><i class='glyphicon glyphicon-tag'><a href='/archives/tag/"  . $tag->slug . "'>" . $tag->name . "</a></i></span></li>";?>
        <?php endif;?>
      <?php endforeach;endif;?>
    </ul>
    <h1><?php the_title();?></h1>
    <p class="content-title"><?php echo get_post_meta($post->ID, "description", true); ?></p>
    <div class="the-content">
      <?php the_content();?>
      <img id="toTopButton" class="toTopButton" src="<?php echo get_template_directory_uri();?>/img/toTopButton.png">
    </div>
    <div class="container-fluid related-posts-wrapper">
      <h3>おすすめ関連記事</h3>
      <?php get_template_part("get-related-post");?>
    </div>
  </div>
  <div class="hidden-xs"><?php get_sidebar();?></div>
  <?php $counter = $counter + 1;?>
  <?php endif;?>
  <?php endwhile; endif;?>
</div>
</div>
<?php get_footer();?>
