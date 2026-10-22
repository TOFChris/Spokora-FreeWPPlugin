<?php
/**
 * Module: Search ping — IndexNow when a public page changes.
 *
 * @package Spokora
 */

if ( ! defined( 'WPINC' ) ) {
	die();
}

class Spokora_IndexNow {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 22 );
		add_action( 'template_redirect', 'spokora_indexnow_maybe_serve', 0 );
		add_action( 'transition_post_status', 'spokora_indexnow_on_status', 10, 3 );
		add_action( 'admin_post_spokora_indexnow_ping', array( $this, 'manual_ping' ) );
	}

	public function admin_menu() {
		add_submenu_page(
			spokora_admin_menu_slug(),
			__( 'Search ping', 'spokora' ),
			__( 'Search ping', 'spokora' ),
			'manage_options',
			'spokora-indexnow',
			array( $this, 'render_page' )
		);
	}

	public function manual_ping() {
		if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'spokora_indexnow_ping' ) ) {
			wp_die( esc_html__( 'Please try that again.', 'spokora' ) );
		}
		spokora_indexnow_ping( home_url( '/' ), true );
		wp_safe_redirect( admin_url( 'admin.php?page=spokora-indexnow&pinged=1' ) );
		exit;
	}

	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$last = get_option( 'spokora_indexnow_last', array() );
		$key  = spokora_indexnow_key_url();
		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'Search ping', 'spokora' ); ?></h1>
			<p><?php echo esc_html__( 'When a public page is published, updated, or taken down, Spokora tells IndexNow. Bing and other participating engines use that. Google does not. News still goes out through the news sitemap.', 'spokora' ); ?></p>
			<?php if ( isset( $_GET['pinged'] ) ) : ?>
				<div class="notice notice-success is-dismissible"><p><?php echo esc_html__( 'The homepage was sent.', 'spokora' ); ?></p></div>
			<?php endif; ?>
			<p><strong><?php echo esc_html__( 'Key file', 'spokora' ); ?></strong><br /><a href="<?php echo esc_url( $key ); ?>"><code><?php echo esc_html( $key ); ?></code></a></p>
			<?php if ( is_array( $last ) && ! empty( $last['url'] ) ) : ?>
				<p>
					<?php
					echo esc_html(
						sprintf(
							/* translators: 1: time, 2: URL, 3: HTTP code or "sent" */
							__( 'Last ping %1$s — %2$s (%3$s)', 'spokora' ),
							wp_date( 'M j, Y g:i a', isset( $last['time'] ) ? (int) $last['time'] : time() ),
							(string) $last['url'],
							! empty( $last['code'] ) ? (string) (int) $last['code'] : __( 'sent', 'spokora' )
						)
					);
					?>
				</p>
			<?php else : ?>
				<p><?php echo esc_html__( 'No ping yet. The next publish will send one.', 'spokora' ); ?></p>
			<?php endif; ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="spokora_indexnow_ping" />
				<?php wp_nonce_field( 'spokora_indexnow_ping' ); ?>
				<?php submit_button( __( 'Send the homepage now', 'spokora' ), 'secondary', 'submit', false ); ?>
			</form>
		</div>
		<?php
	}
}

new Spokora_IndexNow();
