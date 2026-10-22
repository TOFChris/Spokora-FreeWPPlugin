<?php
/**
 * Spokora Pro teasers in Free. SEO stays ungated.
 *
 * @package Spokora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Store URL for the Pro pitch (homepage tiers).
 */
function spokora_pro_url() {
	return apply_filters( 'spokora_pro_url', 'https://spokora.com/#tiers' );
}

/**
 * Admin screen that lists Pro without installing it.
 */
function spokora_go_pro_page_slug() {
	return 'spokora-go-pro';
}

/**
 * @return array<int, array{title: string, body: string, items: list<string>}>
 */
function spokora_pro_teaser_groups() {
	return array(
		array(
			'title' => __( 'Your keys, your models', 'spokora' ),
			'body'  => __( 'Free scores the page. Pro writes drafts from the endpoint you paste — OpenRouter, Gemini, or whatever you already pay for. Keys can lock in wp-config.php.', 'spokora' ),
			'items' => array(
				__( 'API Vault', 'spokora' ),
				__( 'Title, meta, and AI-doc drafts', 'spokora' ),
				__( 'Vision alt text in Media Lab', 'spokora' ),
			),
		),
		array(
			'title' => __( 'The rest of a client week', 'spokora' ),
			'body'  => __( 'Search Console, ranks, media, social, and a lead inbox live next to the SEO you already have. Same plugin, not a second install.', 'spokora' ),
			'items' => array(
				__( 'Search Performance (your GSC)', 'spokora' ),
				__( 'Rank tracker, X-Ray, backlinks', 'spokora' ),
				__( 'Social Studio and lead router', 'spokora' ),
			),
		),
		array(
			'title' => __( 'Agency ops', 'spokora' ),
			'body'  => __( 'Programmatic pages, MCP extras, and the telemetry screens we kept out of Free so this install stays a clean SEO plugin.', 'spokora' ),
			'items' => array(
				__( 'Deployment Matrix', 'spokora' ),
				__( 'Site Pulse, visits, tracking', 'spokora' ),
				__( 'MCP / Agent Ready extras', 'spokora' ),
			),
		),
	);
}

/**
 * Locked rows on Modules. Not a second plugin.
 *
 * @return array<string, array{label: string, summary: string}>
 */
function spokora_pro_locked_modules() {
	return array(
		'api_vault'           => array(
			'label'   => __( 'API Vault', 'spokora' ),
			'summary' => __( 'Paste keys once. Optional wp-config.php lock. Free never asks for this.', 'spokora' ),
		),
		'ai'                  => array(
			'label'   => __( 'AI content', 'spokora' ),
			'summary' => __( 'Model drafts for titles, descriptions, and /ai-docs markdown.', 'spokora' ),
		),
		'search_performance'  => array(
			'label'   => __( 'Search Performance', 'spokora' ),
			'summary' => __( 'Google Search Console in wp-admin, using your OAuth.', 'spokora' ),
		),
		'rank_tracker'        => array(
			'label'   => __( 'Rank tracker', 'spokora' ),
			'summary' => __( 'Keyword positions on their DataForSEO bill, not ours.', 'spokora' ),
		),
		'media_lab'           => array(
			'label'   => __( 'Media Lab', 'spokora' ),
			'summary' => __( 'Vision alt text and WebP as a week deliverable.', 'spokora' ),
		),
		'social'              => array(
			'label'   => __( 'Social Studio', 'spokora' ),
			'summary' => __( 'Webhook posts you choose. Not silent auto-spam.', 'spokora' ),
		),
		'lead_router'         => array(
			'label'   => __( 'Lead inbox', 'spokora' ),
			'summary' => __( 'Form leads into the week, not a second CRM login.', 'spokora' ),
		),
		'live_dashboard'      => array(
			'label'   => __( 'Live Dashboard', 'spokora' ),
			'summary' => __( 'Telemetry when keys exist. Free Home stays an SEO map on purpose.', 'spokora' ),
		),
	);
}

