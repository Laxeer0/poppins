<?php
/**
 * Payment methods.
 *
 * @var WC_Payment_Token[] $saved_methods
 * @var int $has_methods
 * @var string $current_page
 */
defined('ABSPATH') || exit;

$saved_methods = isset($saved_methods) && is_array($saved_methods) ? $saved_methods : [];
$has_methods   = !empty($saved_methods);
?>

<div class="space-y-6">
	<div class="flex flex-wrap items-end justify-between gap-4">
		<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Payment methods', 'woocommerce'); ?></h2>
		<a class="inline-flex items-center justify-center rounded-full bg-[#003745] px-5 py-3 text-xs font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md" href="<?php echo esc_url(wc_get_account_endpoint_url('add-payment-method')); ?>">
			<?php esc_html_e('Add payment method', 'woocommerce'); ?>
		</a>
	</div>

	<?php if ($has_methods) : ?>
		<div class="space-y-3">
			<?php foreach ($saved_methods as $token) :
				if (!$token instanceof WC_Payment_Token) {
					continue;
				}
				?>
				<div class="rounded-[16px] border border-[#003745]/10 bg-white p-5 shadow-sm">
					<div class="flex flex-wrap items-start justify-between gap-4">
						<div class="text-sm text-[#003745]">
							<p class="font-semibold"><?php echo esc_html($token->get_display_name()); ?></p>
							<?php if (method_exists($token, 'get_expiry_month') && method_exists($token, 'get_expiry_year') && $token->get_expiry_month() && $token->get_expiry_year()) : ?>
								<p class="mt-1 text-xs uppercase tracking-[0.18em] text-[#1F525E]">
									<?php
									printf(
										/* translators: 1: month, 2: year */
										esc_html__('Expires %1$s/%2$s', 'woocommerce'),
										esc_html(str_pad((string) $token->get_expiry_month(), 2, '0', STR_PAD_LEFT)),
										esc_html((string) $token->get_expiry_year())
									);
									?>
								</p>
							<?php endif; ?>
						</div>

						<div class="flex flex-wrap gap-2">
							<?php foreach (wc_get_account_payment_methods_actions($token) as $key => $action) : ?>
								<a class="inline-flex items-center justify-center rounded-full border border-[#003745]/15 bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#003745] transition hover:-translate-y-px hover:shadow-sm" href="<?php echo esc_url($action['url']); ?>">
									<?php echo esc_html($action['name']); ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else : ?>
		<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 text-sm text-[#1F525E] shadow-sm">
			<p><?php esc_html_e('No saved methods found.', 'woocommerce'); ?></p>
		</div>
	<?php endif; ?>
</div>


