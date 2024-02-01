<?php viser_layout('user/layouts/master'); ?>

<div class="pt-120 pb-100 bg-light">
    <div class="container">
        <table class="table table--responsive--lg mt-4">
            <thead>
                <tr>
                    <th><?php esc_html_e('Send Signal At', VISERLAB_PLUGIN_NAME); ?></th>
                    <th><?php esc_html_e('Name', VISERLAB_PLUGIN_NAME); ?></th>
                    <th><?php esc_html_e('Details', VISERLAB_PLUGIN_NAME); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($signals->data as $signal) {
                        $signal = viser_signal($signal->signal_id); 
                    ?>
                    <tr>
                        <td>
                            <div>
                                <?php echo viser_show_date_time($signal->created_at); ?><br><?php echo viser_diff_for_humans($signal->created_at); ?>
                            </div>
                        </td>

                        <td>
                            <div>
                                <?php echo esc_html(viser_str_limit($signal->name, 50)); ?>
                            </div>
                        </td>

                        <td class="budget">
                            <button class="badge badge--icon badge--fill-base signalBtn"
                                data-signal="<?php echo esc_html_e($signal->signal, VISERLAB_PLUGIN_NAME); ?>" 
                                data-name="<?php echo esc_html_e($signal->name, VISERLAB_PLUGIN_NAME); ?>"
                            >
                                <i class="fa fa-desktop"></i>
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
        </table>
        <div class="pt-50">
            <?php if ($signals->links) { ?>
                <?php echo wp_kses($signals->links, viser_allowed_html()); ?>
            <?php } ?>
        </div>
    </div>
</div>

<div id="signalModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php esc_html_e('Signal Details', VISERLAB_PLUGIN_NAME); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="nameArea">
                    <span class="fw-bold me-2"><?php esc_html_e('Name', VISERLAB_PLUGIN_NAME); ?>:</span>
                    <span class="name"></span>
                </div>
                <div class="signalArea mt-4">
                    <p class="signal"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--dark btn--sm" data-bs-dismiss="modal">
                    <?php esc_html_e('Close', VISERLAB_PLUGIN_NAME); ?>
                </button>
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
