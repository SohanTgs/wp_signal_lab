<?php viser_layout('admin/layouts/master'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card overflow-hidden p-0">
            <div class="card-body p-0">
                <div class="table-responsive table-responsive--sm">
                    <table class="table align-items-center table--light">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Short Code', VISERLAB_PLUGIN_NAME); ?></th>
                                <th><?php esc_html_e('Description', VISERLAB_PLUGIN_NAME); ?></th>
                            </tr>
                        </thead>
                        <?php
                        $shortcodes = json_decode($template->shortcodes);
                        ?>
                        <tbody class="list">
                            <?php foreach ($shortcodes as $shortcode => $key) { ?>
                                <tr>
                                    <th><span class="short-codes">{{<?php echo esc_html($shortcode); ?>}}</span></th>
                                    <td><?php echo esc_html($key); ?></td>
                                </tr>
                            <?php } ?>
                            <?php if (viser_check_empty($shortcodes)) { ?>
                                <tr>
                                    <td colspan="100%" class="text-muted text-center"><?php esc_html_e('Data not found', VISERLAB_PLUGIN_NAME); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- card end -->

        <h6 class="mt-4 mb-2"><?php esc_html_e('Global Short Codes', VISERLAB_PLUGIN_NAME); ?></h6>
        <div class="card overflow-hidden p-0">
            <div class="card-body p-0">
                <div class="table-responsive table-responsive--sm">
                    <table class=" table align-items-center table--light">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Short Code', VISERLAB_PLUGIN_NAME); ?></th>
                                <th><?php esc_html_e('Description', VISERLAB_PLUGIN_NAME); ?></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <?php foreach (viser_global_notify_short_codes() as $shortCode => $codeDetails) { ?>
                                <tr>
                                    <td><span class="short-codes">{{<?php echo esc_html($shortCode); ?>}}</span></td>
                                    <td><?php echo esc_html($codeDetails); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="<?php echo viser_route_link('admin.setting.notification.template.update'); ?>&amp;id=<?php echo intval($template->id); ?>" method="post">
    <?php viser_nonce_field('admin.setting.notification.template.update'); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card mt-4 p-0">
                <div class="card-header bg--primary">
                    <h5 class="card-title text-white"><?php esc_html_e('Email Template', VISERLAB_PLUGIN_NAME); ?></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label><?php esc_html_e('Subject', VISERLAB_PLUGIN_NAME); ?></label>
                                <input type="text" class="form-control form-control-lg" placeholder="<?php echo esc_attr(__('Email subject', VISERLAB_PLUGIN_NAME)); ?>" name="subject" value="<?php echo esc_attr($template->subj); ?>" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?></label>
                                <input type="checkbox" data-height="46px" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="<?php esc_attr_e('Send Email', VISERLAB_PLUGIN_NAME); ?>" data-off="<?php esc_attr_e('Don\'t Send'); ?>" name="email_status" <?php if ($template->email_status == 1) {
                                                                                                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                                                                                                        } ?>>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php esc_html_e('Message', VISERLAB_PLUGIN_NAME); ?></label>
                                <textarea name="email_body" rows="10" class="form-control nicEdit" placeholder="<?php esc_attr_e('Your message using short-codes'); ?>"><?php echo balanceTags(wp_kses($template->email_body, viser_allowed_html())); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mt-4">
                <div class="card-header bg--primary">
                    <h5 class="card-title text-white"><?php esc_html_e('SMS Template', VISERLAB_PLUGIN_NAME); ?></h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?></label>
                                <input type="checkbox" data-height="46px" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="<?php esc_attr_e('Send SMS', VISERLAB_PLUGIN_NAME); ?>" data-off="<?php esc_attr_e('Don\'t Send'); ?>" name="sms_status" <?php if ($template->sms_status) echo 'checked'; ?>>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php esc_html_e('Message', VISERLAB_PLUGIN_NAME); ?></label>
                                <textarea name="sms_body" rows="10" class="form-control" placeholder="<?php esc_attr_e('Your message using short-codes', VISERLAB_PLUGIN_NAME); ?>" required><?php echo sanitize_textarea_field($template->sms_body); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if($template->act == 'SIGNAL_NOTIFICATION'){ ?>
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header bg--primary">
                        <h5 class="card-title text-white"><?php esc_html_e('Telegram Template', VISERLAB_PLUGIN_NAME); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input type="checkbox" data-height="46px" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="<?php esc_attr_e('Send Telegram', VISERLAB_PLUGIN_NAME); ?>" data-off="<?php esc_attr_e('Don\'t Send'); ?>" name="telegram_status" <?php if ($template->telegram_status) echo 'checked'; ?>>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?php esc_html_e('Message', VISERLAB_PLUGIN_NAME); ?></label>
                                    <textarea name="telegram_body" rows="10" class="form-control" placeholder="<?php esc_attr_e('Your message using short-codes', VISERLAB_PLUGIN_NAME); ?>" required><?php echo sanitize_textarea_field($template->telegram_body); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
    <button type="submit" class="btn btn--primary w-100 h-45 mt-4"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
</form>