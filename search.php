<?php get_header(); ?>

<div class="container">
    <h1 class="search-title">Результаты поиска по запросу:</h1>
    <div class="frontpage-bottom">
        <div class="news-wrapper">
            <div class="news digest">
                <ul class="news-list digest-list">
                    <?php while ( have_posts() ){ the_post(); ?>
                        <li class="news-item">
                            
                            <!-- <a href="<?php echo get_the_permalink() ?> " class="news-item-permalink"> --><!-- </a> -->

                            <img src="<?php 
                                        if( has_post_thumbnail() ) {
                                            echo get_the_post_thumbnail_url();
                                        }
                                        else {
                                            echo get_template_directory_uri().'/assets/images/img-default.png';
                                        } 
                            ?>" class="news-img">
                            
                            <div class="news-info">
                                <span class="news-category-name">

                                    <?php 
                                    foreach (get_the_category() as $category) {
                                        printf(
                                            '<a href="%s" class="category-link %s">%s</a>',
                                            esc_url( get_category_link( $category ) ),
                                            esc_html( $category -> slug ),
                                            esc_html( $category -> name ),
                                            );
                                        }
                                    ?>
                                </span>

                                <a href="<?php echo get_the_permalink() ?>" class="news-item-permalink"> 
                                    <h4 class="news-title"> <?php echo mb_strimwidth(get_the_title(), 0, 70, '...')?> </h4>
                                </a> 
                                <p class="news-excerpt">
                                    <?php echo mb_strimwidth(get_the_excerpt(), 0, 100, '...') ?>
                                </p>


                                <div class="news-feedback">
                                    <span class="date"><?php the_time( 'j F' );?></span>

                                    <div class="comments">
                                        <svg width="19" height="15" class="icon comments-icon" fill="#BCBFC2">
                                            <use
                                                xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#Comment">
                                            </use>
                                        </svg>
                                        <span class="comments-counter"> <?php comments_number('0', '1', '%')  ?> </span>
                                    </div>

                                    <div class="likes post-header-likes">
                                        <svg width="19" height="15" class="icon likes-icon" fill="#BCBFC2">
                                            <use
                                                xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#heart">
                                            </use>
                                        </svg>
                                        <span class="likes-counter"><?php comments_number('0', '1', '%') ?> </span>
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </li> 
                    <?php } ?>
                    <?php if ( ! have_posts() ){ ?>
                        Записей нет.
                    <?php } ?>
                </ul>  
            </div>
           <?php
            $args = array(
                'prev_text'    => '&larr; Назад',
                'next_text'    => 'Вперёд &rarr;',
            );
             the_posts_pagination( $args ); ?>
        </div>
        <?php get_sidebar('home-bottom'); ?>
    </div>
</div>


<?php get_footer(); 