<?php

if ( ! function_exists( 'universal_theme_setup' ) ) :
    function universal_theme_setup() {
        //Добавление тэга Title
        add_theme_support( 'title-tag' );

        //Добавление миниатюр
        add_theme_support( 'post-thumbnails', array( 'post' ) );

        //добавление пользовательского логотипа
        add_theme_support( 'custom-logo', [
            'width'       => 190,
            'flex-height' => true,
            'header-text' => 'universal',
            'unlink-homepage-logo' => true, // WP 5.5
        ] );

        //регистрация меню
            register_nav_menus( [
                'header_menu' => 'Меню в шапке',
                'footer_menu' => 'Меню в подвале'
            ] );
        
        } 
endif;
add_action( 'after_setup_theme', 'universal_theme_setup' );


/* Подключение сайдбара (Виджеты).*/

function universal_example_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной странице сверху', 'universal-theme' ),
			'id'            => 'main-sidebar-top',
			'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной странице снизу', 'universal-theme' ),
			'id'            => 'main-sidebar-bottom',
			'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на странице поста с последними постами', 'universal-theme' ),
			'id'            => 'sidebar-post-recent',
			'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Меню в подвале', 'universal-theme' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Добавьте меню сюда.', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="footer-menu-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Текст в подвале', 'universal-theme' ),
			'id'            => 'sidebar-footer-text',
			'description'   => esc_html__( 'Добавьте текст сюда.', 'universal-theme' ),
			'before_widget' => '<section id="%1$s" class="footer-text %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
}

add_action( 'widgets_init', 'universal_example_widgets_init' );


/**
 * >>>>>>>>>>>>>>>>> Добавление нового виджета Downloader_Widget.
 */
class Downloader_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'downloader_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: downloader_widget
			'Полезные файлы',
			array( 'description' => 'Файлы для скачивания', 'classname' => 'widget-downloader', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_downloader_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_downloader_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
        $description = $instance['description'];
        $link = $instance['link'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
        }
        if ( ! empty( $description ) ) {
            echo '<p>' . $description . '</p>';
        }
        if ( ! empty( $link ) ) {
			echo '<a class="widget-link" href="' . $link . '">
			<img class="widget-link-icon" target="blanc" src="' . get_template_directory_uri(). '/assets/images/download.svg" >
			Скачать</a>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
        $title = @ $instance['title'] ?: 'Полезные файлы';
        $description = @ $instance['description'] ?: 'Описание';
        $link = @ $instance['link'] ?: 'https://some-link.ru';

		?>
<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
        name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Описание:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>"
        name="<?php echo $this->get_field_name( 'description' ); ?>" type="text"
        value="<?php echo esc_attr( $description ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ссылка на файл:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>"
        name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
</p>
<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_downloader_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_downloader_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
<style type="text/css">
.my_widget a {
    display: inline;
}
</style>
<?php
	}

} 
// конец класса Downloader_Widget

// регистрация Downloader_Widget в WordPress
function register_downloader_widget() {
	register_widget( 'Downloader_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );






/**
 * >>>>>>>>>>  Добавление нового виджета social_Widget.
 */
class Social_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'social_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: social_widget
			'Социальные сети',
			array( 'description' => 'Добавьте социальные сети сюда', 'classname' => 'widget-social', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_social_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_social_widget_style' ) );
		}
	}
	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
		$facebook = $instance['facebook'];
		$twitter = $instance['twitter'];
		$youtube = $instance['youtube'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
        }
        if ( ! empty( $facebook ) ) {
            echo '<div class="widget-social-wrapper"> <a class="widget-social-icon" target="blanc" href="' . $facebook . '"><img src="' . get_template_directory_uri(). '/assets/images/facebook.svg" ></a>';
        }
        if ( ! empty( $twitter ) ) {
            echo '<a class="widget-social-icon" target="blanc" href="' . $twitter . '"><img src="' . get_template_directory_uri(). '/assets/images/twitter.svg" ></a>';
		}
		if ( ! empty( $youtube ) ) {
            echo '<a class="widget-social-icon" target="blanc" href="' . $youtube . '"><img src="' . get_template_directory_uri(). '/assets/images/youtube.svg" ></a></div>';
        }
		echo $args['after_widget'];
	}
	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
        $title = @ $instance['title'] ?: 'Наши соцсети';
		$facebook = @ $instance['facebook'] ?: 'https://www.facebook.com/';
		$twitter = @ $instance['twitter'] ?: 'https://www.twitter.com/';
		$youtube = @ $instance['youtube'] ?: 'https://www.youtube.com/';
       
		?>
