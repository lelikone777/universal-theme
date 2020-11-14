<?php get_header(); ?>
<main class="front-page-header">
    <div class="container">
        <div class="hero">
            <div class="left">
                <?php
        //Объявляем глобальную переменную
        global $post;

        $myposts = get_posts([ 
            'numberposts' => 1,
            'category_name' => 'javascript, css, html, web-design',
        ]);

        //Проверяем, есть ли посты
        if( $myposts ){
            //Если есть, перебираем цикл
            foreach( $myposts as $post ){
                setup_postdata( $post );
                ?>

                <img src="<?php the_post_thumbnail_url() ?>" alt="" class="post-thumb">
                <?php $author_id = get_the_author_meta('ID'); ?>
                <a href="<?php echo get_author_posts_url($author_id)?>" class="author">
                    <img src="<?php echo get_avatar_url($author_id)?>" href="#" class="avatar" alt="avatar"></img>
                    <div class="author-bio">
                        <span class="author-name"><?php the_author(); ?></span>
                        <span class="author-rank">Должность</span>
                    </div>
                </a>

                <div class="post-text">
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
                    <h2 class="post-title"><?php echo mb_strimwidth(get_the_title(), 0, 50, '...') ?></h2>
                    <a href="<?php echo get_the_permalink(); ?>" class="more">Читать далее</a>
                </div>

                <?php 
            }
        } else {
            // Если Постов не найдено
            ?> <p>Постов нет</p> <?php
        }

        wp_reset_postdata(); // Сбрасываем $post
        ?>

            </div>
            <div class="right">
                <h3 class="recommend">
                    Рекомендуем
                </h3>
                <ul class="posts-list">
                    <?php
                    //Объявляем глобальную переменную
                    global $post;

                    $myposts = get_posts([ 
                        'numberposts' => 5,
                        'offset' => 1,
                        'category_name' => 'javascript, css, html, web-design',
                    ]);

                    //Проверяем, есть ли посты
                    if( $myposts ){
                        //Если есть, перебираем цикл
                        foreach( $myposts as $post ){
                            setup_postdata( $post );
                            ?>

                    <li class="post">
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
                        <a class="post-permalink" href="<?php echo get_the_permalink(); ?>" <h4 class="post-title">
                            <?php echo mb_strimwidth(get_the_title(), 0, 60, '...') ?> </h4>
                        </a>
                    </li>

                    <?php 
                            }
                        } else {
                            // Если Постов не найдено
                            ?> <p>Постов нет</p> <?php
                        }

                        wp_reset_postdata(); // Сбрасываем $post
                        ?>

                </ul>

            </div>
        </div>
    </div>
</main>

