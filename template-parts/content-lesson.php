<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- Шапка потса -->
	<header class="entry-header <?php echo get_post_type();?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75));  no-repeat center; background-size: cover">

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
				<div class="video">

				<?php 
					$video_link = get_field('video_link'); 
						if (preg_match('/youtu/', $video_link, $match )) {
				?>
							<iframe width="100%" height="450" src="https://www.youtube.com/embed/<?php
							
								$tmp = explode('be/', get_field('video_link'));
								echo end ($tmp);
							?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<?php } elseif  (preg_match('/vimeo/', $video_link, $match )) {
						?>
						<iframe src="https://player.vimeo.com/video/<?php
							$tmp = explode('/video/', get_field('video_link'));
							echo end ($tmp); ?>" width="100%" height="450" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
							
				<?php } 











					// 	function loop(){ 
					// 	$tmp = explode('/video/', get_field('video_link'));	
					// 	echo end ($tmp);
					// }

					// 	echo '<iframe src="https://player.vimeo.com/video/' . loop() . '" width="100%" height="450" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>';} ?>

				</div>


								

				<div class="lesson-header-title-wrapper">
				
					<?php
					//Проверяем: точно ли мы на странице поста?
						if ( is_singular() ) :
							the_title( '<h1 class="lesson-header-title">', '</h1>' );
						else :
							the_title( '<h2 class="lesson-header-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
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

