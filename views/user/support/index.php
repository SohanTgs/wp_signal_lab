<?php viser_layout('user/layouts/master'); ?>

<section class="pt-120 pb-100 bg-light">
    <div class="container">
        <table class="table table--responsive--md">
            <thead>
                <tr>
                    <th><?php esc_html_e('Subject', VISERLAB_PLUGIN_NAME); ?></th>
                    <th><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?></th>
                    <th><?php esc_html_e('Priority', VISERLAB_PLUGIN_NAME); ?></th>
                    <th><?php esc_html_e('Last Reply', VISERLAB_PLUGIN_NAME); ?></th>
                    <th><?php esc_html_e('Action', VISERLAB_PLUGIN_NAME); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($supports->data as $support) { ?>
                    <tr>
                        <td>
                            <a href="<?php echo viser_route_link('user.ticket.view'); ?>?id=<?php echo intval($support->ticket); ?>" class="fw-bold">
                                [<?php esc_html_e('Ticket', VISERLAB_PLUGIN_NAME); ?>#<?php echo esc_html($support->ticket); ?>] 
                                <br>
                                <?php echo esc_html($support->subject); ?>
                            </a>
                        </td>
                        <td>
                            <?php
                            $html = '';
                            if ($support->status == 0) {
                                $html = '<span class="badge bg-success">' . __("Open", VISERLAB_PLUGIN_NAME) . '</span>';
                            } elseif ($support->status == 1) {
                                $html = '<span class="badge bg-primary">' . __("Answered", VISERLAB_PLUGIN_NAME) . '</span>';
                            } elseif ($support->status == 2) {
                                $html = '<span class="badge bg-warning">' . __("Customer Reply", VISERLAB_PLUGIN_NAME) . '</span>';
                            } elseif ($support->status == 3) {
                                $html = '<span class="badge bg-dark">' . __("Closed", VISERLAB_PLUGIN_NAME) . '</span>';
                            }
                            echo wp_kses($html, viser_allowed_html());
                            ?>
                        </td>
                        <td>
                            <?php if ($support->priority == 1) { ?>
                                <span class="badge bg-dark"><?php esc_html_e('Low', VISERLAB_PLUGIN_NAME); ?></span>
                            <?php } elseif ($support->priority == 2) { ?>
                                <span class="badge  bg-warning"><?php esc_html_e('Medium', VISERLAB_PLUGIN_NAME); ?></span>
                            <?php } elseif ($support->priority == 3) { ?>
                                <span class="badge bg-danger"><?php esc_html_e('High', VISERLAB_PLUGIN_NAME); ?></span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo viser_show_date_time($support->last_reply); ?>
                            <br>
                            <?php echo viser_diff_for_humans($support->last_reply); ?>
                        </td>
                        <td>
                            <a href="<?php echo viser_route_link('user.ticket.view'); ?>?id=<?php echo intval($support->ticket); ?>" class="badge badge--icon badge--fill-base" data-bs-toggle="tooltip" data-bs-position="top" title="@lang('View')">
                                <i class="las la-desktop"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (viser_check_empty($supports->data)) { ?>
                    <tr>
                        <td colspan="100%" class="text-center"><?php esc_html_e('Data not found', VISERLAB_PLUGIN_NAME); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="pt-50">
            <?php if ($supports->links) { ?>
                <?php echo wp_kses($supports->links, viser_allowed_html()); ?>
            <?php } ?>
        </div>
    </div>
</section>

<script>
    jQuery(document).ready(function($) {
        "use strict";
        $('.py-2').removeClass('py-2');
        $('.px-3').removeClass('px-3');
    });
</script>