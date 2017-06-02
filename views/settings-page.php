<div class="wrap">

    <h2><?php _e( 'Admin Notice', 'admin-notice' ); ?></h2>

    <?php if ( $this->updated ) : ?>
        <div class="updated notice is-dismissible">
            <p><?php _e('Settings updated successfully!', 'td-admin-notice'); ?></p>
        </div>
    <?php endif; ?>

    <form method="post">

        <?php settings_fields( 'tdan_admin_notice_settings_group' ); ?>
        <?php do_settings_sections( 'tdan_admin_notice_settings_group' ); ?>

        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="agw_admin_notice_msg"><?php _e( 'Message', 'admin-notice' ); ?></label></th>
                <td>
                    <?php
                    $message = $this->getSettings('tdan_admin_notice_msg');
                    $editor_args = array(
                        'textarea_name' => 'tdan_admin_notice_msg',
                        'media_buttons' => false,
                        'textarea_rows' => 6,
                        'quicktags' => false,
                        'tinymce' => array(
                            'toolbar1' => 'bold,italic,underline,link,unlink,removeformat,undo,redo',
                            'toolbar2' => ''
                        )
                    );
                    wp_editor( $message, 'tdan_admin_notice_msg', $editor_args );
                    ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="agw_admin_notice_priority"><?php _e( 'Priority', 'admin-notice' ); ?></label></th>
                <td>
                    <?php $priority = $this->getSettings('tdan_admin_notice_priority'); ?>
                    <label><input type="radio" id="tdan_admin_notice_priority" name="tdan_admin_notice_priority" <?php echo ( $priority === 'high' ? 'checked="checked"' : '' ); ?> value="high"><?php _e( 'High', 'admin-notice' ); ?></label>
                    <label><input type="radio" id="tdan_admin_notice_priority" name="tdan_admin_notice_priority" <?php echo ( $priority === 'medium' ? 'checked="checked"' : '' ); ?> value="medium"><?php _e( 'Medium', 'admin-notice' ); ?></label>
                    <label><input type="radio" id="tdan_admin_notice_priority" name="tdan_admin_notice_priority" <?php echo ( $priority === 'low' ? 'checked="checked"' : '' ); ?> value="low"><?php _e( 'Low', 'admin-notice' ); ?></label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="agw_admin_notice_enable"><?php _e('', 'admin-notice'); ?>Enable/Disable</label></th>
                <td>
                    <?php $enabled = $this->getSettings('tdan_admin_notice_enable'); ?>
                    <label><input type="radio" id="tdan_admin_notice_enable" name="tdan_admin_notice_enable" <?php echo ( $enabled === 'true' ? 'checked="checked"' : '' ); ?> value="true" /><?php _e( 'Enable', 'admin-notice' ); ?></label>
                    <label><input type="radio" id="tdan_admin_notice_enable" name="tdan_admin_notice_enable" <?php echo ( $enabled === 'false' ? 'checked="checked"' : '' ); ?> value="false" /><?php _e( 'Disable', 'admin-notice' ); ?></label>
                </td>
            </tr>
        </table>

        <?php wp_nonce_field('td_admin_notice_nonce', 'td_admin_notice_nonce'); ?>
        <?php submit_button(); ?>

    </form>
</div>