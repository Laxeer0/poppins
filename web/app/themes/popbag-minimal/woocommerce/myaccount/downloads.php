<?php
/**
 * My Account downloads.
 *
 * @var array $downloads
 * @var bool  $has_downloads
 */
defined('ABSPATH') || exit;

$has_downloads = isset($has_downloads) ? (bool) $has_downloads : false;
?>

<div class="space-y-6">
	<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Downloads', 'woocommerce'); ?></h2>

	<?php if ($has_downloads && !empty($downloads) && is_array($downloads)) : ?>
		<div class="space-y-3">
			<?php foreach ($downloads as $download) : ?>
				<div class="rounded-[16px] border border-[#003745]/10 bg-white p-5 shadow-sm">
					<p class="text-sm font-semibold text-[#003745]">
						<?php echo esc_html($download['product_name'] ?? ''); ?>
					</p>
					<p class="mt-1 text-sm text-[#1F525E]">
						<?php echo esc_html($download['download_name'] ?? ''); ?>
					</p>
					<div class="mt-4 flex flex-wrap items-center justify-between gap-3">
						<?php if (!empty($download['access_expires'])) : ?>
							<p class="text-xs uppercase tracking-[0.18em] text-[#1F525E]">
								<?php
								printf(
									/* translators: %s: date */
									esc_html__('Expires %s', 'woocommerce'),
									esc_html(date_i18n(get_option('date_format'), strtotime((string) $download['access_expires'])))
								);
								?>
							</p>
						<?php endif; ?>

						<?php if (!empty($download['download_url'])) : ?>
							<a class="inline-flex items-center justify-center rounded-full bg-[#003745] px-5 py-3 text-xs font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md" href="<?php echo esc_url($download['download_url']); ?>">
								<?php esc_html_e('Download', 'woocommerce'); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else : ?>
		<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 text-sm text-[#1F525E] shadow-sm">
			<p><?php esc_html_e('No downloads available yet.', 'woocommerce'); ?></p>
		</div>
	<?php endif; ?>
</div>



