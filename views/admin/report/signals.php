<?php viser_layout('admin/layouts/master'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('Receiver', VISERLAB_PLUGIN_NAME); ?></th>
                                <th><?php esc_html_e('Name', VISERLAB_PLUGIN_NAME); ?></th>
                                <th><?php esc_html_e('Send Signal At', VISERLAB_PLUGIN_NAME); ?></th>
                                <th><?php esc_html_e('Details', VISERLAB_PLUGIN_NAME); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($signals->data as $log) {  
                            $user = get_userdata($log->user_id);    
                            $signal = viser_signal($log->signal_id);    
                        ?>
                            <tr>
                                <td>
                                    <span class="fw-bold"><?php echo esc_html($user->display_name); ?></span>
                                    <br />


                                    <a href="<?php echo viser_route_link('admin.users.detail');?>&amp;id=<?php echo intval($user->ID); ?>">
                                        @<?php echo esc_html($user->user_login); ?>
                                    </a>
                                </td>
                                <td>
                                    <?php echo esc_html(viser_str_limit($signal->name, 50)); ?>
                                </td>
                                <td> 
                                    <?php if($log->created_at){ ?>
                                        <?php echo viser_show_date_time($log->created_at); ?> <br />
                                        <?php echo viser_diff_for_humans($log->created_at); ?>
                                    <?php }else{ ?>
                                        <?php esc_html_e('N/A', VISERLAB_PLUGIN_NAME); ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline--primary signalBtn"
                                        data-signal="<?php echo esc_html_e($signal->signal, VISERLAB_PLUGIN_NAME); ?>" 
                                        data-name="<?php echo esc_html_e($signal->name, VISERLAB_PLUGIN_NAME); ?>"
                                    >
                                        <i class="las la-desktop"></i> <?php esc_html_e('Details', VISERLAB_PLUGIN_NAME); ?>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if (viser_check_empty($signals->data)) { ?>
                            <tr>
                                <td class="text-muted text-center" colspan="100%"><?php esc_html_e('Data not found', VISERLAB_PLUGIN_NAME); ?></td>
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

<div id="signalModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php esc_html_e('Signal Details', VISERLAB_PLUGIN_NAME); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <h6 class="name"></h6>
                </div>
                <div class="mt-3">
                    <p class="signal"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--danger btn-sm" data-bs-dismiss="modal"><?php esc_html_e('Close', VISERLAB_PLUGIN_NAME); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        "use strict";

        $('.signalBtn').on('click', function() {
            var modal = $('#signalModal');
            modal.find('.name').text($(this).data('name'));
            modal.find('.signal').text($(this).data('signal'));
            modal.modal('show');
        });

    });
</script>



