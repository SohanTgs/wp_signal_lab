<?php viser_layout('user/layouts/master'); ?>

<section class="pt-120 pb-100 bg-light">
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10">
                <div class="custom--card">
                    <div class="card-header">
                        <h5 class="card-title text-center"><?php echo esc_html($pageTitle); ?></h5>
                    </div>
                    <div class="card-body">
                        <form class="transparent-form" action="<?php echo viser_route_link('user.ticket.store'); ?>"  method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                            <?php viser_nonce_field('user.ticket.store'); ?>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label"><?php esc_html_e('Name', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input type="text" name="name" value="<?php echo esc_attr($user->display_name); ?>" class="form--control form-control" required readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label"><?php esc_html_e('Email Address', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input type="email" name="email" value="<?php echo esc_attr($user->user_email); ?>" class="form--control form-control" required readonly>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label"><?php esc_html_e('Subject', VISERLAB_PLUGIN_NAME); ?></label>
                                    <input type="text" name="subject" value="<?php echo esc_attr(viser_old('subject')); ?>" class="form--control form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label"><?php esc_html_e('Priority', VISERLAB_PLUGIN_NAME); ?></label>
                                    <select name="priority" class="form--control form-control form-select" required>
                                        <option value="3"><?php esc_html_e('High', VISERLAB_PLUGIN_NAME); ?></option>
                                        <option value="2"><?php esc_html_e('Medium', VISERLAB_PLUGIN_NAME); ?></option>
                                        <option value="1"><?php esc_html_e('Low', VISERLAB_PLUGIN_NAME); ?></option>
                                    </select>
                                </div>
                                <div class="col-12 form-group">
                                    <label class="form-label"><?php esc_html_e('Message', VISERLAB_PLUGIN_NAME); ?></label>
                                    <textarea name="message" id="inputMessage" rows="6" class="form--control form-control" required><?php echo viser_old('message'); ?></textarea>
                                </div>
                            </div>

                            <div class="row form-group mb-3">
                                <div class="file-upload">
                                    <label class="form-label">
                                        <?php esc_html_e('Attachments', VISERLAB_PLUGIN_NAME); ?>
                                    </label> 
                                    <small class="text-danger">
                                        <?php esc_html_e('Max 5 files can be uploaded', VISERLAB_PLUGIN_NAME); ?>. <?php esc_html_e('Maximum upload size is', VISERLAB_PLUGIN_NAME); ?> <?php echo ini_get('upload_max_filesize'); ?>
                                    </small>

                                    <div class="input-group">
                                        <input type="file" name="attachments[]" id="inputAttachments" class="form-control form--control rounded"/>
                                        <button class="btn--success btn--sm btn addFile ms-2 rounded" type="button"><i class="las la-plus"></i></button>
                                    </div>
                                    
                                    <div id="fileUploadsContainer"></div>
                                    <label class="form-lebel small">
                                        <?php esc_html_e('Allowed File Extensions', VISERLAB_PLUGIN_NAME); ?>: .<?php esc_html_e('jpg', VISERLAB_PLUGIN_NAME); ?>, .<?php esc_html_e('jpeg', VISERLAB_PLUGIN_NAME); ?>, .<?php esc_html_e('png', VISERLAB_PLUGIN_NAME); ?>, .<?php esc_html_e('pdf', VISERLAB_PLUGIN_NAME); ?>, .<?php esc_html_e('doc', VISERLAB_PLUGIN_NAME); ?>, .<?php esc_html_e('docx', VISERLAB_PLUGIN_NAME); ?>
                                    </label>

                                </div>
                            </div>

                            <div class="row form-group justify-content-center">
                                <div class="col-md-12">
                                    <button class="btn btn--base w-100 text-center" type="submit" id="recaptcha">
                                        <?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    jQuery(document).ready(function($) {
        "use strict";
        var fileAdded = 0;
        $('.addFile').on('click', function() {
            if (fileAdded >= 4) {
                alert('You\'ve added maximum number of file');
                return false;
            }
            fileAdded++;
            $("#fileUploadsContainer").append(`
                <div class="input-group my-3">
                    <input type="file" name="attachments[]" class="form-control form--control rounded" required />
                    <button type="button" class="btn--danger btn--sm btn remove-btn ms-2 rounded"><i class="las la-times"></i></button>
                </div>
            `)
        });
        $(document).on('click', '.remove-btn', function() {
            fileAdded--;
            $(this).closest('.input-group').remove();
        });
    });
</script>