<div class="col-md-4 col-sm-4 col-xs-12 sidebar">
  <aside>
    <div>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-9949454233157265"
                 data-ad-slot="9172723233"
                 data-ad-format="auto"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    <div>
          <h3>おすすめ記事</h3>
          <ul class="list-unstyled">
            <?php $cat_now = get_the_category(); $cat_now = $cat_now[0]; $parent_id = $cat_now->category_parent; $now_id = $cat_now->cat_ID; $now_name = $cat_now->cat_name; $posts = get_posts("numberposts=30000&category='".$parent_id ."'");?>
            <?php $counter = 0;?>
            <?php if($posts): foreach($posts as $post): setup_postdata($post);?>
              <?php if(get_post_meta(get_the_ID(),'recommend',true) == 1 && $counter < 10):?>
                <li>
                  <div class="clearfix">
                    <?php if( has_post_thumbnail() ):?>
                      <div class="col-md-3 col-sm-3 col-xs-4"><?php the_post_thumbnail('thumbnail',array('class' => 'img_responsibe'));?></div>
                    <?php else:?>
                      <div class="col-md-3 col-sm-3 col-xs-4"><img class="img-responsibe" src="<?php echo get_template_directory_uri();?>/img/noimage.png"></div>
                    <?php endif;?>
                    <h2 class="col-md-9 col-sm-9 col-xs-8"><a class="sidebar-title" href="<?php the_permalink();?>"><span class="ranking-num"><?php echo $counter + 1;?> </span><?php the_title();?></a></h2>
                  </div>
                </li>
              <?php $counter = $counter + 1;?>
              <?php endif;?>
            <?php endforeach;endif;?>
          </ul>
      </div>

          <div>
            <h3>人気記事ランキング</h3>
            <ul class="list-unstyled">
              <?php $counter = 0;?>
              <?php $args = array( 'posts_per_page' => 9,'orderby' => 'meta_value_num','meta_key' =>'views','order' => 'DESC',);?>
              <?php $my_query = new WP_Query( $args );if($my_query->have_posts()) : while($my_query->have_posts()) : $my_query->the_post(); ?>
                <li>
                  <div class="clearfix">
                    <?php if( has_post_thumbnail() ):?>
                      <div class="col-md-3 col-sm-3 col-xs-4"><?php the_post_thumbnail('thumbnail',array('class' => 'img_responsibe'));?></div>
                    <?php else:?>
                      <div class="col-md-3 col-sm-3 col-xs-4"><img class="img-responsibe" src="<?php echo get_template_directory_uri();?>/img/noimage.png"></div>
                    <?php endif;?>
                    <h2 class="col-md-9 col-sm-9 col-xs-8"><a class="sidebar-title" href="<?php the_permalink();?>"><span class="ranking-num"><?php echo $counter + 1;?> </span><?php the_title();?></a></h2>
                  </div>
                </li>
                <?php $counter = $counter + 1;?>
              <?php endwhile; endif; wp_reset_postdata(); ?>
            </ul>
        </div>
        <div>
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-9949454233157265"
                     data-ad-slot="9172723233"
                     data-ad-format="auto"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
  </aside>
</div>
<!--end Sidebar-->
