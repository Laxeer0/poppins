<?php
/**
 * Breadcrumbs.
 */
defined('ABSPATH') || exit;

if (!empty($breadcrumb)) : ?>
	<nav class="woocommerce-breadcrumb mb-6 text-sm text-[#1F525E]" aria-label="<?php esc_attr_e('Breadcrumb', 'woocommerce'); ?>">
		<?php foreach ($breadcrumb as $key => $crumb) : ?>
			<?php if (!empty($crumb[1]) && count($breadcrumb) !== $key + 1) : ?>
				<a class="font-semibold text-[#003745] underline decoration-[#FF2030] decoration-2 underline-offset-4" href="<?php echo esc_url($crumb[1]); ?>">
					<?php echo esc_html($crumb[0]); ?>
				</a>
				<span class="mx-2" aria-hidden="true">/</span>
			<?php else : ?>
				<span class="font-semibold text-[#003745]"><?php echo esc_html($crumb[0]); ?></span>
			<?php endif; ?>
		<?php endforeach; ?>
	</nav>
<?php endif; ?>



