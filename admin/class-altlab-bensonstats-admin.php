<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://luetkemj.github.io
 * @since      1.0.0
 *
 * @package    Altlab_Bensonstats
 * @subpackage Altlab_Bensonstats/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Altlab_Bensonstats
 * @subpackage Altlab_Bensonstats/admin
 * @author     Mark Luetke <luetkemj@gmail.com>
 */
class Altlab_Bensonstats_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Altlab_Bensonstats_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Altlab_Bensonstats_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/altlab-bensonstats-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Altlab_Bensonstats_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Altlab_Bensonstats_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/altlab-bensonstats-admin.js', array( 'jquery' ), $this->version, false );

	}



public function add_data_to_wp_json(){

	// global $post;

    function qod_add_custom_meta_to_posts( $data, $post, $context ) {
      // We only want to modify the 'view' context, for reading posts
      if ( $context !== 'view' || is_wp_error( $data ) ) {
        return $data;
      }

	$author_id = $post['post_author'];

      $author_display_name = get_the_author_meta( 'display_name', $author_id );

      // if ( ! empty( $source ) ) {
        // $data['author_display_name'] = $author_id;
         $data['author_display_name'] = $author_display_name;
      // }

      return $data;
    }

    add_filter( 'json_prepare_post', 'qod_add_custom_meta_to_posts', 10, 3 );

}

	public function shortcodes() {
        
        function sifter_func( $atts ) {

			$blogusers = get_users( array( 'fields' => array( 'display_name' ) ) ); 
			$sifter_authors = '';

			foreach ( $blogusers as $user ) {
				$sifter_authors .= '<option value="' . esc_html( $user->display_name ) . '">' . esc_html( $user->display_name ) . '</option>';
			}

		    $a = shortcode_atts( array(
		        'post_name' => 'Posts',
		        'post_output' => 'excerpt',
		    ), $atts );

		    return "
				<div ng-app='benson'>
				  <div ng-controller='MainController'>

					<p class='ng-search'>
						<input ng-model='search.$' placeholder='search'>
					</p>

					<p class='filters'>
						<select name='select' ng-model='search.author_display_name'>
						  <option value='' selected='selected'>Select Author</option>
						  ".$sifter_authors."
						</select>	
					</p>


					{{ data.Math = window.Math }}

					<table>
					<tr>
						<td>All ".$a['post_name']."</td>
						<td>{{data.length}}</td>
					</tr>
					<tr>
						<td>".$a['post_name']." by <strong>{{search.author_display_name && search.author_display_name  || '...' }}</strong></td>
						<td>{{(data|filter:search).length}}</td>
					</tr>

					<tr>
						<td>".$a['post_name']." about <strong>{{search && search.$ || '...' }}</strong></td>
						<td>{{(data|filter:search).length}}</td>
					</tr>

					<tr>
						<td>Percent of total</td>
						<td>{{ (data|filter:search).length/data.length*100 | number:0 }}%</td>
					</tr>


					</table>

      <div ng-show='spinner' class='spinner-wrap'>
        <div class='spinner'>
          <div class='ball'></div>
          <p>LOADING</p>
        </div>
      </div>

					<div dir-paginate='
						post in data | 
						filter:search | 
						itemsPerPage: 10
					'>

					<div>
				      <h2><a href='{{post.link}}'>{{post.title}}</a></h2>
				      <div ng-bind-html='post.".$a['post_output']."'>{{post.".$a['post_output']."}}</div>
				    </div>
				  
				  </div>

					<dir-pagination-controls boundary-links='true' on-page-change='pageChangeHandler(newPageNumber)' template-url='".plugin_dir_url( __FILE__ )."/templates/dirPagination.tpl.html'></dir-pagination-controls>

				</div>
		    ";
		}
		add_shortcode( 'sifter', 'sifter_func' );
    }

}