<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
        name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Страница фейсбук:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>"
        name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text"
        value="<?php echo esc_attr( $facebook ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Страница твиттер:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>"
        name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text"
        value="<?php echo esc_attr( $twitter ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Страница youtube:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>"
        name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text"
        value="<?php echo esc_attr( $youtube ); ?>">
</p>
<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
		$instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
		$instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_social_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_social_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
<style type="text/css">
.my_widget a {
    display: inline;
}
</style>
<?php
	}

} 
// конец класса Social_Widget

// регистрация social_Widget в WordPress
function register_social_widget() {
	register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );











/**
 * >>>>>>>>>>  Добавление нового виджета social_Widget22222.
 */
class Social_Widget2 extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'social_widget2', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: social_widget2
			'Социальные сети2',
			array( 'description' => 'Добавьте социальные сети2 сюда', 'classname' => 'widget-social2', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_social_widget2_scripts' ));
			add_action('wp_head', array( $this, 'add_social_widget2_style' ) );
		}
	}
	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
		$facebook = $instance['facebook'];
		$twitter = $instance['twitter'];
		$youtube = $instance['youtube'];
		$instagram = $instance['instagram'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
        }
        if ( ! empty( $facebook ) ) {
            echo '<div class="widget-social-wrapper"> <a class="widget-social-icon" target="blanc" href="' . $facebook . '"><img src="' . get_template_directory_uri(). '/assets/images/facebook.svg" ></a>';
        }
        if ( ! empty( $twitter ) ) {
            echo '<a class="widget-social-icon" target="blanc" href="' . $twitter . '"><img src="' . get_template_directory_uri(). '/assets/images/twitter.svg" ></a>';
		}
		if ( ! empty( $youtube ) ) {
            echo '<a class="widget-social-icon" target="blanc" href="' . $youtube . '"><img src="' . get_template_directory_uri(). '/assets/images/youtube.svg" ></a>';
		}
		if ( ! empty( $instagram ) ) {
            echo '<a class="widget-social-icon" style="width:50px, height:50px" target="blanc" href="' . $instagram . '"><img src="' . get_template_directory_uri(). '/assets/images/insta.svg" ></a></div>';
        }
		echo $args['after_widget'];
	}
	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
        $title = @ $instance['title'] ?: 'Наши соцсети';
		$facebook = @ $instance['facebook'] ?: 'https://www.facebook.com/';
		$twitter = @ $instance['twitter'] ?: 'https://www.twitter.com/';
		$youtube = @ $instance['youtube'] ?: 'https://www.youtube.com/';
		$instagram = @ $instance['instagram'] ?: 'https://www.instagram.com/';
       
		?>
<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
        name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Страница фейсбук:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>"
        name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text"
        value="<?php echo esc_attr( $facebook ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Страница твиттер:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>"
        name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text"
        value="<?php echo esc_attr( $twitter ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Страница youtube:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>"
        name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text"
        value="<?php echo esc_attr( $youtube ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'Страница instagram:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>"
        name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text"
        value="<?php echo esc_attr( $instagram ); ?>">
</p>
<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
		$instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
		$instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';
		$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_social_widget2_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_social_widget2_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
<style type="text/css">
.my_widget a {
    display: inline;
}
</style>
<?php
	}

} 
// конец класса Social_Widget2

// регистрация social_Widget в WordPress
function register_social_widget2() {
	register_widget( 'Social_Widget2' );
}
add_action( 'widgets_init', 'register_social_widget2' );






