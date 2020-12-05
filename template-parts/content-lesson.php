<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- Шапка потса -->
	<header class="entry-header <?php echo get_post_type();?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), url(<?php if( has_post_thumbnail() ) { echo get_the_post_thumbnail_url(); }
    	else {
            echo get_template_directory_uri().'/assets/images/img-default.png';
		} ?> ) no-repeat center; background-size: cover">

		<div class="container">
			<div class="post-header-wrapper">
				<div class="post-header-nav">
						<?php
							//выводим категорию
							foreach (get_the_category() as $category) {
								printf(
									'<a href="%s" class="category-link %s">%s</a>',
									esc_url( get_category_link( $category ) ),
									esc_html( $category -> slug ),
									esc_html( $category -> name ),
								);
							}

	
					?>
				</div>
				<div class="post-header-title-wrapper">
				
					<?php
					//Проверяем: точно ли мы на странице поста?
						if ( is_singular() ) :
							the_title( '<h1 class="post-title">', '</h1>' );
						else :
							the_title( '<h2 class="post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
						endif;?>
				</div>
				<div class="news-feedback post-header-info">
					<svg width="15" height="15" class="icon clock-icon" fill="#BCBFC2">
						<use
							xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#clock">
						</use>
					</svg>			
					<span class="date"><?php the_time( 'j F , H:i' );?></span>

				</div>


				<div class="post-author">
					<div class="post-author-info">
						<?php $author_id = get_the_author_meta('ID'); ?>
						<img src="<?php echo get_avatar_url($author_id)?>" href="#" class="post-author-avatar"
							alt="author-avatar"></img>						
						<span class="post-author-name"><?php the_author(); ?></span>
						<span class="post-author-rank">Должность</span>
						<span class="post-author-posts">
						
							<?php plural_form(
								count_user_posts($author_id),
								// Варианты написания окончаний для слов количества (1,2 и 5)
								array('статья','статьи','статей')
							);?> 
						</span>
					</div>
					<a href="<?php echo get_author_posts_url($author_id)?>" class="post-author-link">
						Страница автора
					</a>
				</div>
			</div>
		</div>
    </header>

	<div class="container">
		<!-- Содержимое поста -->
		<div class="post-content">
			<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universal-example' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Страницы:', 'universal-example' ),
						'after'  => '</div>',
					)
				);
			?>
		</div>
		<!-- .post-content -->
	</div>
	<div class="container">
		<footer class="post-footer">
			<?php
				$tags_list = get_the_tag_list( '', esc_html_x( '', 'list item separator', 'universal-example' ) );
					if ( $tags_list ) {
						/* translators: 1: list of tags. */
						printf( '<span class="tags-links">' . esc_html__( '%1$s', 'universal-example' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				//Ссылки на соцсети
				meks_ess_share();
			?>
		</footer>
	</div>
</article>

