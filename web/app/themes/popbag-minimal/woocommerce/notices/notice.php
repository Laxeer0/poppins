<?php
defined('ABSPATH') || exit;

if (!$notices) {
	return;
}
?>

<?php foreach ($notices as $notice) : ?>
	<div class="mb-4 rounded-[16px] border border-[#003745]/10 bg-white p-4 text-sm text-[#1F525E] shadow-sm" role="alert">
		<?php echo wc_kses_notice($notice['notice']); ?>
	</div>
<?php endforeach; ?>



