<?php
 **/




(new WPDSBase())->register();

$options1 = get_option('wpdssetting_option');
$site_url = (new WPDSFilterHook)->wpdsget_old_url();
$site_url = parse_url($site_url);
$site_url = $site_url['host'];

if (!empty($options1)) {
    array_push($options1['include'], $site_url);
} else {
    $options1['include'][] = $site_url;
}

if(!empty($options1['enableds']) && $options1['enableds'] === 'on' )
{
    $_SERVER['HTTP_HOST'] =	$_SERVER['SERVER_NAME'];

    if (!empty($options1['include']) && in_array($_SERVER['HTTP_HOST'], $options1['include'])) {
        (new WPDSFilterHook)->run();
    }
    else {
        ?>
        <div id="primary" class="content-area">
            <div id="content" class="site-content" role="main">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e('Host/Domain Not Found', 'domain-changer'); ?></h1>
                </header>
                <div class="page-wrapper">
                    <div class="page-content">
                        <h2><?php esc_html_e('Please contact the administrator to allow your host/domain.', 'host-changer'); ?></h2>
                        <p><?php esc_html_e('Your Host/Domain: '.$_SERVER['HTTP_HOST'],'domain-swapping'); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
         exit();
    }

}