<!-- //------------ -->
<div class="container">
    <ul class="article-list">
        <?php
                    //Объявляем глобальную переменную
                    global $post;

                    $myposts = get_posts([ 
                        'numberposts' => 4,
                        'category_name' => 'articles',
                        
                    ]);

                    //Проверяем, есть ли посты
                    if( $myposts ){
                        //Если есть, перебираем цикл
                        foreach( $myposts as $post ){
                            setup_postdata( $post );
                            ?>

        <li class="article-item">
            <a class="article-permalink" href="<?php echo get_the_permalink(); ?>">
                <h4 class="article-title"> <?php echo mb_strimwidth(get_the_title(), 0, 50, '...') ?> </h4>
            </a>
            <img width="65" height="65" src=" <?php if( has_post_thumbnail() ) {
                                    echo get_the_post_thumbnail_url(null, 'thumb');
                                }
                                else {
                                    echo get_template_directory_uri().'/assets/images/img-default.png';
                                } ?>" alt="">
        </li>

        <?php 
                            }
                        } else {
                            // Если Постов не найдено
                            ?> <p>Постов нет</p> <?php
                        }

                        wp_reset_postdata(); // Сбрасываем $post
                        ?>

    </ul>

    <div class="main-grid">
        <!-- цикл для разных постов -->
        <ul class="article-grid">
            <?php		
            global $post;
            //формируем посты в базу данных
            $query = new WP_Query( [
            //подключаем 7 постов
                'posts_per_page' => 7,
                'category__not_in' => 22,
            ] );
            //проверяем, есть ли посты
            if ( $query->have_posts() ) {
                // создаем переменную счетчик постов
                $cnt = 0;
                //пока посты есть, выводим их
                while ( $query->have_posts() ) {
                    $query->the_post();
                    // увеличиваем счетчик постов
                    $cnt++;
                    switch ($cnt) {
                        //выводим первый пост
                        case '1': ?>
            <li class="article-grid-item article-grid-item-1">
                <a href="<?php the_permalink()?>" class="article-grid-permalink">
                    <!-- <img class="article-grid-thumb" src="<?php echo get_the_post_thumbnail_url() ?>" alt=""> -->
                    <span class="category-name"> <?php $category = get_the_category(); echo $category [0]->name; ?>
                    </span>
                    <h4 class="article-grid-title"> <?php echo mb_strimwidth(get_the_title(), 0, 50, '...')?></h4>
                    <p class="article-grid-excerpt">
                        <?php echo mb_strimwidth(get_the_excerpt(), 0, 160, '...') ?>
                    </p>
                    <div class="article-grid-info">
                        <div class="author">
                            <?php $author_id = get_the_author_meta('ID'); ?>
                            <img src="<?php echo get_avatar_url($author_id)?>" alt="" class="author-avatar">
                            <span class="author-name"> <strong> <?php the_author() ?></strong> :
                                <?php the_author_meta('description') ?> </span>
                        </div>
                        <div class="comments">
                            <!-- <svg width="19" height="15" class="icon comments-icon">
                                                    <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#comment"></use>
                                                </svg> -->
                            <svg width="19" height="15" class="icon comments-icon" fill="#BCBFC2">
                                <use
                                    xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#Comment">
                                </use>
                            </svg>
                            <span class="comments-counter"> <?php comments_number('0', '1', '%')  ?> </span>
                        </div>
                    </div>
                </a>
            </li>
            <?php
                        break;
                        //выводим второй пост
                        case '2': ?>
            <li class="article-grid-item article-grid-item-2">
                <img src="<?php if( has_post_thumbnail() ) {
                                    echo get_the_post_thumbnail_url();
                                }
                                else {
                                    echo get_template_directory_uri().'/assets/images/img-default.png';
                                }  ?>" alt="" class="article-grid-thumb">
                <a href="<?php the_permalink()?>" class="article-grid-permalink">
                    <span class="tag">
                        <?php $posttags = get_the_tags();
                                            if ($posttags) {
                                                echo $posttags[0]->name . ' ';
                                            } ?>
                    </span>
                    <span class="category-name"> <?php $category = get_the_category(); echo $category[0]->name; ?>
                    </span>
                    <h4 class="article-grid-title"> <?php the_title()?></h4>
                    <div class="article-grid-info">
                        <div class="author">
                            <?php $author_id = get_the_author_meta('ID'); ?>
                            <img src="<?php echo get_avatar_url($author_id)?>" alt="" class="author-avatar">
                            <div class="author-info">
                                <span class="author-name"> <strong> <?php the_author() ?></strong></span>
                                <span class="date"><?php the_time( 'j F' );?></span>
                                <div class="comments">
                                    <svg width="19" height="15" class="icon comments-icon" fill="#BCBFC2">
                                        <use
                                            xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#Comment">
                                        </use>
                                    </svg>
                                    <span class="comments-counter"> <?php comments_number('0', '1', '%')  ?> </span>
                                </div>
                                <div class="likes">
                                    <svg width="19" height="15" class="icon likes-icon" fill="#BCBFC2">
                                        <use
                                            xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#heart">
                                        </use>
                                    </svg>
                                    <span class="likes-counter"><?php comments_number('0', '1', '%')  ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            <?php
                        break;
                        //выводим третий пост <!-- Вывода постов, функции цикла: the_title() и т.д. -->
                        case '3' : ?>
            <li class="article-grid-item article-grid-item-3">
                <a href="<?php the_permalink()?>" class="article-grid-permalink">
                    <img src="<?php if( has_post_thumbnail() ) {
                                    echo get_the_post_thumbnail_url();
                                }
                                else {
                                    echo get_template_directory_uri().'/assets/images/img-default.png';
                                }  ?>" alt="" class="article-thumb">
                    <h4 class="article-grid-title"> <?php echo the_title()?> </h4>
                </a>
            </li>
            <?php
                        break;
                        // выводим остальные посты
                        default: ?>
            <li class="article-grid-item article-grid-item-default">
                <a href="<?php the_permalink()?>" class="article-grid-permalink">
                    <h4 class="article-grid-title"> <?php echo mb_strimwidth(get_the_title(), 0, 50, '...')?> </h4>
                    <p class="article-grid-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 44, '...') ?> </p>
                    <span class="article-date"><?php the_time( 'j F' );?></span>
                </a>
            </li>
            <?php
                        break;
                    }
                    ?>

            <?php 
        }
    } else {
        // Постов не найдено
    }

    wp_reset_postdata(); // Сбрасываем $post
    ?>
        </ul>
        <!-- подключаем верхний сайдбар -->
        <?php get_sidebar('home-top'); ?>
    </div>
