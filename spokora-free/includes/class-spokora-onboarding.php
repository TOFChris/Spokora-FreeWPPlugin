<?php
/**
 * Spokora Free Quick setup — SEO only, no vault.
 *
 * @package Spokora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fresh: path → business → home → live.
 * Agency: path → switcher (backup + hijack) → business → home → live.
 */
class Spokora_Onboarding {

	public function __construct() {
		add_action( 'admin_init', array( $this, 'maybe_activation_redirect' ), 1 );
		add_action( 'admin_menu', array( $this, 'register_submenu' ), 11 );
		add_action( 'admin_post_spokora_onboarding_profile', array( $this, 'handle_profile' ) );
		add_action( 'admin_post_spokora_onboarding_seed', array( $this, 'handle_business_info' ) );
		add_action( 'admin_post_spokora_onboarding_home_seo', array( $this, 'handle_home_seo' ) );
		add_action( 'admin_post_spokora_onboarding_finish', array( $this, 'handle_finish' ) );
		add_action( 'admin_post_spokora_onboarding_skip', array( $this, 'handle_skip' ) );
		add_action( 'admin_notices', array( $this, 'maybe_admin_notice' ) );
		if ( defined( 'SPOKORA_PLUGIN_FILE' ) ) {
			add_filter( 'plugin_action_links_' . plugin_basename( SPOKORA_PLUGIN_FILE ), array( $this, 'plugin_action_links' ) );
		}
	}

	public function maybe_activation_redirect() {
		if ( wp_doing_ajax() || ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( get_transient( 'spokora_activation_redirect' ) ) {
			delete_transient( 'spokora_activation_redirect' );
			wp_safe_redirect( admin_url( 'admin.php?page=spokora-setup&step=1' ) );
			exit;
		}
		if ( get_transient( 'spokora_upgrade_wizard_redirect' ) ) {
			delete_transient( 'spokora_upgrade_wizard_redirect' );
			wp_safe_redirect( admin_url( 'admin.php?page=spokora-setup&step=1&spokora_upgraded=1' ) );
			exit;
		}
	}

	public function register_submenu() {
		add_submenu_page(
			spokora_admin_menu_slug(),
			__( 'Quick setup', 'spokora-free' ),
			__( 'Quick setup', 'spokora-free' ),
			'manage_options',
			'spokora-setup',
			array( $this, 'render_wizard' ),
			1
		);
	}

	/**
	 * @param array<int, string> $links Links.
	 * @return array<int, string>
	 */
	public function plugin_action_links( $links ) {
		if ( ! is_array( $links ) ) {
			$links = array();
		}
		array_unshift(
			$links,
			'<a href="' . esc_url( admin_url( 'admin.php?page=spokora-setup&step=1' ) ) . '">' . esc_html__( 'Quick setup', 'spokora-free' ) . '</a>',
			'<a href="' . esc_url( admin_url( 'admin.php?page=spokora-help' ) ) . '">' . esc_html__( 'Help', 'spokora-free' ) . '</a>'
		);
		return $links;
	}

	public function maybe_admin_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( ! $this->is_onboarding_pending() ) {
			return;
		}
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( $screen && ( 'toplevel_page_spokora' === $screen->id || 'spokora_page_spokora-setup' === $screen->id ) ) {
			return;
		}
		$url = admin_url( 'admin.php?page=spokora-setup&step=1' );
		echo '<div class="notice notice-info"><p>';
		echo wp_kses_post(
			sprintf(
				__( 'Spokora Free: run %1$sQuick setup%2$s for baseline SEO.', 'spokora-free' ),
				'<a href="' . esc_url( $url ) . '">',
				'</a>'
			)
		);
		echo '</p></div>';
	}

	private function is_onboarding_pending() {
		return '1' === get_option( 'spokora_onboarding_pending', '0' );
	}

	private function get_opts() {
		$opts = get_option( 'spokora_options' );
		return is_array( $opts ) ? $opts : array();
	}

	private function save_opts( array $opts ) {
		update_option( 'spokora_options', $opts );
	}

