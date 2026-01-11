<?php
defined('ABSPATH') || exit;

if (!$notices) {
	return;
}
?>

<?php foreach ($notices as $notice) : ?>
	<div class="mb-4 rounded-[16px] border border-[#FF2030]/20 bg-white p-4 text-sm text-[#003745] shadow-sm" role="alert">
		<div class="flex items-start gap-3">
			<span class="mt-0.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-[#FF2030] text-white" aria-hidden="true">!</span>
			<div class="min-w-0">
				<?php echo wc_kses_notice($notice['notice']); ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>