</div>


<?php		
global $post;

$query = new WP_Query( [
    'posts_per_page' => 1,
    'category_name' => 'investigation',
    ] );

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                ?>
            <!-- Вывода постов, функции цикла: the_title() и т.д. -->
            <section class="investigation" style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.35), rgba(64, 48, 61, 0.75)), url(<?php if( has_post_thumbnail() ) {
                    echo get_the_post_thumbnail_url();
                }
                else {
                    echo get_template_directory_uri().'/assets/images/img-default.png';
                } ;?>) no-repeat center center; background-size: cover">
                <div class="container">
                    <h2 class="investigation-title"><?php the_title(); ?> </h2>
                    <a href="<?php echo get_the_permalink() ?>" class="more">Читать статью</a>
                </div>
            </section>
        <?php 
	    }
    } else {
	// Постов не найдено
    }

wp_reset_postdata(); // Сбрасываем $post
?>

<div class="container">
    <div class="frontpage-bottom">
        <section class="news">
            <ul class="news-list">
                <?php		
                    global $post;

                    $query = new WP_Query( [
                        'posts_per_page' => 6,
                    ] );

                    if ( $query->have_posts() ) {
                        while ( $query->have_posts() ) {
                            $query->the_post();
                            ?>
                <!-- Вывода постов, функции цикла: the_title() и т.д. -->

                <!-- <a href="<?php echo get_the_permalink() ?> " class="news-item-permalink"> -->

                <li class="news-item">
                    <!-- <a href="<?php echo get_the_permalink() ?> " class="news-item-permalink"> -->

                    <img src="<?php 
                                if( has_post_thumbnail() ) {
                                    echo get_the_post_thumbnail_url();
                                }
                                else {
                                    echo get_template_directory_uri().'/assets/images/img-default.png';
                                } 
                                ?>" class="news-img">
                    <!-- </a> -->
                    <div class="news-info">
                        <svg class="icon news-icon" width="20" height="20" fill="#BCBFC2">
                            <use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#bookmark"></use>
                        </svg>
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
                        <h4 class="news-title"> <?php the_title()?></h4>
                        <p class="news-excerpt">
                            <?php echo mb_strimwidth(get_the_excerpt(), 0, 160, '...') ?>
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

                            <div class="likes">
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



                <?php 
                        }
                    } else {
                        ?>
                <!-- Вывода постов, функции цикла: the_title() и т.д. -->
                <p>Постов не найдено</p>
                <?php  
                    }

                    wp_reset_postdata(); // Сбрасываем $post
                ?>
            </ul>
        </section>
        <!-- подключаем нижний сайдбар -->
        <?php get_sidebar('home-bottom'); ?>
    </div>
