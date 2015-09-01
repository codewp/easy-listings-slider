<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Welcome controller of the plugin.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Admin_Welcome extends ELS_Admin_Controller {

	/**
	 * Version of the plugin.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	private $plugin_version;

	/**
	 * @var   string The capability users should have to view the page
	 *
	 * @since 1.0.0
	 */
	public $minimum_capability = 'manage_options';

	/**
	 * Constructor of the class.
	 *
	 * @since 1.0.0
	 * @param ELS_Loader $loader
	 */
	public function __construct( ELS_Loader $loader, $plugin_version ) {
		$this->plugin_version = $plugin_version;
		$loader->add_action( 'admin_menu', $this, 'admin_menus' );
		$loader->add_action( 'admin_init', $this, 'welcome' );
		$loader->add_action( 'wp_ajax_send_subscribe_email', $this, 'send_subscribe_email' );
	}

	/**
	 * Register the Dashboard Pages which are later hidden but these pages
	 * are used to render the Welcome and Credits pages.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function admin_menus() {
		// Getting started page.
		add_dashboard_page(
			__( 'Getting started', 'els' ),
			__( 'Getting started', 'els' ),
			$this->minimum_capability,
			'els-getting-started',
			array( $this, 'getting_started_screen' )
		);
	}

	/**
	 * About easy listings slider.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	private function easy_listings_slider() {
		$this->render_view(
			'welcome.easy-listings-slider',
			array( 'plugin_version' => $this->plugin_version )
		);
	}

	/**
	 * Tabs of the welcome.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	private function tabs() {
		$selected = isset( $_GET['page'] ) ? $_GET['page'] : 'els-getting-started';
		?>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php echo $selected == 'els-getting-started' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'els-getting-started' ), 'index.php' ) ) ); ?>">
				<?php _e( 'Getting Started', 'els' ); ?>
			</a>
		</h2>
		<?php
	}

	/**
	 * Subscribe view.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	private function subscribe() {
		if ( ! get_option( '_els_subscribe', false ) ) {
			$this->render_view( 'welcome.subscribe' );
		}
	}

	/**
	 * Send subscription email.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function send_subscribe_email() {
		if ( isset( $_POST['subscribe_nonce'] ) && wp_verify_nonce( $_POST['subscribe_nonce'], 'subscribe_email_send' ) ) {
			if ( isset( $_POST['email'] ) && is_email( $_POST['email'] ) &&
				isset( $_POST['name'] ) && strlen( trim( $_POST['name'] ) ) ) {
				$response = wp_remote_post( 'https://fast-hollows-4459.herokuapp.com/send',
					array(
						'method'      => 'POST',
						'timeout'     => 45,
						'redirection' => 5,
						'httpversion' => '1.0',
						'blocking'    => true,
						'headers'     => array(),
						'body'        => array( 'name' => trim( $_POST['name'] ), 'email' => $_POST['email'], 'plugin' => 'easy-listings-slider' ),
						'cookies'     => array()
					)
				);
				if ( is_wp_error( $response ) ) {
					die( json_encode( array( 'success' => '0', 'message' => __( 'Some error occurred in subscription.', 'els' ) ) ) );
				} else {
					// Setting subscription to true in order to doesn't show subscribe popup again.
					update_option( '_els_subscribe', true );
					die( json_encode( array( 'success' => '1', 'message' => __( 'Thank you for subscription.', 'els' ) ) ) );
				}
			} else {
				die( json_encode( array( 'success' => '0', 'message' => __( 'Please validate entered name and email address.', 'els' ) ) ) );
			}
		}
	}

	/**
	 * Renders getting started screen.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function getting_started_screen() {
		echo '<div class="wrap about-wrap">';
		$this->easy_listings_slider();
		$this->tabs();
		$this->subscribe();
		$this->render_view(
			'welcome.getting-started',
			array( 'images_url' => $this->get_images_url() )
		);
		echo '</div>';
	}

	/**
	 * Sends user to the Welcome page on first activation of ELS as well as each
	 * time ELS is upgraded to a new version
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function welcome() {
		// Bail if no activation redirect
		if ( ! get_transient( '_els_activation_redirect' ) ) {
			return;
		}

		// Delete the redirect transient
		delete_transient( '_els_activation_redirect' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}

		// First time install
		wp_safe_redirect( admin_url( 'index.php?page=els-getting-started' ) );

		exit();
	}

}
