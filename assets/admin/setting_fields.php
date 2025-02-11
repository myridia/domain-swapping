<?php
$options1 = get_option('wphc_setting_option');
function wphc_add_admin_setting($options1, $type)
{
    ?>
    <tbody class="wphc_tbl_<?php echo esc_attr($type); ?>">
    <?php
    if (!empty($options1) && !empty($options1[$type]) && count($options1[$type]) > 0) {
        foreach ($options1[$type] as $i1 => $d1) {
            ?>
            <tr>
                <th scope="row">
                    <label>
                        <?php echo esc_html__('Allowed Host:', 'host-changer'); ?>
                    </label>
                </th>
                <td>
                    <input name="wphc_setting_option[<?php echo esc_html($type); ?>][]"
                           placeholder="<?php echo esc_html__('Example:wordpress.com', 'host-changer'); ?>"
                           type="textbox"
                           value="<?php echo $d1; ?>">
                    <?php if (count($options1[$type]) < 2) { ?>
                        <span class="btn btn-sm btn-danger wphc_btn_row_delete" style="display: none">
                            <span class="dashicons dashicons-no"></span>
                        </span>
                    <?php } else { ?>
                        <span class="btn btn-sm btn-danger wphc_btn_row_delete">
                            <span class="dashicons dashicons-no"></span>
                        </span>
                    <?php } ?>
                </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <th scope="row">
                <label for="wphc_<?php echo esc_attr($type); ?>">
                    <?php echo esc_html__('Allowed Host:', 'host-changer'); ?>
                </label>
            </th>
            <td>
                <input id="wphc_<?php echo esc_attr($type); ?>"
                       name="wphc_setting_option[<?php echo esc_html($type); ?>][]"
                       placeholder="<?php echo esc_html__('Example:wordpress.com', 'host-changer'); ?>"
                       type="textbox"
                       value="">
                <span class="btn btn-sm btn-danger wphc_btn_row_delete" style="display: none">
                    <span class="dashicons dashicons-no"></span>
                </span>
            </td>
        </tr>
        <?php
    } ?>
    <tr>
        <th scope="row">
            <label>
            </label>
        </th>
        <td>
            <button type="button" class="button button-primary wphc_<?php echo esc_attr($type); ?>_btn_new_row mt-2">
                <?php echo esc_html__('Add New Host', 'host-changer'); ?>
            </button>
        </td>
    </tr>
    </tbody>

<?php }

wphc_add_admin_setting($options1, 'include');