</div>
<div class="special">
    <div class="container">
        <div class="special-grid">

            <?php		
                global $post;
                    $query = new WP_Query( [
                        'posts_per_page' => 1,
                        'category_name' => 'photo-report'
                    ] );
                    if ( $query->have_posts() ) {
                        while ( $query->have_posts() ) {
                            $query->the_post();
            ?>
            <!-- Вывод поста photo report -->
            <div class="photo-report">

                <!-- Slider main container -->
                <div class="swiper-container photo-report-slider">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <?php $images = get_attached_media( 'image');
                                            foreach($images as $image) {
                                            echo ' <div class="swiper-slide"><img src="';
                                            print_r($image -> guid);
                                            echo '"></div>';
                                        }
                                    ?>

                    </div>
                    <!-- If we need pagination -->
                    <div class="swiper-pagination"></div>
                </div>
                <div class="photo-report-content">
                    <?php 
                        foreach (get_the_category() as $category) {
                            printf(
                                '<a href="%s" class="category-link">%s</a>',
                                esc_url( get_category_link( $category ) ),
                                esc_html( $category -> name ),
                                );
                            }
                        ?>
                    <?php $author_id = get_the_author_meta('ID'); ?>
                    <a href="<?php echo get_author_posts_url($author_id)?>" class="author">
                        <img src="<?php echo get_avatar_url($author_id)?>" href="#" class="author-avatar"
                            alt="author-avatar"></img>
                        <div class="author-bio">
                            <span class="author-name"><?php the_author(); ?></span>
                            <span class="author-rank">Должность</span>
                        </div>
                    </a>
                    <h3 class="photo-report-title"><?php the_title() ?></h3>
                    <a href="<?php echo get_the_permalink() ?>" class="button photo-report-button">
                        <svg width="19" height="15" class="icon photo-report-icon">
                            <use
                                xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#Images">
                            </use>
                        </svg>
                        Смотреть фото
                        <span class="photo-report-counter"><?php echo count($images) ?></span>
                    </a>
                </div>

            </div>
            <?php
                        }
                    } else {
                        //постов не найдено
                    }
                wp_reset_postdata(); // Сбрасываем $post
            ?>

            
        </div class="career">
                <ul class="career-grid">
                <?php		
                    global $post;

                    $query = new WP_Query( [
                        'posts_per_page' => 3,
                        'category_name' => 'career',
                    ] );

                    if ( $query->have_posts() ) {
                        //создаем счетчик постов
                        $cnt = 0;
                        while ( $query->have_posts() ) {
                            $query->the_post();
                            //увеличиваем счетчик постов $cnt
                            $cnt++;
                            switch ($cnt) {
                                case '1':
                                    ?>
                                    <img src="<?php echo get_template_directory_uri().'/assets/images/career.png';?>" alt="career-img" class="career-grid-image"> 
                                    <li class="career-grid-item career-grid-item-1">
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
                                        <!-- <?php echo mb_strimwidth(get_the_title(), 0, 60, '...') ?> </h4>          -->
                                        <h4><?php the_title()?></h4>
                                        <p><?php echo mb_strimwidth(get_the_excerpt(), 0, 80, '...') ?></p>
                                        <a href="<?php echo get_the_permalink(); ?>" class="more career-grid-button">Читать далее</a>
                                    </li>
                                    <?php
                                    break;
                                case '2':
                                    ?> 
                                    <a class="career-grid-permalink" href="<?php echo get_the_permalink();?>">  
                                    <li class="career-grid-item career-grid-item-2">
                                        <h4><?php the_title()?></h4>
                                        <p><?php echo mb_strimwidth(get_the_excerpt(), 0, 50, '...') ?></p>
                                        <span class="article-date"><?php the_time( 'j F' );?></span>
                                    </li>

                                    <?php
                                break;
                                case '3':
                                    ?>

                                    <a class="career-grid-permalink" href="<?php echo get_the_permalink();?>">  
                                    <li class="career-grid-item career-grid-item-3">
                                        <h4><?php the_title()?></h4>
                                        <p><?php echo mb_strimwidth(get_the_excerpt(), 0, 50, '...') ?></p>
                                        <span class="article-date"><?php the_time( 'j F' );?></span>
                                    </li>
                                    
                                    <?php
                                break;
                            }
                        }
                    } else {
                        // Постов не найдено
                       ?> <p>Постов не найдено</p> <?php
                    }

                    wp_reset_postdata(); // Сбрасываем $post
                ?>
            </div>

    </div>
</div>



<div class="container">
    <?php wp_footer();?>
</div>