/**
 * Primary CTA markup.
 *
 * @param bool $include_internal Link to the in-plugin Go Pro page.
 */
function spokora_pro_cta_html( $include_internal = false ) {
	unset( $include_internal );
	return '<a class="button button-primary" href="' . esc_url( spokora_pro_url() ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'See Spokora Pro', 'spokora' ) . '</a>';
}

/**
 * @param string $variant card|compact|keys
 * @param string $context Optional hook id for copy.
 */
function spokora_render_pro_teaser( $variant = 'compact', $context = '' ) {
	unset( $context );
	$variant = in_array( $variant, array( 'card', 'compact', 'keys' ), true ) ? $variant : 'compact';

	if ( 'keys' === $variant ) {
		echo '<div class="spokora-pro-teaser spokora-pro-teaser--keys">';
		echo '<p><span class="spokora-pro-badge">' . esc_html__( 'Pro', 'spokora' ) . '</span> ';
		echo esc_html__( 'Scores and /llms.txt run here. Model drafts need Spokora Pro and a key you already pay for.', 'spokora' );
		echo '</p><p class="spokora-pro-teaser__actions">' . wp_kses_post( spokora_pro_cta_html() ) . '</p>';
		echo '</div>';
		return;
	}

	if ( 'compact' === $variant ) {
		echo '<div class="spokora-pro-teaser spokora-pro-teaser--compact">';
		echo '<p><span class="spokora-pro-badge">' . esc_html__( 'Pro', 'spokora' ) . '</span> ';
		echo esc_html__( 'Free is the SEO plugin. Pro is the rest of a client week: keys, Search Console, media, leads.', 'spokora' );
		echo '</p><p class="spokora-pro-teaser__actions">' . wp_kses_post( spokora_pro_cta_html() ) . '</p>';
		echo '</div>';
		return;
	}

	echo '<aside class="spokora-pro-teaser spokora-pro-teaser--card" aria-labelledby="spokora-pro-teaser-title">';
	echo '<p class="spokora-pro-teaser__kicker"><span class="spokora-pro-badge">' . esc_html__( 'Pro', 'spokora' ) . '</span></p>';
	echo '<h2 id="spokora-pro-teaser-title">' . esc_html__( 'Need the rest of the week?', 'spokora' ) . '</h2>';
	echo '<p>' . esc_html__( 'Titles, schema, sitemap, and redirects stay free. Upgrade when you want your own models and the agency screens we kept out of this install.', 'spokora' ) . '</p>';
	echo '<ul class="spokora-pro-teaser__list">';
	foreach ( array(
		__( 'BYOK vault — we do not resell tokens', 'spokora' ),
		__( 'Search Console and rank tools', 'spokora' ),
		__( 'Media Lab, social, lead inbox', 'spokora' ),
	) as $item ) {
		echo '<li>' . esc_html( $item ) . '</li>';
	}
	echo '</ul>';
	echo '<p class="spokora-pro-teaser__actions">' . wp_kses_post( spokora_pro_cta_html() ) . '</p>';
	echo '</aside>';
}

/**
 * Compact hint used by copied Pro screens (settings, LLMS, editor).
 */
function spokora_maybe_render_gemini_vault_hint() {
	spokora_render_pro_teaser( 'keys' );
}

/**
 * Plugins-list Pro link. No left-menu tab.
 */
class Spokora_Go_Pro {

	public function __construct() {
		if ( defined( 'SPOKORA_PLUGIN_FILE' ) ) {
			add_filter( 'plugin_action_links_' . plugin_basename( SPOKORA_PLUGIN_FILE ), array( $this, 'plugin_action_links' ) );
		}
	}

	/**
	 * @param array<int, string> $links Links.
	 * @return array<int, string>
	 */
	public function plugin_action_links( $links ) {
		if ( ! is_array( $links ) ) {
			$links = array();
		}
		$links[] = '<a href="' . esc_url( spokora_pro_url() ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Spokora Pro', 'spokora' ) . '</a>';
		return $links;
	}
}
