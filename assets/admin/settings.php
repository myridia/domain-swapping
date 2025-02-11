<div class="wrap page-header">
    <img src="<?php echo esc_url(plugin_dir_url( __FILE__ ) . 'image/logo.jpg'); ?>" alt="logo">
    <h3><?php echo esc_html__('WPMultiHost', 'host-changer'); ?></h3>
</div>
<hr>
<?php settings_errors(); ?>
<form action="options.php" method="post">
    <?php
    settings_fields('wphc_setting_option');
    do_settings_sections('hostchanger-setting-panel');
    submit_button(esc_html__('Save Settings', 'host-changer'));
    ?>
</form>
