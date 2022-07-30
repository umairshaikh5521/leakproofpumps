<?php

/**
 * Include Theme Customizer.
 *
 * @since v1.0
 */
$theme_customizer = get_template_directory() . '/inc/customizer.php';
if ( is_readable( $theme_customizer ) ) {
	require_once $theme_customizer;
}


/**
 * Include Support for wordpress.com-specific functions.
 * 
 * @since v1.0
 */
$theme_wordpresscom = get_template_directory() . '/inc/wordpresscom.php';
if ( is_readable( $theme_wordpresscom ) ) {
	require_once $theme_wordpresscom;
}


/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since v1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 800;
}


/**
 * General Theme Settings.
 *
 * @since v1.0
 */
if ( ! function_exists( 'loco_setup_theme' ) ) :
	function loco_setup_theme() {
		// Make theme available for translation: Translations can be filed in the /languages/ directory.
		load_theme_textdomain( 'loco', get_template_directory() . '/languages' );

		// Theme Support.
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
				'navigation-widgets',
			)
		);

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );
		// Add support for full and wide alignment.
		add_theme_support( 'align-wide' );
		// Add support for editor styles.
		add_theme_support( 'editor-styles' );
		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Default Attachment Display Settings.
		update_option( 'image_default_align', 'none' );
		update_option( 'image_default_link_type', 'none' );
		update_option( 'image_default_size', 'large' );

		// Custom CSS-Styles of Wordpress Gallery.
		add_filter( 'use_default_gallery_style', '__return_false' );
	}
	add_action( 'after_setup_theme', 'loco_setup_theme' );

	// Disable Block Directory: https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/filters/editor-filters.md#block-directory
	remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
	remove_action( 'enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory' );
endif;


/**
 * Fire the wp_body_open action.
 *
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
 *
 * @since v2.2
 */
if ( ! function_exists( 'wp_body_open' ) ) :
	function wp_body_open() {
		/**
		 * Triggered after the opening <body> tag.
		 *
		 * @since v2.2
		 */
		do_action( 'wp_body_open' );
	}
endif;


/**
 * Add new User fields to Userprofile.
 *
 * @since v1.0
 */
if ( ! function_exists( 'loco_add_user_fields' ) ) :
	function loco_add_user_fields( $fields ) {
		// Add new fields.
		$fields['facebook_profile'] = 'Facebook URL';
		$fields['twitter_profile']  = 'Twitter URL';
		$fields['linkedin_profile'] = 'LinkedIn URL';
		$fields['xing_profile']     = 'Xing URL';
		$fields['github_profile']   = 'GitHub URL';

		return $fields;
	}
	add_filter( 'user_contactmethods', 'loco_add_user_fields' ); // get_user_meta( $user->ID, 'facebook_profile', true );
endif;


/**
 * Test if a page is a blog page.
 * if ( is_blog() ) { ... }
 *
 * @since v1.0
 */
function is_blog() {
	global $post;
	$posttype = get_post_type( $post );

	return ( ( is_archive() || is_author() || is_category() || is_home() || is_single() || ( is_tag() && ( 'post' === $posttype ) ) ) ? true : false );
}


/**
 * Disable comments for Media (Image-Post, Jetpack-Carousel, etc.)
 *
 * @since v1.0
 */