	public function handle_profile() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied.', 'spokora-free' ) );
		}
		check_admin_referer( 'spokora_onboarding_profile' );
		$raw = isset( $_POST['spokora_setup_profile'] ) ? sanitize_key( wp_unslash( $_POST['spokora_setup_profile'] ) ) : 'fresh';
		if ( ! in_array( $raw, array( 'fresh', 'agency' ), true ) ) {
			$raw = 'fresh';
		}
		update_option( 'spokora_setup_profile', $raw );
		wp_safe_redirect( $this->setup_url( 2 ) );
		exit;
	}

	public function handle_business_info() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied.', 'spokora-free' ) );
		}
		check_admin_referer( 'spokora_onboarding_seed' );
		$opts = $this->get_opts();
		foreach ( $this->business_info_text_keys() as $key ) {
			if ( ! isset( $_POST[ $key ] ) ) {
				continue;
			}
			$opts[ $key ] = sanitize_text_field( wp_unslash( $_POST[ $key ] ) );
		}
		if ( isset( $_POST['global_desc'] ) ) {
			$opts['global_desc'] = sanitize_textarea_field( wp_unslash( $_POST['global_desc'] ) );
		}
		if ( isset( $_POST['schema_type'] ) ) {
			$opts['schema_type'] = function_exists( 'spokora_sanitize_schema_type' )
				? spokora_sanitize_schema_type( wp_unslash( $_POST['schema_type'] ) )
				: 'ProfessionalService';
		}
		$org = isset( $opts['hwc_org_name'] ) ? trim( (string) $opts['hwc_org_name'] ) : '';
		if ( '' === $org ) {
			wp_safe_redirect( add_query_arg( 'setup_err', 'org', $this->setup_url( $this->step_number_for( 'business' ) ) ) );
			exit;
		}
		$opts['hwc_org_name'] = $org;
		$this->save_opts( $opts );
		wp_safe_redirect( $this->setup_url( $this->step_number_for( 'home' ) ) );
		exit;
	}

	/**
	 * @return list<string>
	 */
	private function sequence() {
		if ( 'agency' === spokora_get_setup_profile() ) {
			return array( 'path', 'switcher', 'business', 'home', 'live' );
		}
		return array( 'path', 'business', 'home', 'live' );
	}

	/**
	 * @param string $id Step id.
	 * @return int
	 */
	private function step_number_for( $id ) {
		$i = array_search( $id, $this->sequence(), true );
		return false === $i ? 1 : $i + 1;
	}

	/**
	 * @param int $step 1-based step.
	 * @return string
	 */
	private function setup_url( $step ) {
		return admin_url( 'admin.php?page=spokora-setup&step=' . (int) $step );
	}

	/**
	 * @param int $step 1-based step.
	 * @return string
	 */
	private function step_id_at( $step ) {
		$seq = $this->sequence();
		$i   = max( 0, (int) $step - 1 );
		return isset( $seq[ $i ] ) ? $seq[ $i ] : 'path';
	}

	/**
	 * @return list<string>
	 */
	private function business_info_text_keys() {
		return array(
			'hwc_org_name',
			'hwc_logo_url',
			'hwc_public_email',
			'schema_phone',
			'schema_street',
			'schema_city',
			'schema_region',
			'schema_zip',
			'og_image',
		);
	}

	/**
	 * Prefill from saved options, then WordPress site identity.
	 *
	 * @param array<string, mixed> $opts Options.
	 * @return array<string, string>
	 */
	private function business_info_values( array $opts ) {
		$str = static function ( $opts, $key ) {
			return isset( $opts[ $key ] ) && is_string( $opts[ $key ] ) ? $opts[ $key ] : '';
		};
		$org = $str( $opts, 'hwc_org_name' );
		if ( '' === $org ) {
			$org = sanitize_text_field( get_bloginfo( 'name' ) );
		}
		$desc = $str( $opts, 'global_desc' );
		if ( '' === $desc ) {
			$tag = get_bloginfo( 'description', 'display' );
			$desc = is_string( $tag ) ? $tag : '';
		}
		$email = $str( $opts, 'hwc_public_email' );
		if ( '' === $email ) {
			$email = sanitize_email( (string) get_option( 'admin_email' ) );
		}
		$type = $str( $opts, 'schema_type' );
		if ( '' === $type ) {
			$type = 'ProfessionalService';
		}
		$out = array(
			'hwc_org_name'     => $org,
			'global_desc'      => $desc,
			'schema_type'      => $type,
			'hwc_public_email' => $email,
		);
		foreach ( array( 'hwc_logo_url', 'schema_phone', 'schema_street', 'schema_city', 'schema_region', 'schema_zip', 'og_image' ) as $key ) {
			$out[ $key ] = $str( $opts, $key );
		}
		return $out;
	}

	public function handle_home_seo() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied.', 'spokora-free' ) );
		}
		check_admin_referer( 'spokora_onboarding_home_seo' );
		$opts = $this->get_opts();
		if ( isset( $_POST['hwc_home_title'] ) ) {
			$opts['hwc_home_title'] = sanitize_text_field( wp_unslash( $_POST['hwc_home_title'] ) );
		}
		if ( isset( $_POST['hwc_home_desc'] ) ) {
			$opts['hwc_home_desc'] = sanitize_textarea_field( wp_unslash( $_POST['hwc_home_desc'] ) );
		}
		$this->save_opts( $opts );
		wp_safe_redirect( $this->setup_url( $this->step_number_for( 'live' ) ) );
		exit;
	}

	public function handle_finish() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied.', 'spokora-free' ) );
		}
		check_admin_referer( 'spokora_onboarding_finish' );
		update_option( 'spokora_onboarding_pending', '0' );
		wp_safe_redirect( admin_url( 'admin.php?page=' . spokora_dashboard_page_slug() . '&spokora_setup=done' ) );
		exit;
	}

	public function handle_skip() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied.', 'spokora-free' ) );
		}
		check_admin_referer( 'spokora_onboarding_skip' );
		update_option( 'spokora_onboarding_pending', '0' );
		wp_safe_redirect( admin_url( 'admin.php?page=' . spokora_dashboard_page_slug() ) );
		exit;
	}

	public function render_wizard() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$seq      = $this->sequence();
		$max      = count( $seq );
		$step     = isset( $_GET['step'] ) ? absint( wp_unslash( $_GET['step'] ) ) : 1;
		$step     = max( 1, min( $max, $step ) );
		$opts     = $this->get_opts();
		$skip_url = wp_nonce_url( admin_url( 'admin-post.php?action=spokora_onboarding_skip' ), 'spokora_onboarding_skip' );
		$names    = array(
			'path'     => __( 'Your path', 'spokora-free' ),
			'switcher' => __( 'Backup & import', 'spokora-free' ),
			'business' => __( 'Business Info', 'spokora-free' ),
			'home'     => __( 'Home page', 'spokora-free' ),
			'live'     => __( 'Go live', 'spokora-free' ),
		);
		$current  = $this->step_id_at( $step );
		?>
		<div class="wrap spokora-setup">
			<h1><?php echo esc_html__( 'Spokora Free — Quick setup', 'spokora-free' ); ?></h1>
			<p class="description"><?php echo esc_html__( 'No API keys. If you already have an SEO plugin, back up and import first. Then Business Info.', 'spokora-free' ); ?></p>
			<?php if ( function_exists( 'spokora_self_hosted_admin_notice_text' ) ) : ?>
				<div class="notice notice-warning inline"><p><?php echo esc_html( spokora_self_hosted_admin_notice_text() ); ?></p></div>
			<?php endif; ?>
			<ol class="spokora-setup__steps">
				<?php foreach ( $seq as $i => $id ) : ?>
					<?php $n = $i + 1; ?>
					<li <?php echo $n === $step ? 'class="is-current"' : ''; ?>>
						<?php
						if ( $n < $step ) {
							echo '<a href="' . esc_url( $this->setup_url( $n ) ) . '">';
						}
						echo esc_html( isset( $names[ $id ] ) ? $names[ $id ] : $id );
						if ( $n < $step ) {
							echo '</a>';
						}
						?>
					</li>
				<?php endforeach; ?>
			</ol>
			<div class="spokora-setup__card">
				<?php
				if ( 'path' === $current ) {
					$this->render_step_welcome();
				} elseif ( 'switcher' === $current ) {
					$this->render_step_switcher();
				} elseif ( 'business' === $current ) {
					$this->render_step_business_info( $opts );
				} elseif ( 'home' === $current ) {
					$this->render_step_home( $opts );
				} else {
					$this->render_step_finish();
				}
				?>
			</div>
			<p><a href="<?php echo esc_url( $skip_url ); ?>"><?php echo esc_html__( 'Dismiss this reminder', 'spokora-free' ); ?></a></p>
			<style>
				.spokora-setup__steps { display: flex; flex-wrap: wrap; gap: 0.75rem 1.25rem; list-style: none; margin: 1.25rem 0; padding: 0; font-weight: 600; }
				.spokora-setup__steps li.is-current { color: #0056d2; }
				.spokora-setup__card { max-width: 720px; background: #fff; border: 1px solid #c3c4c7; border-radius: 4px; padding: 1.5rem; }
				.spokora-setup__path { display: block; width: 100%; text-align: left; background: #fff; border: 1px solid #c3c4c7; border-radius: 8px; padding: 16px; margin: 0 0 12px; cursor: pointer; }
			</style>
		</div>
		<?php
	}

	private function render_step_welcome() {
		$profile = spokora_get_setup_profile();
		?>
		<h2><?php echo esc_html__( 'How are you setting this up?', 'spokora-free' ); ?></h2>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'spokora_onboarding_profile' ); ?>
			<input type="hidden" name="action" value="spokora_onboarding_profile" />
			<button type="submit" class="spokora-setup__path" name="spokora_setup_profile" value="fresh">
				<strong><?php echo esc_html__( 'Starting fresh', 'spokora-free' ); ?></strong><br />
				<?php echo esc_html__( 'First SEO plugin on this site. Next: Business Info, then the home page.', 'spokora-free' ); ?>
			</button>
			<button type="submit" class="spokora-setup__path" name="spokora_setup_profile" value="agency">
				<strong><?php echo esc_html__( 'I already have a setup', 'spokora-free' ); ?></strong><br />
				<?php echo esc_html__( 'Yoast, Rank Math, AIOSEO, or SEOPress is already here. Next: download a backup, import SEO, then Business Info.', 'spokora-free' ); ?>
			</button>
		</form>
		<?php
		unset( $profile );
	}

	private function render_step_switcher() {
		$legacy = function_exists( 'spokora_detect_active_legacy_seo_plugins' ) ? spokora_detect_active_legacy_seo_plugins() : array();
		$next   = $this->setup_url( $this->step_number_for( 'business' ) );
		?>
		<h2><?php echo esc_html__( 'Protect the old setup, then import it', 'spokora-free' ); ?></h2>
		<p><?php echo esc_html__( 'Do this before Business Info. Download a backup first. Then copy titles, descriptions, and exact 301s out of the old SEO plugin. You can come back to either button.', 'spokora-free' ); ?></p>
		<?php if ( isset( $_GET['migration'] ) && 'success' === $_GET['migration'] ) : ?>
			<div class="notice notice-success inline"><p>
				<?php
				echo esc_html(
					sprintf(
						/* translators: %d: fields imported */
						__( 'Import finished. Imported %d SEO fields.', 'spokora-free' ),
						isset( $_GET['count'] ) ? absint( $_GET['count'] ) : 0
					)
				);
				?>
			</p></div>
		<?php endif; ?>
		<?php if ( $legacy ) : ?>
			<div class="notice notice-warning inline"><p>
				<?php echo esc_html__( 'Detected:', 'spokora-free' ); ?>
				<strong><?php echo esc_html( implode( ', ', array_values( $legacy ) ) ); ?></strong>
			</p></div>
		<?php else : ?>
			<p class="description"><?php echo esc_html__( 'No Yoast, Rank Math, AIOSEO, or SEOPress is active. You can still download a backup, then continue.', 'spokora-free' ); ?></p>
		<?php endif; ?>

		<div class="spokora-setup__actions">
			<section class="spokora-home-panel">
				<h3><?php echo esc_html__( '1. Backup', 'spokora-free' ); ?></h3>
				<p><?php echo esc_html__( 'One-button zip of the database and wp-content. Stay on this page until the download starts.', 'spokora-free' ); ?></p>
				<?php
				if ( function_exists( 'spokora_free_render_backup_form' ) ) {
					spokora_free_render_backup_form();
				} else {
					echo '<p><a class="button" href="' . esc_url( admin_url( 'admin.php?page=spokora-backups' ) ) . '">' . esc_html__( 'Open Backups', 'spokora-free' ) . '</a></p>';
				}
				?>
			</section>
			<section class="spokora-home-panel">
				<h3><?php echo esc_html__( '2. Import SEO', 'spokora-free' ); ?></h3>
				<p><?php echo esc_html__( 'Copy titles, descriptions, keyphrases, and exact 301s into Spokora. Turn the old plugin off later, after titles look right.', 'spokora-free' ); ?></p>
				<form method="post" action="<?php echo esc_url( $this->setup_url( $this->step_number_for( 'switcher' ) ) ); ?>">
					<?php wp_nonce_field( 'spokora_run_migration_action', 'spokora_migration_nonce' ); ?>
					<input type="hidden" name="spokora_run_migration" value="1" />
					<input type="hidden" name="spokora_setup_return" value="1" />
					<input type="hidden" name="spokora_setup_step" value="<?php echo esc_attr( (string) $this->step_number_for( 'switcher' ) ); ?>" />
					<?php submit_button( __( 'Import SEO', 'spokora-free' ), 'primary', 'submit', false ); ?>
				</form>
			</section>
		</div>
		<p>
			<a class="button button-primary" href="<?php echo esc_url( $next ); ?>"><?php echo esc_html__( 'Continue to Business Info', 'spokora-free' ); ?></a>
			<a class="button" href="<?php echo esc_url( admin_url( 'admin.php?page=spokora-legacy-import' ) ); ?>"><?php echo esc_html__( 'Full Import SEO screen', 'spokora-free' ); ?></a>
		</p>
		<style>
			.spokora-setup__actions { display: grid; gap: 1rem; margin: 1rem 0; }
			@media (min-width: 720px) { .spokora-setup__actions { grid-template-columns: 1fr 1fr; } }
			.spokora-setup__actions h3 { margin-top: 0; }
		</style>
		<?php
	}

	/**
	 * @param array<string, mixed> $opts Options.
	 */
	private function render_step_business_info( array $opts ) {
		$legacy = function_exists( 'spokora_detect_active_legacy_seo_plugins' ) ? spokora_detect_active_legacy_seo_plugins() : array();
		$v      = $this->business_info_values( $opts );
		$err    = isset( $_GET['setup_err'] ) && 'org' === sanitize_key( wp_unslash( $_GET['setup_err'] ) );
		?>
		<h2><?php echo esc_html__( 'Business Info', 'spokora-free' ); ?></h2>
		<p><?php echo esc_html__( 'This is the baseline. Schema and fallbacks use these fields. We pulled what WordPress already knows — check it, fill the blanks, then continue. Same data lives under Spokora → Business Info if you need to edit later.', 'spokora-free' ); ?></p>
		<?php if ( $err ) : ?>
			<div class="notice notice-error inline"><p><?php echo esc_html__( 'Organization name is required before you go further.', 'spokora-free' ); ?></p></div>
		<?php endif; ?>
		<?php if ( $legacy ) : ?>
			<div class="notice notice-warning inline"><p>
				<?php
				if ( 'agency' === spokora_get_setup_profile() ) {
					echo esc_html__( 'A legacy SEO plugin is still active. If you have not imported yet, go back one step. Turn the old plugin off after titles look right.', 'spokora-free' );
				} else {
					echo esc_html__( 'A legacy SEO plugin is active. You can import later from Configure → Import SEO.', 'spokora-free' );
				}
				?>
				<strong><?php echo esc_html( implode( ', ', array_values( $legacy ) ) ); ?></strong>
			</p></div>
		<?php endif; ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'spokora_onboarding_seed' ); ?>
			<input type="hidden" name="action" value="spokora_onboarding_seed" />
			<p>
				<label for="hwc_org_name"><strong><?php echo esc_html__( 'Organization name', 'spokora-free' ); ?></strong></label><br />
				<input type="text" class="large-text" id="hwc_org_name" name="hwc_org_name" required value="<?php echo esc_attr( $v['hwc_org_name'] ); ?>" />
			</p>
			<p>
				<label for="schema_type"><strong><?php echo esc_html__( 'Business type', 'spokora-free' ); ?></strong></label><br />
				<?php
				if ( function_exists( 'spokora_render_schema_type_select' ) ) {
					spokora_render_schema_type_select(
						$v['schema_type'],
						array(
							'name'        => 'schema_type',
							'id'          => 'schema_type',
							'class'       => 'large-text',
							'style'       => 'max-width: 100%; width: 32em;',
							'text_domain' => 'spokora-free',
						)
					);
				}
				?>
				<br /><span class="description"><?php echo esc_html__( 'Used as schema.org @type for your site-wide Organization entity in JSON-LD.', 'spokora-free' ); ?></span>
			</p>
			<p>
				<label for="global_desc"><strong><?php echo esc_html__( 'Global meta description', 'spokora-free' ); ?></strong></label><br />
				<textarea class="large-text" rows="3" id="global_desc" name="global_desc"><?php echo esc_textarea( $v['global_desc'] ); ?></textarea>
			</p>
			<p>
				<label for="hwc_public_email"><strong><?php echo esc_html__( 'Public email', 'spokora-free' ); ?></strong></label><br />
				<input type="email" class="large-text" id="hwc_public_email" name="hwc_public_email" value="<?php echo esc_attr( $v['hwc_public_email'] ); ?>" />
			</p>
			<p>
				<label for="schema_phone"><strong><?php echo esc_html__( 'Phone', 'spokora-free' ); ?></strong></label><br />
				<input type="text" class="large-text" id="schema_phone" name="schema_phone" value="<?php echo esc_attr( $v['schema_phone'] ); ?>" />
			</p>
			<p>
				<label for="schema_street"><strong><?php echo esc_html__( 'Street', 'spokora-free' ); ?></strong></label><br />
				<input type="text" class="large-text" id="schema_street" name="schema_street" value="<?php echo esc_attr( $v['schema_street'] ); ?>" />
			</p>
			<p>
				<label for="schema_city"><strong><?php echo esc_html__( 'City', 'spokora-free' ); ?></strong></label><br />
				<input type="text" class="large-text" id="schema_city" name="schema_city" value="<?php echo esc_attr( $v['schema_city'] ); ?>" />
			</p>
			<p>
				<label for="schema_region"><strong><?php echo esc_html__( 'State', 'spokora-free' ); ?></strong></label><br />
				<input type="text" id="schema_region" name="schema_region" value="<?php echo esc_attr( $v['schema_region'] ); ?>" />
				<label for="schema_zip"><strong><?php echo esc_html__( 'Zip', 'spokora-free' ); ?></strong></label>
				<input type="text" id="schema_zip" name="schema_zip" value="<?php echo esc_attr( $v['schema_zip'] ); ?>" />
			</p>
			<p>
				<label for="hwc_logo_url"><strong><?php echo esc_html__( 'Logo URL (512x512)', 'spokora-free' ); ?></strong></label><br />
				<input type="url" class="large-text" id="hwc_logo_url" name="hwc_logo_url" value="<?php echo esc_attr( $v['hwc_logo_url'] ); ?>" />
			</p>
			<p>
				<label for="og_image"><strong><?php echo esc_html__( 'Default Open Graph image URL', 'spokora-free' ); ?></strong></label><br />
				<input type="url" class="large-text" id="og_image" name="og_image" value="<?php echo esc_attr( $v['og_image'] ); ?>" />
			</p>
			<p>
				<button type="submit" class="button button-primary"><?php echo esc_html__( 'Save Business Info & continue', 'spokora-free' ); ?></button>
				<a class="button" href="<?php echo esc_url( $this->setup_url( $this->step_number_for( 'home' ) ) ); ?>"><?php echo esc_html__( 'Skip for now', 'spokora-free' ); ?></a>
			</p>
			<p class="description"><?php echo esc_html__( 'Skip only if you will fill Spokora → Business Info before you publish. Organization name is the one field we will not silently invent.', 'spokora-free' ); ?></p>
		</form>
		<?php
	}

	/**
	 * @param array<string, mixed> $opts Options.
	 */
	private function render_step_home( array $opts ) {
		$title = isset( $opts['hwc_home_title'] ) ? (string) $opts['hwc_home_title'] : '';
		$desc  = isset( $opts['hwc_home_desc'] ) ? (string) $opts['hwc_home_desc'] : '';
		if ( '' === $title && ! empty( $opts['hwc_org_name'] ) ) {
			$title = (string) $opts['hwc_org_name'];
		}
		if ( '' === $desc && ! empty( $opts['global_desc'] ) ) {
			$desc = (string) $opts['global_desc'];
		}
		?>
		<h2><?php echo esc_html__( 'Home page SEO', 'spokora-free' ); ?></h2>
		<p><?php echo esc_html__( 'Front page only. Prefills from Business Info when these are empty.', 'spokora-free' ); ?></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'spokora_onboarding_home_seo' ); ?>
			<input type="hidden" name="action" value="spokora_onboarding_home_seo" />
			<p><label for="hwc_home_title"><strong><?php echo esc_html__( 'Home page meta title', 'spokora-free' ); ?></strong></label><br />
			<input type="text" class="large-text" id="hwc_home_title" name="hwc_home_title" value="<?php echo esc_attr( $title ); ?>" /></p>
			<p><label for="hwc_home_desc"><strong><?php echo esc_html__( 'Home page meta description', 'spokora-free' ); ?></strong></label><br />
			<textarea class="large-text" rows="3" id="hwc_home_desc" name="hwc_home_desc"><?php echo esc_textarea( $desc ); ?></textarea></p>
			<p><button type="submit" class="button button-primary"><?php echo esc_html__( 'Save & continue', 'spokora-free' ); ?></button>
			<a class="button" href="<?php echo esc_url( $this->setup_url( $this->step_number_for( 'live' ) ) ); ?>"><?php echo esc_html__( 'Skip', 'spokora-free' ); ?></a></p>
		</form>
		<?php
	}

	private function render_step_finish() {
		?>
		<h2><?php echo esc_html__( 'Go live', 'spokora-free' ); ?></h2>
		<ul>
			<li><a href="<?php echo esc_url( admin_url( 'admin.php?page=spokora-settings' ) ); ?>"><?php echo esc_html__( 'Confirm Business Info', 'spokora-free' ); ?></a></li>
			<li><a href="<?php echo esc_url( admin_url( 'options-permalink.php' ) ); ?>"><?php echo esc_html__( 'Settings → Permalinks → Save', 'spokora-free' ); ?></a></li>
			<?php if ( 'agency' === spokora_get_setup_profile() ) : ?>
				<li><a href="<?php echo esc_url( admin_url( 'admin.php?page=spokora-legacy-import' ) ); ?>"><?php echo esc_html__( 'Import SEO — if you skipped import earlier', 'spokora-free' ); ?></a></li>
				<li><a href="<?php echo esc_url( admin_url( 'admin.php?page=spokora-backups' ) ); ?>"><?php echo esc_html__( 'Backups — download again anytime', 'spokora-free' ); ?></a></li>
			<?php endif; ?>
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'Check the front page', 'spokora-free' ); ?></a></li>
		</ul>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'spokora_onboarding_finish' ); ?>
			<input type="hidden" name="action" value="spokora_onboarding_finish" />
			<p><button type="submit" class="button button-primary"><?php echo esc_html__( 'Finish setup', 'spokora-free' ); ?></button></p>
		</form>
		<?php
		if ( function_exists( 'spokora_render_pro_teaser' ) ) {
			spokora_render_pro_teaser( 'compact' );
		}
	}
}

/**
 * @return string fresh|agency|empty
 */
function spokora_get_setup_profile() {
	$profile = get_option( 'spokora_setup_profile', '' );
	$profile = is_string( $profile ) ? $profile : '';
	return in_array( $profile, array( 'fresh', 'agency' ), true ) ? $profile : '';
}
