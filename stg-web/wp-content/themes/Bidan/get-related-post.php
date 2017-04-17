<?php
//カテゴリ情報から関連記事を10個ランダムに呼び出す
$categories = get_the_category($post->ID);
$category_ID = array();
foreach($categories as $category):
  array_push( $category_ID, $category -> cat_ID);
endforeach ;
$args = array(
  'post__not_in' => array($post -> ID),
  'posts_per_page'=> 8,
  'category__in' => $category_ID,
  'orderby' => 'rand',
);
$query = new WP_Query($args); ?>
  <?php if( $query -> have_posts() ): ?>
  <?php while ($query -> have_posts()) : $query -> the_post(); ?>
    <div class="clearfix related-entry col-md-3 col-sm-3 col-xs-12">
      <div class="related-entry-thumb col-md-12 col-sm-12 col-xs-4">
  <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
        <?php if ( has_post_thumbnail() ): ?>
        <?php echo get_the_post_thumbnail($post->ID, 'thumb100');?>
        <?php else:?>
        <img class="col-xs-4" src="<?php echo get_template_directory_uri(); ?>/img/noimage.png" alt="NO IMAGE" title="NO IMAGE" width="100px" />
        <?php endif; ?>
        </a>
      </div><!-- /.related-entry-thumb -->

      <div class="related-entry-content col-md-12 col-sm-12 col-xs-8">
        <h4 class="related-entry-title"> <a href="<?php the_permalink(); ?>"><?php the_title();?></a></h4>
      </div><!-- /.related-entry-content -->
    </div><!-- /.new-entry -->

  <?php endwhile;?>

  <?php else:?>
  <p>記事はありませんでした</p>
  <?php
endif;
wp_reset_postdata();
?>
<br style="clear:both;">
