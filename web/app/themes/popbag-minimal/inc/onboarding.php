<?php
/**
 * Theme onboarding (safe defaults on first activation).
 *
 * - Creates a "Home" page (if missing) and sets it as front page
 * - Creates a "Blog" page (if missing) and sets it as posts page
 *
 * IMPORTANT: It does NOT override existing Reading settings if already configured.
 */
if (!defined('ABSPATH')) {
	exit;
}

add_action('after_switch_theme', static function (): void {
	// If front page is already configured, do nothing.
	$page_on_front = (int) get_option('page_on_front', 0);
	if ($page_on_front > 0) {
		return;
	}

	// Find or create Home page.
	$home = get_page_by_path('home');
	if (!$home) {
		$home = get_page_by_title('Home');
	}

	$home_id = $home instanceof WP_Post ? (int) $home->ID : 0;
	if ($home_id <= 0) {
		$home_id = (int) wp_insert_post([
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'Home',
			'post_name'    => 'home',
			// Use the registered pattern (Gutenberg) as starter content.
			'post_content' => '<!-- wp:pattern {"slug":"popbag/home-starter"} /-->',
		], true);
	}

	if ($home_id > 0) {
		update_option('show_on_front', 'page');
		update_option('page_on_front', $home_id);
	}

	// Optional: set a Blog page if not set.
	$page_for_posts = (int) get_option('page_for_posts', 0);
	if ($page_for_posts > 0) {
		return;
	}

	$blog = get_page_by_path('blog');
	if (!$blog) {
		$blog = get_page_by_title('Blog');
	}

	$blog_id = $blog instanceof WP_Post ? (int) $blog->ID : 0;
	if ($blog_id <= 0) {
		$blog_id = (int) wp_insert_post([
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => 'Blog',
			'post_name'   => 'blog',
		], true);
	}

	if ($blog_id > 0) {
		update_option('page_for_posts', $blog_id);
	}
});



