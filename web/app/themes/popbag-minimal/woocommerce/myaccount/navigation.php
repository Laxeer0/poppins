<?php
defined('ABSPATH') || exit;
?>

<ul class="space-y-2 text-sm font-semibold uppercase tracking-[0.12em] text-[#003745]">
	<?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
		<?php
		$classes = wc_get_account_menu_item_classes($endpoint);
		$is_active = is_string($classes) && str_contains($classes, 'is-active');
		$link_class = 'block rounded-[14px] border px-3 py-2 transition';
		$link_class .= $is_active
			? ' border-[#003745]/20 bg-[#003745]/5'
			: ' border-transparent hover:border-[#003745]/10 hover:bg-[#003745]/5';
		?>
		<li class="<?php echo esc_attr($classes); ?>">
			<a class="<?php echo esc_attr($link_class); ?>" href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>">
				<?php echo esc_html($label); ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>


