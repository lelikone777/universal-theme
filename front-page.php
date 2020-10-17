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
                    <?php the_category(); ?>
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
                        <?php the_category(); ?>
                        <a class="post-permalink" href="<?php echo get_the_permalink(); ?>" 
                        <h4 class="post-title">  <?php echo mb_strimwidth(get_the_title(), 0, 60, '...') ?> </h4>
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
                        <h4 class="article-title">  <?php echo mb_strimwidth(get_the_title(), 0, 50, '...') ?> </h4>
                        </a>
                        <img width="65" height="65" src=" <?php echo get_the_post_thumbnail_url( null, 'thumbnail' ) ?>" alt=""> 
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

    <!-- цикл для разных постов -->
    <ul class="article-grid">
    <?php		
        global $post;
        //формируем посты в базу данных
        $query = new WP_Query( [
        //подключаем 7 постов
            'posts_per_page' => 7,
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
                echo $cnt;
                switch ($cnt) {
                    case '1':
                        ?> 
                            <li class="article-grid-item">
                                <a class="article-grid-permalink" href="<?php echo the_permalink() ?>">
                                    <span class="category-name"> <?php $category = get_the_category(); echo $category [0]->name; ?> </span>
                                    <h4 class="article-grid-title"> <?php echo mb_strimwidth(get_the_title(), 0, 50, '...')?>  </h4>
                                </a>
                            </li> 
                        <?php
                    break;
                    
                    default:
                        # code...
                    break;
                }
                ?>
		<!-- Вывода постов, функции цикла: the_title() и т.д. -->
		<?php 
	}
} else {
	// Постов не найдено
}

wp_reset_postdata(); // Сбрасываем $post
?>
    </ul>
</div>