/**
 *   >>>>>>>   Добавление нового виджета Recent_Posts_Widget.
 */
class Recent_Posts_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'recent_posts_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: recent_posts_widget
			'Недавно опубликовано',
			array( 'description' => 'Последние посты', 'classname' => 'widget-recent-posts', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_recent_posts_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_recent_posts_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
		$count = $instance['count'];

		echo $args['before_widget'];
		if ( ! empty( $count ) ) {
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="widget-recent-posts-wrapper">';
			global $post;
				$postslist = get_posts( array( 'posts_per_page' => $count, 'order'=> 'ASC', 'orderby' => 'title' ) );
				foreach ( $postslist as $post ){
					setup_postdata($post);
					?>
					<a href="<?php the_permalink() ?>" class="recent-post-link">

						<img src="<?php 
													if( has_post_thumbnail() ) {
														echo get_the_post_thumbnail_url(null,'thumbnail');
													}
													else {
														echo get_template_directory_uri().'/assets/images/img-default.png';
													} 
													?>" class="recent-post-thumb" alt="post-thumb">





						<div class="recent-post-info">
							<h4 class="recent-post-title"><?php echo mb_strimwidth(get_the_title(), 0, 650, '...')?></h4>
							<span class="recent-post-time">
								<?php $time_diff = human_time_diff( get_post_time('U'), current_time('timestamp') );
													echo "$time_diff назад";
													//> Опубликовано 5 лет назад. ?>
							</span>
						</div>
					</a>
				<?php
				}
				wp_reset_postdata();
				echo '</div> <p class="read-more">Read more</p>';
		}
		echo $args['after_widget']; 
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
        $title = @ $instance['title'] ?: 'Недавно опубликовано';
        $count = @ $instance['count'] ?: '7';

		?>
<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
        name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество постов:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>"
        name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
</p>
<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		return $instance;
	}

	// скрипт виджета
	function add_recent_posts_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_recent_posts_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
<style type="text/css">
.my_widget a {
    display: inline;
}
</style>
<?php
	}

} 
// конец класса Recent_Posts_Widget

// регистрация Recent_Posts_Widget в WordPress
function register_recent_posts_widget() {
	register_widget( 'Recent_Posts_Widget' );
}
add_action( 'widgets_init', 'register_recent_posts_widget' );







/**
 *   >>>>>>>   Добавление нового виджета Recent_Posts_Widget2.
 */
class Recent_Posts_Widget2 extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'recent_posts_widget2', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: recent_posts_widget2
			'Сайдбар пост',
			array( 'description' => 'Последние посты', 'classname' => 'recent-post2', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_recent_posts_widget2_scripts' ));
			add_action('wp_head', array( $this, 'add_recent_posts_widget2_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$count = $instance['count'];

		echo $args['before_widget'];
		if ( ! empty( $count ) ) {
			echo ' <div class="container"> <div class="recent-post2-wrapper">';
			global $post;
				$postslist = get_posts( array( 
					'posts_per_page' => $count,
					'order'=> 'ASC',
					'orderby' => 'title',
					'category_name' => 'articles', 
				) );
				foreach ( $postslist as $post ){
					setup_postdata($post);
					?>
					<div class="recent-post2-item">
						<a href="<?php the_permalink() ?>" class="recent-post2-link">

							<img src="
								<?php 
									if( has_post_thumbnail() ) {
										echo get_the_post_thumbnail_url(null,'thumbnail');
									}
									else {
										echo get_template_directory_uri().'/assets/images/img-default.png';
									} 
								?>" class="recent-post2-thumb" alt="post-thumb">


							<div class="recent-post2-info">
								<h4 class="recent-post2-title"><?php echo mb_strimwidth(get_the_title(), 0, 650, '...')?></h4>
								<div class="recent-post2-feedback">
									<div class="likes post-header-likes recent-post2-eyes">
										<svg width="19" height="15" class="icon likes-icon " fill="#BCBFC2">
											<use
												xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#eye">
											</use>
										</svg>
										<span class="likes-counter recent-post2-eyes-counter"><?php comments_number('0', '1', '%') ?> </span>
									</div>
									<div class="comments recent-post2-comments">
										<svg width="19" height="15" class="icon comments-icon" fill="#BCBFC2">
											<use
												xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#Comment">
											</use>
										</svg>
										<span class="comments-counter recent-post2-comments-counter"> <?php comments_number('0', '1', '%')  ?> </span>
									</div>
								</div>
							</div>
						</a>
					</div>
			
				<?php
				}
				wp_reset_postdata();
	
		}
		echo $args['after_widget']; 
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
        $count = @ $instance['count'] ?: '4';

		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество постов:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>"
					name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
			</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
        $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		return $instance;
	}

	// скрипт виджета
	function add_recent_posts_widget2_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_recent_posts_widget2_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
<style type="text/css">
.my_widget a {
    display: inline;
}
</style>
<?php
	}

} 
// конец класса Recent_Posts_Widget2

