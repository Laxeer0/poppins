<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
    <div class="mx-auto max-w-6xl px-4 py-10">
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-[20px] border-4 border-[#003745] bg-white p-6 shadow-[10px_10px_0_#003745]">
                    <h3 class="mb-4 text-2xl font-black text-[#003745]"><?php esc_html_e('Billing details', 'woocommerce'); ?></h3>
                    <?php if ($checkout->get_checkout_fields()) : ?>
                        <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                        <div id="customer_details" class="grid gap-6 md:grid-cols-2">
                            <div class="space-y-4">
                                <?php do_action('woocommerce_checkout_billing'); ?>
                            </div>
                            <div class="space-y-4">
                                <?php do_action('woocommerce_checkout_shipping'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="rounded-[20px] border-4 border-[#003745] bg-[#F9E2B0] p-6 shadow-[10px_10px_0_#003745]">
                    <h3 class="mb-4 text-2xl font-black text-[#003745]"><?php esc_html_e('Additional info', 'woocommerce'); ?></h3>
                    <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                </div>
            </div>

            <div class="space-y-4">
                <div class="rounded-[20px] border-4 border-[#003745] bg-white p-6 shadow-[10px_10px_0_#003745]">
                    <?php do_action('woocommerce_checkout_before_order_review'); ?>
                    <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
                    <h3 id="order_review_heading" class="mb-4 text-2xl font-black text-[#003745]"><?php esc_html_e('Your order', 'woocommerce'); ?></h3>
                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action('woocommerce_checkout_order_review'); ?>
                    </div>
                    <?php do_action('woocommerce_checkout_after_order_review'); ?>
                </div>
            </div>
        </div>
    </div>
</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>

