<?php viser_layout('admin/layouts/master'); ?>
<div class="card p-0">
    <div class="card-body p-0">
        <div class="table-responsive--sm table-responsive">
            <table class="table table--light style--two custom-data-table">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Name', VISERLAB_PLUGIN_NAME); ?></th>
                        <th><?php esc_html_e('Subject', VISERLAB_PLUGIN_NAME); ?></th>
                        <th><?php esc_html_e('Action', VISERLAB_PLUGIN_NAME); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($templates as $template) { ?>
                        <tr>
                            <td><?php echo esc_html($template->name); ?></td>
                            <td><?php echo esc_html($template->subj); ?></td>
                            <td>
                                <a href="<?php echo viser_route_link('admin.setting.notification.template.edit'); ?>&amp;id=<?php echo intval($template->id); ?>" class="btn btn-sm btn-outline--primary ms-1">
                                    <i class="la la-pencil"></i> <?php esc_html_e('Edit', VISERLAB_PLUGIN_NAME); ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (viser_check_empty($templates)) { ?>
                        <tr>
                            <td class="text-muted text-center" colspan="100%"><?php esc_html_e('Data not found', VISERLAB_PLUGIN_NAME); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table><!-- table end -->
        </div>
    </div>
</div><!-- card end -->