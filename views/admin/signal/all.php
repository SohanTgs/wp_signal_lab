<?php viser_layout('admin/layouts/master'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--lg">
                    <table class="table table--light style--two">
                        <thead>
                        <tr>
                            <th><?php esc_html_e('Name', VISERLAB_PLUGIN_NAME); ?></th>
                            <th><?php esc_html_e('Send Time', VISERLAB_PLUGIN_NAME); ?></th>
                            <th><?php esc_html_e('Send Status', VISERLAB_PLUGIN_NAME); ?></th>
                            <th><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?></th>
                            <th><?php esc_html_e('Action', VISERLAB_PLUGIN_NAME); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($signals->data as $signal) { ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold"><?php echo esc_html(viser_str_limit($signal->name, 50)); ?></span>
                                    </td>

                                    <td>
                                        <?php if (!$signal->send_signal_at) { ?>
                                            <?php esc_html_e('N/A', VISERLAB_PLUGIN_NAME); ?>
                                        <?php }else { ?>
                                            <?php echo viser_show_date_time($signal->send_signal_at); ?> 
                                            <br> 
                                            <?php echo viser_diff_for_humans($signal->send_signal_at); ?>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php 
                                            $html = ''; 
                                            if($signal->send == 1){
                                                $html = "<span class='text--small badge font-weight-normal badge--success'>".__('Send', VISERLAB_PLUGIN_NAME)."</span>";
                                            }else{
                                                $html  = "<span class='text--small badge font-weight-normal badge--warning'>".__('Not Send', VISERLAB_PLUGIN_NAME)."</span>";
                                            }
                                            echo wp_kses($html, viser_allowed_html());
                                        ?>
                                    </td>

                                    <td>
                                        <?php 
                                            $html = ''; 
                                            if($signal->status == 1){
                                                $html = "<span class='text--small badge font-weight-normal badge--success'>".__('Enabled', VISERLAB_PLUGIN_NAME)."</span>";
                                            }else{
                                                $html  = "<span class='text--small badge font-weight-normal badge--warning'>".__('Disabled', VISERLAB_PLUGIN_NAME)."</span>";
                                            }
                                            echo wp_kses($html, viser_allowed_html());
                                        ?>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-end flex-wrap gap-2">
                                            <a href="<?php echo viser_route_link('admin.signal.edit'); ?>&amp;id=<?php echo intval($signal->id); ?>" 
                                                class="btn btn-sm btn-outline--primary">
                                                <i class="la la-pencil"></i> <?php esc_html_e('Edit', VISERLAB_PLUGIN_NAME); ?>
                                            </a>
                                            <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn" 
                                                data-question="<?php esc_attr_e('Are you sure to delete this signal?', VISERLAB_PLUGIN_NAME); ?>" 
                                                data-action="<?php echo viser_route_link('admin.signal.delete'); ?>&amp;id=<?php echo intval($signal->id); ?>" 
                                                data-nonce="<?php echo esc_attr(viser_nonce('admin.signal.delete')) ?>"
                                            >
                                                <i class="la la-trash"></i> <?php esc_html_e('Delete', VISERLAB_PLUGIN_NAME); ?>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php if (viser_check_empty($signals->data)) { ?>
                                <tr> 
                                    <td class="text-muted text-center" colspan="100%"><?php esc_html_e('Data Not Found', VISERLAB_PLUGIN_NAME); ?></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            <?php if ($signals->links) { ?>
                <div class="card-footer">
                    <?php echo wp_kses($signals->links, viser_allowed_html()); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php viser_include('partials/confirmation'); ?>

<?php if( viser_current_route() != 'signal_all' ){ ?>
    <?php
    $html = '
        <a class="btn btn-sm btn-outline--primary" href="'.viser_route_link('admin.signal.add.page').'">
            <i class="las la-plus"></i>' . __("Add New", VISERLAB_PLUGIN_NAME) . 
        '</a>';
    viser_push_breadcrumb($html);
    ?>
<?php } ?>