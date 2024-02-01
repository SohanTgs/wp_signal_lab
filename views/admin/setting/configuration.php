<?php viser_layout('admin/layouts/master'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="<?php echo viser_route_link('admin.setting.system.configuration.store') ?>" method="post">
                <?php viser_nonce_field('admin.setting.system.configuration.store') ?>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0"><?php esc_html_e('Agree Policy', VISERLAB_PLUGIN_NAME); ?></p>
                                <p class="mb-0">
                                    <small><?php esc_html_e('If you enable this module, that means a user must have to agree with your system\'s policies during registration.', VISERLAB_PLUGIN_NAME); ?></small>
                                </p>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="<?php esc_attr_e('Enable', VISERLAB_PLUGIN_NAME); ?>" data-off="<?php esc_attr_e('Disable', VISERLAB_PLUGIN_NAME); ?>" name="viser_agree" <?php if (get_option('viser_agree')) echo 'checked'; ?>>
                            </div>
                        </li>

                        <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0"><?php esc_html_e('Email Notification', VISERLAB_PLUGIN_NAME); ?></p>
                                <p class="mb-0">
                                    <small><?php esc_html_e('If you enable this module, the system will send emails to users where needed. Otherwise, no email will be sent.', VISERLAB_PLUGIN_NAME); ?> <code><?php esc_html_e('So be sure before disabling this module that, the system doesn\'t need to send any emails.', VISERLAB_PLUGIN_NAME); ?></code></small>
                                </p>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="<?php esc_attr_e('Enable', VISERLAB_PLUGIN_NAME); ?>" data-off="<?php esc_attr_e('Disable', VISERLAB_PLUGIN_NAME); ?>" name="viser_email_notification" <?php if (get_option('viser_email_notification')) echo 'checked'; ?>>
                            </div>
                        </li>

                        <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-2 justify-content-between align-items-center">
                            <div>
                                <p class="fw-bold mb-0"><?php esc_html_e('SMS Notification', VISERLAB_PLUGIN_NAME); ?></p>
                                <p class="mb-0">
                                    <small><?php esc_html_e('If you enable this module, the system will send SMS to users where needed. Otherwise, no SMS will be sent.', VISERLAB_PLUGIN_NAME); ?> <code><?php esc_html_e('So be sure before disabling this module that, the system doesn\'t need to send any SMS.', VISERLAB_PLUGIN_NAME); ?></code></small>
                                </p>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="<?php esc_attr_e('Enable', VISERLAB_PLUGIN_NAME); ?>" data-off="<?php esc_attr_e('Disable', VISERLAB_PLUGIN_NAME); ?>" name="viser_sms_notification" <?php if (get_option('viser_sms_notification')) echo 'checked'; ?>>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>