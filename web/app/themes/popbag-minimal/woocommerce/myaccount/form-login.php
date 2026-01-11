<?php
/**
 * My Account login/register form.
 */
defined('ABSPATH') || exit;

do_action('woocommerce_before_customer_login_form');
?>

<?php $can_register = 'yes' === get_option('woocommerce_enable_myaccount_registration'); ?>

<div class="grid gap-8 <?php echo $can_register ? 'md:grid-cols-2' : ''; ?>" id="customer_login">
	<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
		<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Login', 'woocommerce'); ?></h2>

		<form class="mt-6 space-y-4 woocommerce-form woocommerce-form-login login" method="post" novalidate>
			<?php do_action('woocommerce_login_form_start'); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label class="block text-sm font-semibold text-[#003745]" for="username">
					<?php esc_html_e('Username or email address', 'woocommerce'); ?>
					<span class="required" aria-hidden="true">*</span>
					<span class="sr-only"><?php esc_html_e('Required', 'woocommerce'); ?></span>
				</label>
				<input
					type="text"
					class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20 woocommerce-Input woocommerce-Input--text input-text"
					name="username"
					id="username"
					autocomplete="username"
					value="<?php echo (!empty($_POST['username']) && is_string($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing ?>"
					required
					aria-required="true"
				/>
			</p>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label class="block text-sm font-semibold text-[#003745]" for="password">
					<?php esc_html_e('Password', 'woocommerce'); ?>
					<span class="required" aria-hidden="true">*</span>
					<span class="sr-only"><?php esc_html_e('Required', 'woocommerce'); ?></span>
				</label>
				<input
					type="password"
					class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20 woocommerce-Input woocommerce-Input--text input-text"
					name="password"
					id="password"
					autocomplete="current-password"
					required
					aria-required="true"
				/>
			</p>

			<?php do_action('woocommerce_login_form'); ?>

			<div class="flex flex-wrap items-center justify-between gap-4 pt-2">
				<label class="flex items-center gap-2 text-sm text-[#1F525E] woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="h-4 w-4 rounded border-[#003745]/30 text-[#FF2030] focus:ring-[#FF2030]/20 woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
					<span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
				</label>

				<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
				<button type="submit" class="rounded-full bg-[#FF2030] px-5 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>">
					<?php esc_html_e('Log in', 'woocommerce'); ?>
				</button>
			</div>

			<p class="woocommerce-LostPassword lost_password pt-2 text-sm">
				<a class="font-semibold text-[#003745] underline decoration-[#FF2030] decoration-2 underline-offset-4" href="<?php echo esc_url(wp_lostpassword_url()); ?>">
					<?php esc_html_e('Lost your password?', 'woocommerce'); ?>
				</a>
			</p>

			<?php do_action('woocommerce_login_form_end'); ?>
		</form>
	</div>

	<?php if ($can_register) : ?>
		<div class="rounded-[16px] border border-[#003745]/10 bg-white p-6 shadow-sm">
			<h2 class="text-xl font-black text-[#003745]"><?php esc_html_e('Register', 'woocommerce'); ?></h2>

			<form method="post" class="mt-6 space-y-4 woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?> >
				<?php do_action('woocommerce_register_form_start'); ?>

				<?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label class="block text-sm font-semibold text-[#003745]" for="reg_username">
							<?php esc_html_e('Username', 'woocommerce'); ?>
							<span class="required" aria-hidden="true">*</span>
							<span class="sr-only"><?php esc_html_e('Required', 'woocommerce'); ?></span>
						</label>
						<input
							type="text"
							class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20 woocommerce-Input woocommerce-Input--text input-text"
							name="username"
							id="reg_username"
							autocomplete="username"
							value="<?php echo !empty($_POST['username']) ? esc_attr(wp_unslash($_POST['username'])) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing ?>"
							required
							aria-required="true"
						/>
					</p>
				<?php endif; ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label class="block text-sm font-semibold text-[#003745]" for="reg_email">
						<?php esc_html_e('Email address', 'woocommerce'); ?>
						<span class="required" aria-hidden="true">*</span>
						<span class="sr-only"><?php esc_html_e('Required', 'woocommerce'); ?></span>
					</label>
					<input
						type="email"
						class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20 woocommerce-Input woocommerce-Input--text input-text"
						name="email"
						id="reg_email"
						autocomplete="email"
						value="<?php echo !empty($_POST['email']) ? esc_attr(wp_unslash($_POST['email'])) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Missing ?>"
						required
						aria-required="true"
					/>
				</p>

				<?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label class="block text-sm font-semibold text-[#003745]" for="reg_password">
							<?php esc_html_e('Password', 'woocommerce'); ?>
							<span class="required" aria-hidden="true">*</span>
							<span class="sr-only"><?php esc_html_e('Required', 'woocommerce'); ?></span>
						</label>
						<input
							type="password"
							class="mt-1 w-full rounded-[14px] border border-[#003745]/15 bg-white px-4 py-3 text-[#003745] focus:border-[#003745]/40 focus:outline-none focus:ring-2 focus:ring-[#FF2030]/20 woocommerce-Input woocommerce-Input--text input-text"
							name="password"
							id="reg_password"
							autocomplete="new-password"
							required
							aria-required="true"
						/>
					</p>
				<?php else : ?>
					<p class="text-sm text-[#1F525E]"><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>
				<?php endif; ?>

				<?php do_action('woocommerce_register_form'); ?>

				<div class="pt-2">
					<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
					<button type="submit" class="w-full rounded-full bg-[#003745] px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition hover:-translate-y-px hover:shadow-md woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>">
						<?php esc_html_e('Register', 'woocommerce'); ?>
					</button>
				</div>

				<?php do_action('woocommerce_register_form_end'); ?>
			</form>
		</div>
	<?php endif; ?>
</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>