function loco_filter_media_comment_status( $open, $post_id = null ) {
	$media_post = get_post( $post_id );
	if ( 'attachment' === $media_post->post_type ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'loco_filter_media_comment_status', 10, 2 );


/**
 * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
 *
 * @since v1.0
 */
function loco_custom_edit_post_link( $output ) {
	return str_replace( 'class="post-edit-link"', 'class="post-edit-link badge badge-secondary"', $output );
}
add_filter( 'edit_post_link', 'loco_custom_edit_post_link' );

function loco_custom_edit_comment_link( $output ) {
	return str_replace( 'class="comment-edit-link"', 'class="comment-edit-link badge badge-secondary"', $output );
}
add_filter( 'edit_comment_link', 'loco_custom_edit_comment_link' );


/**
 * Responsive oEmbed filter: https://getbootstrap.com/docs/5.0/helpers/ratio
 *
 * @since v1.0
 */
function loco_oembed_filter( $html ) {
	return '<div class="ratio ratio-16x9">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'loco_oembed_filter', 10, 4 );


if ( ! function_exists( 'loco_content_nav' ) ) :
	/**
	 * Display a navigation to next/previous pages when applicable.
	 *
	 * @since v1.0
	 */
	function loco_content_nav( $nav_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) :
	?>
			<div id="<?php echo esc_attr( $nav_id ); ?>" class="d-flex mb-4 justify-content-between">
				<div><?php next_posts_link( '<span aria-hidden="true">&larr;</span> ' . esc_html__( 'Older posts', 'loco' ) ); ?></div>
				<div><?php previous_posts_link( esc_html__( 'Newer posts', 'loco' ) . ' <span aria-hidden="true">&rarr;</span>' ); ?></div>
			</div><!-- /.d-flex -->
	<?php
		else :
			echo '<div class="clearfix"></div>';
		endif;
	}

	// Add Class.
	function posts_link_attributes() {
		return 'class="btn btn-secondary btn-lg"';
	}
	add_filter( 'next_posts_link_attributes', 'posts_link_attributes' );
	add_filter( 'previous_posts_link_attributes', 'posts_link_attributes' );
endif;


/**
 * Init Widget areas in Sidebar.
 *
 * @since v1.0
 */
function loco_widgets_init() {
	// Area 1.
	register_sidebar(
		array(
			'name'          => 'Primary Widget Area (Sidebar)',
			'id'            => 'primary_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Area 2.
	register_sidebar(
		array(
			'name'          => 'Secondary Widget Area (Header Navigation)',
			'id'            => 'secondary_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	// Area 3.
	register_sidebar(
		array(
			'name'          => 'Third Widget Area (Footer)',
			'id'            => 'third_widget_area',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'loco_widgets_init' );


if ( ! function_exists( 'loco_article_posted_on' ) ) :
	/**
	 * "Theme posted on" pattern.
	 *
	 * @since v1.0
	 */
	function loco_article_posted_on() {
		printf(
			wp_kses_post( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author-meta vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'loco' ) ),
			esc_url( get_the_permalink() ),
			esc_attr( get_the_date() . ' - ' . get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() . ' - ' . get_the_time() ),
			esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'loco' ), get_the_author() ),
			get_the_author()
		);
	}
endif;


/**
 * Template for Password protected post form.
 *
 * @since v1.0
 */
function loco_password_form() {
	global $post;
	$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );

	$output = '<div class="row">';
		$output .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
		$output .= '<h4 class="col-md-12 alert alert-warning">' . esc_html__( 'This content is password protected. To view it please enter your password below.', 'loco' ) . '</h4>';
			$output .= '<div class="col-md-6">';
				$output .= '<div class="input-group">';
					$output .= '<input type="password" name="post_password" id="' . esc_attr( $label ) . '" placeholder="' . esc_attr__( 'Password', 'loco' ) . '" class="form-control" />';
					$output .= '<div class="input-group-append"><input type="submit" name="submit" class="btn btn-primary" value="' . esc_attr__( 'Submit', 'loco' ) . '" /></div>';
				$output .= '</div><!-- /.input-group -->';
			$output .= '</div><!-- /.col -->';
		$output .= '</form>';
	$output .= '</div><!-- /.row -->';
	return $output;
}
add_filter( 'the_password_form', 'loco_password_form' );


if ( ! function_exists( 'loco_comment' ) ) :
	/**
	 * Style Reply link.
	 *
	 * @since v1.0
	 */
	function loco_replace_reply_link_class( $class ) {
		return str_replace( "class='comment-reply-link", "class='comment-reply-link btn btn-outline-secondary", $class );
	}
	add_filter( 'comment_reply_link', 'loco_replace_reply_link_class' );

	/**
	 * Template for comments and pingbacks:
	 * add function to comments.php ... wp_list_comments( array( 'callback' => 'loco_comment' ) );
	 *
	 * @since v1.0
	 */
	function loco_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
	?>
		<li class="post pingback">
			<p><?php esc_html_e( 'Pingback:', 'loco' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'loco' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
				break;
			default:
	?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<footer class="comment-meta">
					<div class="comment-author vcard">
						<?php
							$avatar_size = ( '0' !== $comment->comment_parent ? 68 : 136 );
							echo get_avatar( $comment, $avatar_size );

							/* translators: 1: comment author, 2: date and time */
							printf(
								wp_kses_post( __( '%1$s, %2$s', 'loco' ) ),
								sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
								sprintf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
									esc_url( get_comment_link( $comment->comment_ID ) ),
									get_comment_time( 'c' ),
									/* translators: 1: date, 2: time */
									sprintf( esc_html__( '%1$s ago', 'loco' ), human_time_diff( (int) get_comment_time( 'U' ), current_time( 'timestamp' ) ) )
								)
							);

							edit_comment_link( esc_html__( 'Edit', 'loco' ), '<span class="edit-link">', '</span>' );
						?>
					</div><!-- .comment-author .vcard -->

					<?php if ( '0' === $comment->comment_approved ) : ?>
						<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'loco' ); ?></em>
						<br />
					<?php endif; ?>
				</footer>

				<div class="comment-content"><?php comment_text(); ?></div>

				<div class="reply">
					<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'reply_text' => esc_html__( 'Reply', 'loco' ) . ' <span>&darr;</span>',
									'depth'      => $depth,
									'max_depth'  => $args['max_depth'],
								)
							)
						);
					?>
				</div><!-- /.reply -->
			</article><!-- /#comment-## -->
		<?php
				break;
		endswitch;
	}

	/**
	 * Custom Comment form.
	 *
	 * @since v1.0
	 * @since v1.1: Added 'submit_button' and 'submit_field'
	 * @since v2.0.2: Added '$consent' and 'cookies'
	 */
	function loco_custom_commentform( $args = array(), $post_id = null ) {
		if ( null === $post_id ) {
			$post_id = get_the_ID();
		}

		$commenter     = wp_get_current_commenter();
		$user          = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		$args = wp_parse_args( $args );

		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true' required" : '' );
		$consent  = ( empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"' );
		$fields   = array(
			'author'  => '<div class="form-floating mb-3">
							<input type="text" id="author" name="author" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_html__( 'Name', 'loco' ) . ( $req ? '*' : '' ) . '"' . $aria_req . ' />
							<label for="author">' . esc_html__( 'Name', 'loco' ) . ( $req ? '*' : '' ) . '</label>
						</div>',
			'email'   => '<div class="form-floating mb-3">
							<input type="email" id="email" name="email" class="form-control" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . esc_html__( 'Email', 'loco' ) . ( $req ? '*' : '' ) . '"' . $aria_req . ' />
							<label for="email">' . esc_html__( 'Email', 'loco' ) . ( $req ? '*' : '' ) . '</label>
						</div>',
			'url'     => '',
			'cookies' => '<p class="form-check mb-3 comment-form-cookies-consent">
							<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="form-check-input" type="checkbox" value="yes"' . $consent . ' />
							<label class="form-check-label" for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'loco' ) . '</label>
						</p>',
		);

		$defaults = array(
			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_field'        => '<div class="form-floating mb-3">
											<textarea id="comment" name="comment" class="form-control" aria-required="true" required placeholder="' . esc_attr__( 'Comment', 'loco' ) . ( $req ? '*' : '' ) . '"></textarea>
											<label for="comment">' . esc_html__( 'Comment', 'loco' ) . '</label>
										</div>',
			/** This filter is documented in wp-includes/link-template.php */
			'must_log_in'          => '<p class="must-log-in">' . sprintf( wp_kses_post( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'loco' ) ), wp_login_url( apply_filters( 'the_permalink', get_the_permalink( get_the_ID() ) ) ) ) . '</p>',
			/** This filter is documented in wp-includes/link-template.php */
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( wp_kses_post( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'loco' ) ), get_edit_user_link(), $user->display_name, wp_logout_url( apply_filters( 'the_permalink', get_the_permalink( get_the_ID() ) ) ) ) . '</p>',
			'comment_notes_before' => '<p class="small comment-notes">' . esc_html__( 'Your Email address will not be published.', 'loco' ) . '</p>',
			'comment_notes_after'  => '',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'class_submit'         => 'btn btn-primary',
			'name_submit'          => 'submit',
			'title_reply'          => '',
			'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'loco' ),
			'cancel_reply_link'    => esc_html__( 'Cancel reply', 'loco' ),
			'label_submit'         => esc_html__( 'Post Comment', 'loco' ),
			'submit_button'        => '<input type="submit" id="%2$s" name="%1$s" class="%3$s" value="%4$s" />',
			'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
			'format'               => 'html5',
		);

		return $defaults;
	}
	add_filter( 'comment_form_defaults', 'loco_custom_commentform' );

