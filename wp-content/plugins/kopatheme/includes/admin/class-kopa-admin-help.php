<?php
/**
 * Add some content to the help tab.
 *
 * @author 		Kopatheme
 * @category 	Admin
 * @package 	KopaFramework/Admin
 * @since       1.0.0
 * @folked      WC_Admin_Help class from WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Kopa_Admin_Help' ) ) :

/**
 * Kopa_Admin_Help Class
 */
class Kopa_Admin_Help {

	/**
	 * Hook in tabs.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( "current_screen", array( $this, 'add_tabs' ), 50 );
	}

	/**
	 * Add help tabs
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function add_tabs() {
		$screen = get_current_screen();

		if ( ! in_array( $screen->id, kopa_get_screen_ids() ) )
			return;

		$screen->add_help_tab( array(
		    'id'	=> 'kopa_framework_docs_tab',
		    'title'	=> esc_html__( 'Documentation', 'kopatheme' ),
		    'content'	=>

		    	'<p>' . esc_html__( 'Thank you for using Kopa Framework. Should you need help using or extending Kopa Framework please read the documentation.', 'kopatheme' ) . '</p>' .

		    	'<p><a href="#docs" class="button button-primary">' . esc_html__( 'Kopa Framework Documentation', 'kopatheme' ) . '</a> <a href="#api" class="button">' . esc_html__( 'Developer API Docs', 'kopatheme' ) . '</a></p>'

		) );

		$screen->add_help_tab( array(
		    'id'	=> 'kopa_framework_support_tab',
		    'title'	=> esc_html__( 'Support', 'kopatheme' ),
		    'content'	=>

		    	'<p>' . sprintf(esc_html__( 'After <a href="%s">reading the documentation</a>, for further assistance you can use the <a href="%s">community forum</a>, or if you have access as a Kopatheme customer, <a href="%s">our support desk</a>.', 'kopatheme' ), '#doc', '#community', '#ticket' ) . '</p>' .

		    	'<p><a href="' . '#' . '" class="button">' . esc_html__( 'Community Support', 'kopatheme' ) . '</a> <a href="' . '#' . '" class="button">' . esc_html__( 'Customer Support', 'kopatheme' ) . '</a></p>'

		) );

		$screen->add_help_tab( array(
		    'id'	=> 'kopa_framework_bugs_tab',
		    'title'	=> esc_html__( 'Found a bug?', 'kopatheme' ),
		    'content'	=>

		    	'<p>' . sprintf(esc_html__( 'If you find a bug within Kopa Framework core you can create a ticket via <a href="%s">Kopatheme ticket</a>. Ensure you read the <a href="%s">contribution guide</a> prior to submitting your report. Be as descriptive as possible.', 'kopatheme' ), '#ticket', '#guide') . '</p>' .

		    	'<p><a href="#report" class="button button-primary">' . esc_html__( 'Report a bug', 'kopatheme' ) . '</a></p>'

		) );


		$screen->set_help_sidebar(
			'<p><strong>' . esc_html__( 'For more information:', 'kopatheme' ) . '</strong></p>' .
			'<p><a href="#" target="_blank">' . esc_html__( 'About Kopa Framework', 'kopatheme' ) . '</a></p>' .
			'<p><a href="#" target="_blank">' . esc_html__( 'Project on WordPress.org', 'kopatheme' ) . '</a></p>' .
			'<p><a href="#" target="_blank">' . esc_html__( 'Official Themes', 'kopatheme' ) . '</a></p>'
		);
	}

}

endif;

return new Kopa_Admin_Help();