<div class="wrap">
<h2>WP Dropbox Music Settings</h2>
<form action="options.php" method="POST">
<?php settings_fields('dropbox-music-settings'); ?>
<?php do_settings_sections('dropbox-music-settings'); ?>
<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
</form>
</div>