endif;


/**
 * Nav menus.
 *
 * @since v1.0
 */
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
			'main-menu'   => 'Main Navigation Menu',
			'footer-menu' => 'Footer Menu',
		)
	);
}

// Custom Nav Walker: wp_bootstrap_navwalker().
$custom_walker = get_template_directory() . '/inc/wp_bootstrap_navwalker.php';
if ( is_readable( $custom_walker ) ) {
	require_once $custom_walker;
}

$custom_walker_footer = get_template_directory() . '/inc/wp_bootstrap_navwalker_footer.php';
if ( is_readable( $custom_walker_footer ) ) {
	require_once $custom_walker_footer;
}


/**
 * Loading All CSS Stylesheets and Javascript Files.
 *
 * @since v1.0
 */
function loco_scripts_loader() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// 1. Styles.
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', array(), $theme_version, 'all' );
	wp_enqueue_style( 'locomotive', 'https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.3/dist/locomotive-scroll.min.css', array(), $theme_version, 'all' );
	wp_enqueue_style( 'fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css', array(), $theme_version, 'all' );
	wp_enqueue_style( 'magnific', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css', array(), $theme_version, 'all' );
		wp_enqueue_style( 'aos', 'https://unpkg.com/aos@2.3.1/dist/aos.css', array(), $theme_version, 'all' );
	wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/css/main.css', array(), date("h:i:s"), 'all' ); // main.scss: Compiled Framework source + custom styles.

	if ( is_rtl() ) {
		wp_enqueue_style( 'rtl', get_template_directory_uri() . '/assets/css/rtl.css', array(), $theme_version, 'all' );
	}

	// 2. Scripts.
	wp_enqueue_script( 'jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), $theme_version, true );
	// wp_enqueue_script( '', 'https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.7/countUp.js', array(), $theme_version, true );
	wp_enqueue_script( 'mainjs', get_template_directory_uri() . '/assets/js/main.bundle.js', array(), $theme_version, true );
	wp_enqueue_script( 'locomotive-scroll', 'https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.3/dist/locomotive-scroll.min.js', array(), $theme_version, true );
	wp_enqueue_script( 'fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js', array(), $theme_version, true );
	wp_enqueue_script( 'cloudimage360', get_template_directory_uri() . '/assets/js/js-cloudimage-360-view.min.js', array(), $theme_version, true );
	wp_enqueue_script( 'magnific-popup',get_template_directory_uri() . '/assets/js/magnific-popup.min.js', array(), $theme_version, true );
	wp_enqueue_script(  'aosjs', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array(), $theme_version, true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'loco_scripts_loader' );

function load_jsx_scripts() {

	wp_enqueue_script( 'customjs', get_template_directory_uri() . '/assets/custom.js', array(), date("h:i:s"), true );
	
	wp_localize_script('ajax' , 'wpAjax', 
		['ajaxUrl' => admin_url('admin-ajax.php')]
	);

}

add_action( 'wp_enqueue_scripts', 'load_jsx_scripts' );



// Custom filter

// add_action('wp_ajax_myfilter', 'misha_filter_function'); // wp_ajax_{ACTION HERE} 
// add_action('wp_ajax_nopriv_myfilter', 'misha_filter_function');

// function misha_filter_function(){
// 	$args = array(
// 		// 'post_type' => 'products',
// 		'orderby' => 'date', // we will sort posts by date
// 		// 'order'	=> $_POST['date'] // ASC or DESC
// 	);
 
// 	// for taxonomies / categories
// 	if( isset( $_POST['categoryfilter'] ) )
// 		$args['tax_query'] = array(
// 			array(
// 				'taxonomy' => 'category',
// 				'field' => 'id',
// 				'terms' => $_POST['categoryfilter']
// 			)
// 		);
 
// 	// create $args['meta_query'] array if one of the following fields is filled
// 	if( isset( $_POST['price_min'] ) && $_POST['price_min'] || isset( $_POST['price_max'] ) && $_POST['price_max'] || isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
// 		$args['meta_query'] = array( 'relation'=>'AND' ); // AND means that all conditions of meta_query should be true

// 	if( isset( $_POST['min_capacity'] ) && $_POST['min_capacity'] ) {
// 		$args['meta_query'][] = array(

// 			// 'key' => '_price',
// 			// 'value' => array( $_POST['price_min'], $_POST['price_max'] ),
// 			// 'type' => 'numeric',
// 			// 'compare' => '>'
// 			'relation' => 'AND',
// 			array(
// 				'key' => 'min_head_capacity',
// 				'value' => $_POST['min_capacity'], 
// 				'compare' => '>=',
// 				'type' => 'numeric'
// 			),
// 			array(
// 				'key' => 'head',
// 				'value' => $_POST['min_capacity'], 
// 				'compare' => '<=',
// 				'type' => 'numeric'
// 			),
// 		);
// 	}
 
// 	// if both minimum price and maximum price are specified we will use BETWEEN comparison
// 	// if( isset( $_POST['price_min'] ) && $_POST['price_min'] && isset( $_POST['price_max'] ) && $_POST['price_max'] ) {
// 	// 	$args['meta_query'][] = array(
// 	// 		'key' => '_price',
// 	// 		'value' => array( $_POST['price_min'], $_POST['price_max'] ),
// 	// 		'type' => 'numeric',
// 	// 		'compare' => 'between'
// 	// 	);
// 	// } else {
// 	// 	// if only min price is set
// 	// 	if( isset( $_POST['price_min'] ) && $_POST['price_min'] )
// 	// 		$args['meta_query'][] = array(
// 	// 			'key' => '_price',
// 	// 			'value' => $_POST['price_min'],
// 	// 			'type' => 'numeric',
// 	// 			'compare' => '>'
// 	// 		);
 
// 	// 	// if only max price is set
// 	// 	if( isset( $_POST['price_max'] ) && $_POST['price_max'] )
// 	// 		$args['meta_query'][] = array(
// 	// 			'key' => '_price',
// 	// 			'value' => $_POST['price_max'],
// 	// 			'type' => 'numeric',
// 	// 			'compare' => '<'
// 	// 		);
// 	// }

 
// 	// if post thumbnail is set
// 	if( isset( $_POST['featured_image'] ) && $_POST['featured_image'] == 'on' )
// 		$args['meta_query'][] = array(
// 			'key' => '_thumbnail_id',
// 			'compare' => 'EXISTS'
// 		);
// 	// if you want to use multiple checkboxed, just duplicate the above 5 lines for each checkbox
 
// 	$query = new WP_Query( $args );
	
// 	if( $query->have_posts() ) :
// 		while( $query->have_posts() ): $query->the_post();
// 			echo '<h2>' . $query->post->post_title . '</h2>';
// 		endwhile;
// 		wp_reset_postdata();
// 	else :
// 		echo 'No posts found';
// 	endif;
	
// 	die();
// }



add_action( 'wp_ajax_nopriv_filter', 'filter_ajax' );
add_action( 'wp_ajax_filter', 'filter_ajax' );
function filter_ajax() {

	
	$head = $_POST['head'];
	$capacity = $_POST['capacity'];
	$pump_type = $_POST['pump_type'];
	$thumb = get_the_post_thumbnail_url();
	
	// echo $deal_year;
	// print_r($deal_product);


	$args = array(
		'post_type' => 'products',
		'posts_per_page' => -1,
		'order' => 'ASC',
		'paged' => $currentPage,
		'post_status' => 'publish',
	);
	$args['meta_query'][] = array();
	
	if(!empty($head)){
		// $args['s'] = $deal_year;
		array_push($args['meta_query'] , array(
				'key' => 'head',
				'value' => $_POST['head'], 
				'compare' => '<=',
				'type' => 'numeric'
			),
		);
	}

	if(!empty($capacity)){
		array_push($args['meta_query'] , array(
				'key' => 'capacity',
				'value' => $_POST['capacity'], 
				'compare' => '<=',
				'type' => 'numeric'
		));
	}

	if(!empty($pump_type)){
		array_push($args['meta_query'] , array(
				'key' => 'pump_type',
				'value' => $_POST['pump_type'], 
				'compare' => '='
				// 'type' => 'numeric'
		));
	}

	

	$query = new WP_Query($args);

	if($query->have_posts()) { 
		
		$counter = 0;
		
		while($query->have_posts()) : $counter++; $query->the_post();
		$title = get_the_title();

?>
<div class="col-lg-4 blog-single-card"  data-aos="fade-up">
	<div class="p-card">
		<div>
			
			<div class="img-wrapper" >
				<?php
					$product_image = get_field( "product_image_1", $post->ID  );
					if ( $product_image ): 
				?>
					<img class="w100p" src="<?php echo $product_image;?>">
				<?php endif; ?>

			</div>
			<div class="details mt-3">
					<?php
						if(get_the_title()){
							?>
							<div class="f24 fw600"><?php the_title(); ?></div>
							<?php
						}

						// $pumpType = get_field( "subtitle" );

						// if( $pumpType ) {
						// 	echo '<div class="f16 fw600 mt-2 subtitle red" data-aos="fade-up">'.$pumpType.'</div>';
						// }
					?>
			</div>
				<?php
					$terms = get_the_terms( $post->ID, 'applications' );
					if ( !empty( $terms ) ){
						echo '<p class="f12 fw500 mt-2 blue">RECOMMENDED Applications:</p>';
						echo "<div class='apps-wrapper'>";
						foreach ($terms as $term) {
							// echo "$term->name <br>";
							$image = get_field('application_icon', 'category_'. $term->term_id);
							echo '<img src="'.$image.'" />';
						}
						echo '</div>';
					}
				?>
		</div>
		<div class="hover">
			<?php
				if(get_the_excerpt()){
					?>
					<div class="fr-imp fw500 mt-2 excerpt" data-aos="fade-up"><?php the_excerpt(); ?></div>
					<?php
				}
			?>

			<a href="<?php the_permalink(); ?>" class="btn btn-primary btn-grey">View Details</a>
		</div>
	</div>
</div>
<?php
endwhile;
}else{
	echo "<div class='f36 fw700 blue text-center'>No Products Found</div>";
}
wp_reset_postdata();

die();
} 