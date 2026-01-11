<?php
defined('ABSPATH') || exit;

if (!$notices) {
	return;
}
?>

<?php foreach ($notices as $notice) : ?>
	<div class="mb-4 rounded-[16px] border border-[#003745]/10 bg-white p-4 text-sm text-[#003745] shadow-sm" role="status">
		<div class="flex items-start gap-3">
			<span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#003745] text-white" aria-hidden="true">✓</span>
			<div class="min-w-0">
				<?php echo wc_kses_notice($notice['notice']); ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>



