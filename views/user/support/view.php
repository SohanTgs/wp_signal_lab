<?php viser_layout('user/layouts/master'); ?>

<section class="pt-120 pb-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="custom--card">
                    <div class="card-header card-header-bg d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <h5 class="card-title mt-0">
                        <?php
                            $html = '';
                            if ($myTicket->status == 0) {
                                $html = '<span class="badge bg-success">' . __("Open", VISERLAB_PLUGIN_NAME) . '</span>';
                            } elseif ($myTicket->status == 1) {
                                $html = '<span class="badge bg-primary">' . __("Answered", VISERLAB_PLUGIN_NAME) . '</span>';
                            } elseif ($myTicket->status == 2) {
                                $html = '<span class="badge bg-warning">' . __("Customer Reply", VISERLAB_PLUGIN_NAME) . '</span>';
                            } elseif ($myTicket->status == 3) {
                                $html = '<span class="badge bg-dark">' . __("Closed", VISERLAB_PLUGIN_NAME) . '</span>';
                            }
                            echo wp_kses($html, viser_allowed_html());
                        ?>
                            <span class="text-white">
                                [<?php esc_html_e('Ticket', VISERLAB_PLUGIN_NAME); ?>#<?php echo esc_html($myTicket->ticket); ?>] <?php echo esc_html($myTicket->subject); ?>   
                            </span>
                        </h5>
                        <?php if ($myTicket->status != 3) { ?>
                            <button class="btn btn-danger close-button btn--sm"
                                title="@lang('Close Ticket')" data-bs-toggle="modal" data-bs-target="#closeModal"
                            >
                                <i class="las la-times"></i>
                            </button>
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo viser_route_link('user.ticket.reply'); ?>?id=<?php echo intval($myTicket->id); ?>" enctype="multipart/form-data" class="transparent-form">
                            <?php viser_nonce_field('user.ticket.reply'); ?>
                            <input type="hidden" name="replayTicket" value="1">
                            <div class="row justify-content-between">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <textarea name="message" class="form--control form-control" id="inputMessage" rows="4" cols="10" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-between">
                                <div class="col-md-9">
                                    <div class="row justify-content-between">
                                        <div class="col-md-11">
                                            <div class="form-group">
                                                <label for="inputAttachments" class="form-label">
                                                    <?php esc_html_e('Attachments', VISERLAB_PLUGIN_NAME); ?>
                                                </label>
                                                <small class="text--danger">
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
                                    </div>
                                </div>
                                <div class="col-md-3 pt-2">
                                    <button type="submit" class="btn btn--base custom-success mt-md-4 w-100">
                                        <i class="fa fa-reply"></i> <?php esc_html_e('Reply', VISERLAB_PLUGIN_NAME); ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12">
                                <?php foreach ($messages as $message) {
                                    $ticket = viser_support_ticket($message->support_ticket_id);
                                ?>
                                    <?php if ($message->admin_id == 0) { ?>
                                        <div class="row support-answer-wrapper radius-3 my-3 py-3 mx-2 border">
                                            <div class="col-md-3 border-end text-end">
                                                <h5 class="my-3"><?php echo esc_html($ticket->name); ?></h5>
                                            </div>
                                            <div class="col-md-9">
                                                <p class="text-muted font-weight-bold my-3">
                                                    <?php esc_html_e('Posted on', VISERLAB_PLUGIN_NAME); ?> <?php echo date('l, dS F Y @ H:i', strtotime($message->created_at)); ?></p>
                                                <p><?php echo esc_html($message->message); ?></p>
                                                <?php if (count(viser_support_ticket_attachments($message->id)) > 0) { ?>
                                                    <div class="mt-2">
                                                        <?php foreach (viser_support_ticket_attachments($message->id) as $k => $image) { ?>
                                                            <a href="<?php echo viser_route_link('user.ticket.download'); ?>?id=<?php echo viser_encrypt($image->id); ?>" class="me-3">
                                                                <i class="fa fa-file"></i> <?php esc_html_e('Attachment', VISERLAB_PLUGIN_NAME); ?>
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row support-answer-wrapper support-answer-wrapper-admin my-3 py-3 mx-2 border bg-light">
                                            <div class="col-md-3 border-end text-end">
                                                <h5 class="my-3"><?php esc_html_e('Admin', VISERLAB_PLUGIN_NAME); ?></h5>
                                                <p class="lead text-muted"><?php esc_html_e('Staff', VISERLAB_PLUGIN_NAME); ?></p>
                                            </div>
                                            <div class="col-md-9">
                                                <p class="text-muted font-weight-bold my-3">
                                                    <?php esc_html_e('Posted on', VISERLAB_PLUGIN_NAME); ?> <?php echo date('l, dS F Y @ H:i', strtotime($message->created_at)); ?></p>
                                                <p><?php echo esc_html($message->message); ?></p>
                                                <?php if (count(viser_support_ticket_attachments($message->id)) > 0) { ?>
                                                    <div class="mt-2">
                                                        <?php foreach (viser_support_ticket_attachments($message->id) as $k => $image) { ?>
                                                            <a href="<?php echo viser_route_link('user.ticket.download'); ?>?id=<?php echo viser_encrypt($image->id); ?>" class="me-3">
                                                                <i class="fa fa-file"></i> <?php esc_html_e('Attachment', VISERLAB_PLUGIN_NAME); ?>
                                                            </a>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</section>

<div class="modal fade" id="closeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?php echo viser_route_link('user.ticket.close'); ?>?id=<?php echo intval($myTicket->id); ?>">
                <?php viser_nonce_field('user.ticket.close');?>
                <div class="modal-header">
                    <h5 class="modal-title"><?php esc_html_e('Confirmation!', VISERLAB_PLUGIN_NAME); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?php esc_html_e('Are you sure you want to close this support ticket?', VISERLAB_PLUGIN_NAME); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark btn--sm" data-bs-dismiss="modal">
                        <?php esc_html_e('Close', VISERLAB_PLUGIN_NAME); ?>
                    </button>
                    <button type="submit" class="btn btn--success btn--sm">
                        <?php esc_html_e('Confirm', VISERLAB_PLUGIN_NAME); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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

        $('.py-2').removeClass('py-2');
        $('.px-3').removeClass('px-3');
    });
</script>