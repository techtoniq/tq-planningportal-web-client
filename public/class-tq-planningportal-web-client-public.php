<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.techtoniq.com
 * @since      1.0.0
 *
 * @package    Tq_Planningportal_Web_Client
 * @subpackage Tq_Planningportal_Web_Client/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tq_Planningportal_Web_Client
 * @subpackage Tq_Planningportal_Web_Client/public
 * @author     Techtoniq <matt@techtoniq.com>
 */
class Tq_Planningportal_Web_Client_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tq_Planningportal_Web_Client_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tq_Planningportal_Web_Client_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tq-planningportal-web-client-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tq_Planningportal_Web_Client_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tq_Planningportal_Web_Client_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tq-planningportal-web-client-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * The [tq_planningportal] shortcode.
	 *
	 * @since    1.0.0
	 * @param    array    $atts       Shortcode attributes:
	 *                                'board_type'
	 *                                'station'
	 *                                'max_rows'
	 *                                'time_offset'
	 *                                'time_window'
	 */
	public function shortcode_planningportal( $atts ) {
	
    	if ( ! is_array( $atts ) ) {
            $atts = [];
        }

        $atts = shortcode_atts( [
			'query_url'        => 'https://publicaccess2.milton-keynes.gov.uk/online-applications/simpleSearchResults.do',
			'searchkey_simple' => 'Castlethorpe',
		], $atts );

        $request_params = array(
            'query_url'        => $atts['query_url'],
            'searchkey_simple' => $atts['searchkey_simple'],
        );

		if ( ! empty( $atts['query_url'] ) ) {
			$data = $this->shortcode_planningportal_query( $request_params );
			$output = $this->shortcode_planningportal_format( $data );

			return $output;
		} else {
			return '';
		}        
	}

	/**
	 * Perform the data request.
	 *
	 * @since    1.0.0
	 * @param      array    $request_params       API request parameters.
	 */
	private function shortcode_planningportal_query( $request_params ) {
	    
	    $endpoint_url = $request_params['query_url'];    

		$postdata = array(
		  'searchType'                        => 'Application',
		  'searchCriteria.caseStatus'         => 'All',
		  'searchCriteria.simpleSearch'       => 'true',
		  'searchCriteria.simpleSearchString' => $request_params['searchkey_simple'],
		  'searchCriteria.resultsPerPage'     => '20',
		);
		$postvars = http_build_query( $postdata );

		$options = [
		  	CURLOPT_URL            => $endpoint_url . '?action=firstPage',
			CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => $postvars,
			CURLOPT_RETURNTRANSFER => true,
		];

		// Initiates the cURL object
		$ch = curl_init();		

		// Assigns our options
		curl_setopt_array($ch, $options);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // @ToDo: AWOOGA! It is not recommended to disable SSL peer verification. This is a workaround 

		// Executes the cURL POST
		$content = curl_exec($ch);
		if ($content === false) {
		        throw new Exception(curl_error($ch), curl_errno($ch));
		}

		// Be kind, tidy up!
		curl_close($ch);

	    return $content;
	}

	/**
	 * Format the shortcode output.
	 *
	 * @since    1.0.0
	 * @param      array    $data       search result page HTML content.
	 */
	private function shortcode_planningportal_format( $data ) {
	    
	    $doc = new DOMDocument();
		$doc->loadHTML( $data );

		$searchResults = $doc->getElementById( 'searchresults' );

		// Fix the links
		$html = $doc->saveHTML( $searchResults );
		$html = str_replace( 'href="/online-applications', 'target="_blank" href="https://publicaccess2.milton-keynes.gov.uk/online-applications', $html );

	    return $html;
	}
}
