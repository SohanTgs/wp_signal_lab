<?php viser_layout('admin/layouts/master'); ?>
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <form action="<?php echo viser_route_link('admin.setting.store'); ?>" method="POST">
                <?php viser_nonce_field('admin.setting.store') ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="viser_cur_text"><?php esc_html_e('Currency', VISERLAB_PLUGIN_NAME); ?></label>
                                <input class="form-control" type="text" name="viser_cur_text" value="<?php echo get_option('viser_cur_text'); ?>" id="viser_cur_text">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="viser_cur_sym"><?php esc_html_e('Currency Symbol', VISERLAB_PLUGIN_NAME); ?></label>
                                <input class="form-control" type="text" name="viser_cur_sym" value="<?php echo get_option('viser_cur_sym'); ?>" id="viser_cur_sym">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="viser_user_panel_prefix"><?php esc_html_e('User Panel URL Prefix', VISERLAB_PLUGIN_NAME); ?></label>
                                <input class="form-control" type="text" name="viser_user_panel_prefix" value="<?php echo get_option('viser_user_panel_prefix'); ?>" id="viser_user_panel_prefix">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary h-45 w-100"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>