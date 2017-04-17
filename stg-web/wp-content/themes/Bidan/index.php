<?php get_header();?>
<!--記事の表示箇所-->
<?php $counter = 0;?>
<?php $pickup = array('meta_query' => array(array('key'=>'my_pickup','value'=>'1')));?>
<?php $pickup_query = new WP_Query($pickup);?>
<div id="search-form" class="search-button"><?php get_template_part("searchform");?></div>
<div class="container-fuild width-adjuster-right width-adjuster-left">
  <!--Pickup Image-->
  <div class="col-md-12 col-sm-12 top-pickup-image">
      <ul class="row list-unstyled list-inline">
        <?php while ( $pickup_query->have_posts() ) : $pickup_query->the_post(); ?>
          <?php $postid =  get_the_ID();?>
          <?php $thumbnail_id = get_post_thumbnail_id($postid);?>
          <?php if($counter == 0):?>
            <li class="col-md-4 col-sm-4 col-sm-4 col-xs-12" style="background-image:url(<?php echo wp_get_attachment_image_src($thumbnail_id,true)[0];?>);">
              <?php if ( has_post_thumbnail() ) : ?>

              <?php  else: ?>
              <?php endif;?>
              <p><a class="col-md-10 col-sm-10 col-xs-10" href="<?php the_permalink();?>"><?php the_title();?></a></p>
            </li>
          <?php $counter = $counter + 1;?>
          <?php else:?>
            <li class="col-md-4 col-sm-4 col-sm-4 hidden-xs" style="background-image:url(<?php echo wp_get_attachment_image_src($thumbnail_id,true)[0];?>);">
              <?php if(has_post_thumbnail()) :?>
              <?php else:?>
              <?php endif;?>
              <p><a class="col-md-10 col-sm-10" href="<?php the_permalink();?>"><?php the_title();?></a></p>
            </li>
          <?php endif;?>
        <?php endwhile; ?>
      </ul>
  </div>
</div>
<div class="container-fluid">
  <div class="col-md-8 col-sm-8 article-list">
    <div class="col-md-12 col-sm-12 top_title"><h1 class="row"><?php echo date('Y/m/d');?>のピックアップ</h1></div>
      <?php if(have_posts()): while(have_posts()):the_post(); ?>
        <?php $postid =  get_the_ID();?>
        <?php $thumbnail_id = get_post_thumbnail_id($postid);?>
          <div class="row article_box_wrapper">
            <article class="row col-md-12 col-sm-12 article_box">
              <?php if ( has_post_thumbnail() ) : ?>
                <div class="col-md-3 col-sm-3 col-xs-4 post_thumbnail" style="background-image:url(<?php echo wp_get_attachment_image_src($thumbnail_id,true)[0];?>);"></div>
              <?php  else: ?>
                <div class="col-md-3 col-sm-3 col-xs-4　post_thumbnail" style="background-image:url(<?php echo wp_get_attachment_image_src($thumbnail_id,true)[0];?>);"></div>
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
                  <?php echo get_post_meta($post->ID, "description", true); ?>
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
