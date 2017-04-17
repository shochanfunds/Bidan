
<!--headerを読み込み-->
<?php get_header() ;?>
    <div id="search-form" class="search-button"><?php get_template_part("searchform");?></div>
    <!--記事の表示箇所-->
    <div class="container-fuild category-description">
      <div class="clearfix description-child">
        <?php $posttags = get_the_tags();?>
        <p class="category-title">▶<?php if ( $posttags[0] ) {echo $posttags[0]->name;}?></p>
        <p class="category-description">「<?php if($posttags[0]){echo $posttags[0]->name;}?>」と一緒によく使われているタグ</p>
        <?php the_tags('<ul class="list-inline  tags-list col-sm-8"><li><span><i class="glyphicon glyphicon-tag">','</i></span></li><li><span><i class="glyphicon glyphicon-tag">','</i></span></li></ul>'); ?>
      </div>
    </div>
    <div class="container-fluid">
      <div class="col-md-8 col-sm-8 article-list">
        <div class="col-md-12 col-sm-12 top_title"><h1 class="row">タグ:<?php if($posttags[0]){echo $posttags[0]->name;}?>のピックアップ</h1></div>
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
