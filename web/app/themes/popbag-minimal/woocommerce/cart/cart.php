<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');
?>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
	<div class="overflow-hidden rounded-[16px] border border-[#003745]/10 bg-white shadow-sm">
		<table class="w-full border-collapse text-sm">
			<thead class="bg-[#003745]/5 text-left uppercase tracking-[0.12em] text-[#1F525E]">
				<tr>
					<th class="px-4 py-3 font-semibold"><?php esc_html_e('Product', 'woocommerce'); ?></th>
					<th class="px-4 py-3 font-semibold"><?php esc_html_e('Price', 'woocommerce'); ?></th>
					<th class="px-4 py-3 font-semibold"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
					<th class="px-4 py-3 font-semibold"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
					$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
					$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

					if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :
						$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
						?>
						<tr class="border-t border-[#003745]/10">
							<td class="px-4 py-4">
								<div class="flex items-center gap-4">
									<div class="h-16 w-16 overflow-hidden rounded-[10px] border border-[#003745]/10 bg-[#003745]/5">
										<?php
										$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
										echo $product_permalink ? sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail) : $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										?>
									</div>
									<div>
										<?php
										echo $product_permalink ? sprintf('<a class="font-semibold text-[#003745]" href="%s">%s</a>', esc_url($product_permalink), wp_kses_post($_product->get_name())) : wp_kses_post($_product->get_name()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
										echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										?>
										<div class="mt-2">
											<?php
											echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
												'<a href="%s" class="text-xs uppercase tracking-[0.14em] text-[#FF2030]" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
												esc_url(wc_get_cart_remove_url($cart_item_key)),
												esc_attr__('Remove this item', 'woocommerce'),
												esc_attr($product_id),
												esc_attr($_product->get_sku()),
												esc_html__('Remove', 'woocommerce')
											), $cart_item_key);
											?>
										</div>
									</div>
								</div>
							</td>
							<td class="px-4 py-4 align-top text-[#1F525E]">
								<?php
								echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</td>
							<td class="px-4 py-4 align-top">
								<?php
								if ($_product->is_sold_individually()) {
									$product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', esc_attr($cart_item_key));
								} else {
									$product_quantity = woocommerce_quantity_input([
										'input_name'   => "cart[{$cart_item_key}][qty]",
										'input_value'  => $cart_item['quantity'],
										'max_value'    => $_product->get_max_purchase_quantity(),
										'min_value'    => '0',
										'product_name' => $_product->get_name(),
									], $_product, false);
								}

								echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</td>
							<td class="px-4 py-4 align-top text-right font-semibold text-[#003745]">
								<?php
								echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<div class="mt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
		<?php do_action('woocommerce_cart_actions'); ?>
		<button type="submit" class="rounded-full bg-[#FF2030] px-5 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">
			<?php esc_html_e('Update cart', 'woocommerce'); ?>
		</button>
		<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
	</div>
</form>

<div class="mt-8 space-y-4">
	<?php do_action('woocommerce_cart_collaterals'); ?>
</div>

<?php do_action('woocommerce_after_cart'); ?>

