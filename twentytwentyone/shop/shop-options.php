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

       
		wp_nonce_field( 'alecaddd_raportimet', 'alecaddd_raportimet_nonce' );

		$data = get_post_meta( $post->ID, '_alecaddd_raportimet_key', true );
		$name = isset($data['name']) ? $data['name'] : '';
		$email = isset($data['email']) ? $data['email'] : '';
		$approved = isset($data['approved']) ? $data['approved'] : false;
		$featured = isset($data['featured']) ? $data['featured'] : false;
		?>
		<p>
			<label class="meta-label" for="alecaddd_raportimet_author">Author Name</label>
			<input type="text" id="alecaddd_raportimet_author" name="alecaddd_raportimet_author" class="widefat" value="<?php echo esc_attr( $name ); ?>">
		</p>
		<p>
			<label class="meta-label" for="alecaddd_raportimet_email">Author Email</label>
			<input type="email" id="alecaddd_raportimet_email" name="alecaddd_raportimet_email" class="widefat" value="<?php echo esc_attr( $email ); ?>">
		</p>
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="alecaddd_raportimetl_approved">Approved</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="alecaddd_raportimet_approved" name="alecaddd_raportimet_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
					<label for="alecaddd_raportimet_approved"><div></div></label>
				</div>
			</div>
		</div>
		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="alecaddd_raportimet_featured">Featured</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="alecaddd_raportimet_featured" name="alecaddd_raportimet_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
					<label for="alecaddd_raportimet_featured"><div></div></label>
				</div>
			</div>
		</div>
		<?php
	}

	public function save_meta_box($post_id)
	{
		if (! isset($_POST['alecaddd_raportimet_nonce'])) {
			return $post_id;
		}

		$nonce = $_POST['alecaddd_raportimet_nonce'];
		if (! wp_verify_nonce( $nonce, 'alecaddd_raportimet' )) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if (! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$data = array(
			'name' => sanitize_text_field( $_POST['alecaddd_raportimet_author'] ),
			'email' => sanitize_text_field( $_POST['alecaddd_raportimet_email'] ),
			'approved' => isset($_POST['alecaddd_raportimet_approved']) ? 1 : 0,
			'featured' => isset($_POST['alecaddd_raportimet_featured']) ? 1 : 0,
		);
		update_post_meta( $post_id, '_alecaddd_raportimet_key', $data );
	}

    // colonat e raportimeve post type
    public function save_custom_columns($columns){

        $title = $columns['title'];
        $date = $columns['date'];

        unset($columns['title'], $columns['date']);

        $columns['name'] = 'Autori';
        $columns['title'] = $title;
        $columns['approved'] = 'Approved';
        $columns['featured'] = 'Featured';
        $date['date'] = $data;

        return $columns;
    }

    //set custom columns
    public function set_custom_columns_data( $column, $post_id) {

		$data = get_post_meta( $post_id, '_alecaddd_raportimet_key', true );
		$name = isset($data['name']) ? $data['name'] : '';
		$email = isset($data['email']) ? $data['email'] : '';
		$approved = isset($data['approved']) && $data['approved'] == 1 ? '<strong>YES</strong>' : 'NO';
		$featured = isset($data['featured']) && $data['featured'] ==1  ? '<strong>YES</strong>' : 'NO';

        switch ($column) {
            case 'name':
                echo '<strong>'. $name . '</strong><br/><a href="malitio:' . $email . '">'. $email .'</a>';
                break;

            case 'approved':
                echo $approved;
                break;

            case 'featured':
                echo $featured;
                break;
        }

    }
    //sort custom columns
    public function sort_columns($columns){

        $columns['name'] = 'name';
        $columns['approved'] = 'approved';
        $columns['featured'] = 'featured';

        return $columns;
    }


    public function submit_produkt_form() {

        // sanitize the dala

        $name = sanitize_text_field($_POST['name']);
		$email = sanitize_email($_POST['email']);
		$message = sanitize_textarea_field($_POST['message']);

		$data = array(
			'name' => $name,
			'email' => $email,
			'approved' => 0,
			'featured' => 0,
		);

		$args = array(
			'post_title' => 'Raportim nga ' . $name,
			'post_content' => $message,
			'post_author' => 1,
			'post_status' => 'publish',
			'post_type' => 'raportimet',
			'meta_input' => array(
				'_alecaddd_raportimet_key' => $data
			)
		);

		$postID = wp_insert_post($args);

		if ($postID) {
			return $this->return_json('success');
		}

		return $this->return_json('error');
	}

    public function return_json($status)
    {
         $return = array(
             'status' => $status
         );
         wp_send_json($return);
 
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

add_filter(
    'manage_raportimet_posts_columns',
    [KontrolliRaportimeve::get_instance(), 'save_custom_columns']
);  

add_filter(
    'manage_raportimet_posts_custom_column',
    [KontrolliRaportimeve::get_instance(), 'set_custom_columns_data'], 10, 2
);  

add_filter(
    'manage_edit-raportimet_sortable_columns',
    [KontrolliRaportimeve::get_instance(), 'sort_columns']
);  

add_action(
    'wp_ajax_nopriv_submit_produkt_form',
    [KontrolliRaportimeve::get_instance(), 'submit_produkt_form']
);  

add_action(
    'wp_ajax_submit_produkt_form',
    [KontrolliRaportimeve::get_instance(), 'submit_produkt_form']
);  

