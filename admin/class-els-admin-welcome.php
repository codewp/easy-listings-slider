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
	 * Renders getting started screen.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function getting_started_screen() {
		echo '<div class="wrap about-wrap">';
		$this->easy_listings_slider();
		$this->tabs();
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
