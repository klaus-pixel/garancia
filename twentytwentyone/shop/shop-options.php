<?php

	// Define path and URL to the ACF plugin.
	define( 'MY_ACF_PATH', get_stylesheet_directory() . '/inc/acf/' );
	define( 'MY_ACF_URL', get_stylesheet_directory_uri() . '/inc/acf/' );

	// Include the ACF plugin.
	include_once( MY_ACF_PATH . 'acf.php' );

	// Customize the url setting to fix incorrect asset URLs.
	add_filter('acf/settings/url', 'my_acf_settings_url');
	function my_acf_settings_url( $url ) {
		return MY_ACF_URL;
	}

	// (Optional) Hide the ACF admin menu item.
	// add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
	// function my_acf_settings_show_admin( $show_admin ) {
	// 	return false;
	// }

	function load_ajax(){
		wp_enqueue_script('ajax', get_stylesheet_directory_uri(). '/shop/js/ajax-fiter.js' , array('jquery'), NULL, true);

        wp_enqueue_script('validation', get_stylesheet_directory_uri(). '/shop/js/form-validation.js' , array('jquery'), NULL, true);

		wp_localize_script('ajax', 'wp_ajax', array('ajax_url' =>admin_url('admin-ajax.php' )));
	}

	add_action('wp_enqueue_scripts', 'load_ajax');


    function my_custom_styles() {

        wp_register_style( 'custom-styles', get_template_directory_uri().'/shop/css/shop-styles.css' );
    
        if ( is_page_template( 'shop/problem-page.php' ) ) {
    
        wp_enqueue_style( 'custom-styles' );
        }
     }
    
     add_action( 'wp_enqueue_scripts', 'my_custom_styles' );


class KontrolliRaportimeve 
{

    /**
     * Class instance.
     *
     * @see get_instance()
     * @type object
     */
    protected static $instance = NULL;
    
    // Access the working instance of the class
    public static function get_instance()
    {
        NULL === self::$instance and self::$instance = new self;
        return self::$instance;
    }

    //Create Raportimet Post Type
    public function raportimet_cpt(){

        $labels = array(
            'name' => 'Raportimet',
            'singular_name' => 'Raportimet',
        );

        $args = array(
            'labels' => $labels,
            'public' =>true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-testimonial',
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'supports' => array('title', 'editor')

        );
         register_post_type('raportimet' ,$args );
         
     }

     // Add metaboxes for Raportimet post type
     public function add_meta_boxes(){

        add_meta_box(

            'autori_raportimit',
            'Opsionet Raportimit',
            array( $this, 'render_features_box'),
            'raportimet', 
            'side',
            'default',
        );

     }

   public function render_features_box($post){

       
		wp_nonce_field( 'alecaddd_testimonial', 'alecaddd_testimonial_nonce' );

		$data = get_post_meta( $post->ID, '_alecaddd_testimonial_key', true );
		$name = isset($data['name']) ? $data['name'] : '';
		$email = isset($data['email']) ? $data['email'] : '';
		$approved = isset($data['approved']) ? $data['approved'] : false;
		$featured = isset($data['featured']) ? $data['featured'] : false;
		?>
		<p>
			<label class="meta-label" for="alecaddd_testimonial_author">Author Name</label>
			<input type="text" id="alecaddd_testimonial_author" name="alecaddd_testimonial_author" class="widefat" value="<?php echo esc_attr( $name ); ?>">
		</p>
		<p>
			<label class="meta-label" for="alecaddd_testimonial_email">Author Email</label>
			<input type="email" id="alecaddd_testimonial_email" name="alecaddd_testimonial_email" class="widefat" value="<?php echo esc_attr( $email ); ?>">
		</p>
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="alecaddd_testimonial_approved">Approved</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="alecaddd_testimonial_approved" name="alecaddd_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
					<label for="alecaddd_testimonial_approved"><div></div></label>
				</div>
			</div>
		</div>
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="alecaddd_testimonial_featured">Featured</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="alecaddd_testimonial_featured" name="alecaddd_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
					<label for="alecaddd_testimonial_featured"><div></div></label>
				</div>
			</div>
		</div>
		<?php
	}

	public function save_meta_box($post_id)
	{
		if (! isset($_POST['alecaddd_testimonial_nonce'])) {
			return $post_id;
		}

		$nonce = $_POST['alecaddd_testimonial_nonce'];
		if (! wp_verify_nonce( $nonce, 'alecaddd_testimonial' )) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if (! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$data = array(
			'name' => sanitize_text_field( $_POST['alecaddd_testimonial_author'] ),
			'email' => sanitize_text_field( $_POST['alecaddd_testimonial_email'] ),
			'approved' => isset($_POST['alecaddd_testimonial_approved']) ? 1 : 0,
			'featured' => isset($_POST['alecaddd_testimonial_featured']) ? 1 : 0,
		);
		update_post_meta( $post_id, '_alecaddd_testimonial_key', $data );
	}

    public function submit_produkt_form() {

        // sanitize the dala

        $name = sanitize_text_field($_POST['name'] );

        $email = sanitize_email_field($_POST['email'] );

        $subjekt = sanitize_text_field($_POST['subjekt'] );

        $produkt = sanitize_text_field($_POST['produktselect'] );

        $message = sanitize_textarea_field($_POST['message'] );

        //store the data into Produkt CPT

        $data = array(
            'emri' => $name,
            'email' => $email,
            'subjekt' => $subjekt,
            'produkt' => $produkt,
            'approved' => 0,
            'featured' => 0,
        );

        $args = array(
            'post_title' => 'Kerkese nga '.$name,
            'post_content' => $message,
            'post_author' => 1,
            'post_status' => 'publish',
            'post_type' => 'produkte',
            'meta_input' => array(

            )
        );

        //send response

        wp_die();
     }
}

add_filter(
    'init',
    [KontrolliRaportimeve::get_instance(), 'raportimet_cpt']
);  

add_filter(
    'add_meta_boxes',
    [KontrolliRaportimeve::get_instance(), 'add_meta_boxes']
);  

add_filter(
    'save_post',
    [KontrolliRaportimeve::get_instance(), 'save_meta_box']
);  