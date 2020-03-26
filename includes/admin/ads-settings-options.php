<?php
/**
 */?>
<div class="wrap"> 
	<form action='options.php' method='post'>
        <?php  settings_fields( 'Googleadscookie' ); ?>
		<?php  do_settings_sections( 'Googleadscookie' ); ?>
		<?php  submit_button(); ?>
    </form>
</div> 