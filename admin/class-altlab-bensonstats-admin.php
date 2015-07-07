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

	public function shortcodes() {
        
        function post_stats_func( $atts ) {

			$blogusers = get_users( array( 'fields' => array( 'display_name' ) ) ); 
			$post_stats_authors = '';

			foreach ( $blogusers as $user ) {
				$post_stats_authors .= '<option value="' . esc_html( $user->display_name ) . '">' . esc_html( $user->display_name ) . '</option>';
			}


		    $a = shortcode_atts( array(
		        'post-name' => 'Posts',
		    ), $atts );

		    return "
				<div ng-app='benson'>
				  <div ng-controller='MainController'>

					<p class='ng-search'>
						<input ng-model='search.$' placeholder='search'>
					</p>

					<p class='filters'>
						<select name='select' ng-model='search.title'>
						  <option value='' selected='selected'>Select Author</option>
						  ".$post_stats_authors."
						</select>	
					</p>


					{{ data.Math = window.Math }}

					<table>
					<tr>
						<td>All ".$a['post-name']."</td>
						<td>{{data.length}}</td>
					</tr>

					<tr>
						<td>".$a['post-name']." by {{search.title && search.title  || '...' }}</td>
						<td>{{(data|filter:search).length}}</td>
					</tr>

					<tr>
						<td>".$a['post-name']." about {{search && search.$ || '...' }}</td>
						<td>{{(data|filter:search).length}}</td>
					</tr>

					<tr>
						<td>Percent of total</td>
						<td>{{ (data|filter:search).length/data.length*100 | number:0 }}%</td>
					</tr>


					</table>

					<div dir-paginate='
						post in data | 
						filter:search | 
						itemsPerPage: 10
					'>

					<div>
				      <h2><a href='{{post.link}}'>{{post.title}}</a></h2>
				      <div ng-bind-html='post.content'>{{post.content}}</div>
				    </div>
				  
				  </div>

					<dir-pagination-controls boundary-links='true' on-page-change='pageChangeHandler(newPageNumber)' template-url='".get_stylesheet_directory_uri()."/dirPagination.tpl.html'></dir-pagination-controls>

				</div>
		    ";
		}
		add_shortcode( 'post-stats', 'post_stats_func' );
    }

}
