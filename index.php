<?php 
get_header('post'); ?>
    <div class="container">
       <h1>index.php<<<</h1>
        <svg width="19" height="15" class="icon likes-icon" fill="#BCBFC2">
            <use
                xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#arrow-prev">
            </use>
        </svg>
        <p>назад</p>
        <svg width="19" height="15" class="icon likes-icon" fill="#BCBFC2">
            <use 
                xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#arrow-next">
            </use>
        </svg>
        <p>вперед</p>
    </div>
<?php get_footer();
