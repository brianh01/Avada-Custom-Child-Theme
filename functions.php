<?php

add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_style' );
function enqueue_child_theme_style() {

    // DASHICONS in front end
	wp_enqueue_style( 'dashicons' );

    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'starling-font', 'https://use.typekit.net/eum8goh.css' );

    // include the styles compiled from SCSS
    wp_enqueue_style( 'slick-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css');
    wp_enqueue_style( 'slick-theme-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css');
    wp_enqueue_style( 'datepicker-style', get_stylesheet_directory_uri() .'/css/jquery-ui.css');
    wp_enqueue_style( 'timepicker-style', get_stylesheet_directory_uri() .'/css/timepicker.min.css');
    wp_enqueue_style( 'scss-style', get_stylesheet_directory_uri() .'/css/styles.css');

    //custom JS
    wp_enqueue_script( 'slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js');
    wp_enqueue_script( 'datepicker-js', get_stylesheet_directory_uri() .'/js/jquery-ui.js');
    wp_enqueue_script( 'timepicker-js', get_stylesheet_directory_uri() .'/js/timepicker.min.js');
    wp_enqueue_script( 'resizesensor-js', get_stylesheet_directory_uri() .'/js/ResizeSensor.js');
    wp_enqueue_script( 'stickysidebar-js', get_stylesheet_directory_uri() .'/js/sticky-sidebar.js');
    wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() .'/js/custom.js');

    /*if (is_page('book-now')) {
        wp_enqueue_script( 'vue', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js', null, null, true);
        wp_enqueue_script('vuejs-datepicker', 'https://unpkg.com/vuejs-datepicker', ['vue'], null, true);
        wp_enqueue_script( 'book-now-js', get_stylesheet_directory_uri() .'/js/book-now.js', ['vue', 'vuejs-datepicker'], null, true);

        $fields = [
            'treatments' => get_field('type_of_treatment', 'option'),
            'bodyArea' => get_field('body_area', 'option'),
            'skinTone' => get_field('skin_tone', 'option'),
            'hairColour' => get_field('hair_colour', 'option'),
            'skinReaction' => get_field('skin_reaction', 'option'),
            'heritage' => get_field('heritage', 'option')
        ];

        wp_localize_script('book-now-js', 'vueVariables', $fields);
        wp_localize_script('book-now-js', 'ajax', [ 'url' => admin_url( 'admin-ajax.php' ) ]);
    }*/

}

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page();

}

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

add_shortcode('skin_treatment', 'get_skintreatments');
function get_skintreatments() {
  ob_start();
  $page_id = get_the_ID();
  $args = array(
    'post_type' =>  'page',
    'post_parent' =>  $page_id,
    'order' => 'ASC'
  );
  $posts = get_posts( $args );
 ?>
 <div class="st-list">
   <?php foreach( $posts as $post ): ?>
     <div class="treatment-item">
       <div class="thumbnail-container">
         <img src="<?= get_the_post_thumbnail_url($post->ID); ?>" alt="laser treatment">
       </div>
       <div class="item-title">
         <h4><?= get_the_title( $post->ID ); ?></h4>
       </div>
       <div class="item-desc">
         <?= get_field('sub_content', $post->ID); ?>
       </div>
       <div class="item-button">
         <a class="fusion-button default-btn w-arrow" href="https://www.fresha.com/providers/id7x9ky5?pId=452325">
             <span class="fusion-button-text">
                 Book Now
             </span>
         </a>
       </div>
     </div>
   <?php endforeach; ?>
 </div>
 <?php
 return ob_get_clean();
}

/**
 * Skin Concerns Items (Grid/Columns) Custom shortcode - used in Skin Concerns page
 * ---------------------------------------------------------------------------------
 **/
 function custom_shortcode_skin_concerns_subpages( $atts ) {
	ob_start();

	$cur_id = get_queried_object_id();

	$args = array(
		'post_type'			=>	'page',
		'post_status'		=>	'publish',
		'post_parent'		=>	$cur_id,
		'posts_per_page'	=>	-1,
		'order_by'			=>	'menu_order',
		'order'				=>	'ASC',
	);

	$loop = new WP_Query( $args ); if ( $loop->have_posts() ) :  ?>

		<div class="skin-concerns-row">

			<?php while ( $loop->have_posts() ) : $loop->the_post(); $id = get_the_ID(); ?>

				<div class="sc-item-col">

					<h3 class="sc-title fs-24"><?php the_title() ?></h3>

					<?php $desc = get_field( 'sub_content', $id); if ( $desc ) : ?>
						<div class="sc-desc"><?php echo $desc ?></div>
					<?php endif ?>

				<div class="btn-wrap">
				    <a href="https://www.fresha.com/providers/id7x9ky5?pId=452325" class="default-btn">Book Now <span></span></a>
				</div>
				</div>

			<?php endwhile; ?>

		</div>

	<?php endif; wp_reset_query();

	return ob_get_clean();
}

add_shortcode( 'skin-concerns-subpages', 'custom_shortcode_skin_concerns_subpages' );


function ajax_submit_booking_form () {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $to = 'info@skinclique.com.au';
    $subject = '[Skin Clique] New booking received';

    ob_start();
    require __DIR__ . '/emails/new-booking.php';
    $body = ob_get_clean();

    $headers = [
        'Content-Type: text/html; charset=UTF-8'
    ];

    wp_mail( $to, $subject, $body, $headers );

    wp_send_json(['success' => true], 418);
    exit;
}

add_action( 'wp_ajax_submit_booking_form', 'ajax_submit_booking_form' );
add_action( 'wp_ajax_nopriv_submit_booking_form', 'ajax_submit_booking_form' );


