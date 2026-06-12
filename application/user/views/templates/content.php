<?php

	/* Additional Plugins */
	get_plugin(@$plugin);

	echo $_content;

?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		$('.kt-header__title').html('<?php echo $title; ?>');
	});
</script>