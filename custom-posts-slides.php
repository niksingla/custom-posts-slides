<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://linkedin.com/in/programmernik/
 * @since             1.0.0
 * @package           Custom_Posts_Slides
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Posts Slider
 * Plugin URI:        https://linkedin.com/in/programmernik/
 * Description:       This is a custom post slider plugin.
 * Version:           1.0.0
 * Author:            Nikhil
 * Author URI:        https://linkedin.com/in/programmernik//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom-posts-slides
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CUSTOM_POSTS_SLIDES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custom-posts-slides-activator.php
 */
function activate_custom_posts_slides() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-posts-slides-activator.php';
	Custom_Posts_Slides_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custom-posts-slides-deactivator.php
 */
function deactivate_custom_posts_slides() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-posts-slides-deactivator.php';
	Custom_Posts_Slides_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_custom_posts_slides' );
register_deactivation_hook( __FILE__, 'deactivate_custom_posts_slides' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-custom-posts-slides.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_custom_posts_slides() {

	$plugin = new Custom_Posts_Slides();
	$plugin->run();

}
run_custom_posts_slides();


/**Custom Code */

function enqueue_slick_carousel() {
    // wp_enqueue_style('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css');
    // wp_enqueue_script('slick-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), '1.8.1', true);
	wp_enqueue_style('flickity', 'https://unpkg.com/flickity@2/dist/flickity.min.css');
    wp_enqueue_script('flickity', 'https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js', array('jquery'), '2.0.0', true);
}

add_action('wp_enqueue_scripts', 'enqueue_slick_carousel');

function custom_post_shortcode($atts) {
    
    $atts = shortcode_atts(array(
        'post_type' => 'post', 
        'order' => 'date', 
        'posts' => 5, 
		'category' => 'blog',
    ), $atts);

    
    $args = array(
        'post_type' => $atts['post_type'],
        'posts_per_page' => $atts['posts'],
        'order' => $atts['order'],
		'category_name' => $atts['category'],
    );

    
    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
		?>		
		<div class="slick-carousel flickity-carousel" >
			<?php
			while ($query->have_posts()) {
				$query->the_post();
				?>
					<div class="custom-post carousel-item carousel-cell">
						<div class="post-container" data-id="<?= $query->post->ID?>">
							<div class="col details-wrapper">
								<div class="details-inner">
									<h2><?= get_the_title();?></h2>
									<p><?= the_excerpt() ?></p>
									<div class="inner-links">
										<a href="<?= get_the_permalink();?>">Discover More</a>
										<a href="#">Explore the solutions</a>
									</div>										
								</div>
								<div class="bottom-carousel">
									<div class="small-ft-image"><?php echo the_post_thumbnail(); ?></div>
									<div class="small-title"><?= get_the_title();?></div>
									<div class="inner-carousel-btns">
										<button class="custom-nav prev"><</button>
										<button class="custom-nav next">></button>	
									</div>	
								</div>
							</div>
							<div class="col">
								<div class="ft-image"><?php echo the_post_thumbnail(); ?></div>
							</div>
						</div>
						
						
					</div>
				<?php
				
			}
			?>
		</div>
		<?php
    } else {
        echo 'No posts found.';
    }

    wp_reset_postdata();

    $output = ob_get_clean();

    return $output;
}

add_shortcode('custom-posts-widget', 'custom_post_shortcode');

// Add doc menu to the admin dashboard
function custregis_plugin_doc_menu() {
    add_menu_page('Custom Posts Slider', 'Custom Posts Slider', 'manage_options', 'posts-slider-doc', 'custpost_plugin_doc_page');
}
add_action('admin_menu', 'custregis_plugin_doc_menu');
// Callback function to display the settings page
function custpost_plugin_doc_page() {
    ?>
    
    <h2>Using Shortcodes:</h2>
    <ol>
        <p>Use the following shortcodes to display the post slider on pages or posts:</p>
        <li><code>[custom-posts-widget]</code> - Display the posts.</li>
		<li><code>[custom-posts-widget post_type="post" order="ASC" posts="10" category="blog"]</code> - Example code.</li>
		<li>You can add your own styles according to your theme</li>
    </ol>

	<?php
}