// регистрация Recent_Posts_Widget2 в WordPress
function register_recent_posts_widget2() {
	register_widget( 'Recent_Posts_Widget2' );
}
add_action( 'widgets_init', 'register_recent_posts_widget2' );












//подключаем стили и шрифты
function enqueue_universal_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'swiper-slider', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', 'style');
	wp_enqueue_style( 'universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style');
	wp_enqueue_style( 'Roboto-Slab', '//fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', '//code.jquery.com/jquery-3.5.1.min.js');
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', null, time(), true);
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', 'swiper', time(), true);
   
}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );

## Изменяем настройки облака тегов
add_filter( 'widget_tag_cloud_args', 'edit_widget_tag_cloud_args');
function edit_widget_tag_cloud_args($args) {
	$args['unit'] = 'px';
	$args['smallest'] = '14';
	$args['largest'] = '14';
	$args['number'] = '10';
	$args['orderby'] = 'count';
	return $args;
}

## отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}

## Удаление конструкции [...] на конце в отрывках
add_filter('excerpt_more', function($more) {
	return '...';
});

##Склоняем слова после числительных
function plural_form($number, $after) {
	$cases = array (2, 0, 1, 1, 1, 2);
	echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}



add_action( 'wp_enqueue_scripts', 'adminAjax_data', 99 );
function adminAjax_data(){

	wp_localize_script( 'jquery', 'adminAjax', 
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);  

}

add_action('wp_ajax_contacts_form', 'ajax_form');
add_action('wp_ajax_nopriv_contacts_form', 'ajax_form');
function ajax_form() {
	$contact_name = $_POST['contact_name'];
	$contact_email = $_POST['contact_email'];
	$contact_comment = $_POST['contact_comment'];
	$message = 'Пользователь оставил свои данные: ' . $contact_name;

	$headers = 'From: Алексей <2257855@gmail.com>' . "\r\n"; 
	$send_message = wp_mail('reffery1@rambler.ru', 'Новая заявка с сайта', $message, $headers);
	if ($send_message) {
		echo 'Все получилось';
	} else {
		echo 'Где то есть ошибка';
	}
	wp_die();
}


















// ##Убираем циклическую ссылку из логотипов на главной странице
// function nanima_logo() {
// 	$custom_logo_id = get_theme_mod( 'custom_logo' );
// 	if(is_home()){
// 	$html = wp_get_attachment_image( $custom_logo_id, 'full', false, array(
// 	'class' => 'custom-logo',
// 	'itemprop' => 'url image',
// 	'alt' => get_bloginfo('name')
// 	) );}
// 	else {
// 	$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" title="'. get_bloginfo('name') .'" itemprop="url">%2$s</a>',
// 	esc_url( home_url( '/' ) ),
// 	wp_get_attachment_image( $custom_logo_id, 'full', false, array(
// 	'class' => 'custom-logo',
// 	'itemprop' => 'url image',
// 	'alt' => get_bloginfo('name'))
// 	) );}
// 	return $html;
// 	}
// 	add_filter( 'get_custom_logo', 'nanima_logo' );