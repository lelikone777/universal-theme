<?php get_header(); ?>

<div class="container">
    <h1 class="search-title" style="font-size: 40px; color: #dabdab">Результаты поиска по запросу:</h1>
    <div class="favourites">
        <ul>
            <?php while ( have_posts() ){ the_post(); ?>
                <li>
                    <a href="<?php echo get_the_permalink(); ?>">
                        <h2> <?php the_title();?> </h2>
                    </a>
                </li>
            <?php } ?>
            <?php if ( ! have_posts() ){ ?>
                Записей нет.
            <?php } ?>
        </ul>
    </div>
</div>


<?php get_footer(); 