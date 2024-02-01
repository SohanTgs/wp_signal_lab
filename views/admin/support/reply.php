<?php viser_layout('admin/layouts/master'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body ">
                <h6 class="card-title  mb-4">
                    <div class="row">
                        <div class="col-sm-8 col-md-6">
                            <?php
                            $html = '';
                            if ($ticket->status == 0) {
                                $html = '<span class="badge badge--success">' . __("Open", VISERLAB_PLUGIN_NAME) . '</span>';
                            } elseif ($ticket->status == 1) {
                                $html = '<span class="badge badge--primary">' . __("Answered", VISERLAB_PLUGIN_NAME) . '</span>';
                            } elseif ($ticket->status == 2) {
                                $html = '<span class="badge badge--warning">' . __("Customer Reply", VISERLAB_PLUGIN_NAME) . '</span>';
                            } elseif ($ticket->status == 3) {
                                $html = '<span class="badge badge--dark">' . __("Closed", VISERLAB_PLUGIN_NAME) . '</span>';
                            }
                            echo wp_kses($html, viser_allowed_html());
                            ?>
                            [<?php esc_html_e('Ticket', VISERLAB_PLUGIN_NAME); ?>#<?php echo esc_html($ticket->ticket); ?>] <?php echo esc_html($ticket->subject); ?>
                        </div>
                        <div class="col-sm-4  col-md-6 text-sm-end mt-sm-0 mt-3">
                            <?php if ($ticket->status != 3) { ?>
                                <button class="btn btn--danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#DelModal">
                                    <i class="fa fa-lg fa-times-circle"></i> <?php esc_html_e('Close Ticket', VISERLAB_PLUGIN_NAME); ?>
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </h6>

                <form action="<?php echo viser_route_link('admin.ticket.reply'); ?>&amp;id=<?php echo intval($ticket->id); ?>" enctype="multipart/form-data" method="post" class="form-horizontal">
                    <?php viser_nonce_field('admin.ticket.reply'); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="5" required id="inputMessage"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row form-group">
                                <div class="col-12">
                                    <label for="inputAttachments"><?php esc_html_e('Attachments', VISERLAB_PLUGIN_NAME); ?></label> <span class="text--danger"><?php esc_html_e('Max 5 files can be uploaded. Maximum upload size is', VISERLAB_PLUGIN_NAME); ?> <?php echo ini_get('upload_max_filesize'); ?></span>
                                </div>
                                <div class="col-9">
                                    <div class="file-upload-wrapper" data-text="<?php esc_attr_e('Select your file!', VISERLAB_PLUGIN_NAME); ?>">
                                        <input type="file" name="attachments[]" id="inputAttachments" class="file-upload-field" />
                                    </div>
                                </div>
                                <div class="col-3">
                                    <button type="button" class="btn btn--dark extraTicketAttachment ms-0"><i class="fa fa-plus"></i></button>
                                </div>
                                <div class="col-12">
                                    <div id="fileUploadsContainer"></div>
                                </div>
                                <div class="col-md-12 ticket-attachments-message text-muted mt-3">
                                    <?php esc_html_e('Allowed File Extensions', VISERLAB_PLUGIN_NAME); ?>: .<?php esc_html_e('jpg', VISERLAB_PLUGIN_NAME); ?>, .<?php esc_html_e('jpeg', VISERLAB_PLUGIN_NAME); ?>, .<?php esc_html_e('png', VISERLAB_PLUGIN_NAME); ?>, .<?php esc_html_e('pdf', VISERLAB_PLUGIN_NAME); ?>, .<?php esc_html_e('doc', VISERLAB_PLUGIN_NAME); ?>, .<?php esc_html_e('docx', VISERLAB_PLUGIN_NAME); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 offset-md-3">
                            <button class="btn btn--primary w-100 mt-4" type="submit" name="replayTicket" value="1">
                                <i class="la la-fw la-lg la-reply"></i> <?php esc_html_e('Reply', VISERLAB_PLUGIN_NAME); ?>
                            </button>
                        </div>
                    </div>
                </form>

                <?php foreach ($messages as $message) {
                    $user = get_userdata($ticket->user_id);
                ?>
                    <?php if ($message->admin_id == 0) { ?>

                        <div class="row border border--primary border-radius-3 my-3 mx-2">

                            <div class="col-md-3 border-end text-md-end text-start">
                                <h5 class="my-3"><?php echo esc_html($ticket->name); ?></h5>
                                <?php if ($ticket->user_id) { ?>
                                    <p><a href="<?php echo viser_route_link('admin.users.detail');?>&amp;id=<?php echo intval($user->ID); ?>">@<?php echo esc_html($user->user_login); ?></a></p>
                                <?php } else { ?>
                                    <p class="fw-bold"><?php esc_html($ticket->name); ?></p>
                                <?php } ?>
                                <button class="btn btn-danger btn-sm my-3 confirmationBtn" data-question="<?php esc_attr_e('Are you sure to delete this message?'); ?>" data-action="<?php echo viser_route_link('admin.ticket.delete'); ?>&amp;id=<?php echo intval($message->id); ?>" data-nonce="<?php echo esc_attr(viser_nonce('admin.ticket.delete')) ?>"><i class="la la-trash"></i> <?php esc_html_e('Delete', VISERLAB_PLUGIN_NAME); ?></button>
                            </div>

                            <div class="col-md-9">
                                <p class="text-muted fw-bold my-3">
                                    <?php esc_html_e('Posted on', VISERLAB_PLUGIN_NAME); ?> <?php echo date('l, dS F Y @ H:i', strtotime($message->created_at)); ?>
                                </p>
                                <p><?php echo esc_html($message->message); ?></p>
                                <?php if (count(viser_support_ticket_attachments($message->id)) > 0) { ?>
                                    <div class="my-3">
                                        <?php foreach (viser_support_ticket_attachments($message->id) as $k => $image) { ?>
                                            <a href="<?php echo viser_route_link('admin.ticket.download'); ?>&amp;id=<?php echo viser_encrypt($image->id); ?>" class="me-3">
                                                <i class="fa fa-file"></i> <?php esc_html_e('Attachment', VISERLAB_PLUGIN_NAME); ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row border border-warning border-radius-3 my-3 mx-2 admin-bg-reply">
                            <div class="col-md-3 border-end text-md-end text-start">
                                <h5 class="my-3"><?php esc_html_e('Admin', VISERLAB_PLUGIN_NAME); ?></h5>
                                <p class="lead text-muted"><?php esc_html_e('Staff', VISERLAB_PLUGIN_NAME); ?></p>
                                <button class="btn btn-danger btn-sm my-3 confirmationBtn" data-question="<?php esc_attr_e('Are you sure to delete this message?'); ?>" data-action="<?php echo viser_route_link('admin.ticket.delete'); ?>&amp;id=<?php echo intval($message->id); ?>" data-nonce="<?php echo esc_attr(viser_nonce('admin.ticket.delete')) ?>"><i class="la la-trash"></i> <?php esc_html_e('Delete', VISERLAB_PLUGIN_NAME); ?></button>
                            </div>
                            <div class="col-md-9">
                                <p class="text-muted fw-bold my-3">
                                    <?php esc_html_e('Posted on', VISERLAB_PLUGIN_NAME); ?> <?php echo date('l, dS F Y @ H:i', strtotime($message->created_at)); ?>
                                </p>
                                <p><?php echo esc_html($message->message); ?></p>
                                <?php if (count(viser_support_ticket_attachments($message->id)) > 0) { ?>
                                    <div class="my-3">
                                        <?php foreach (viser_support_ticket_attachments($message->id) as $k => $image) { ?>
                                            <a href="<?php echo viser_route_link('admin.ticket.download'); ?>&amp;id=<?php echo viser_encrypt($image->id); ?>" class="me-3">
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

<?php viser_include('partials/confirmation'); ?>

<div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php esc_html_e('Close Support Ticket!', VISERLAB_PLUGIN_NAME); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p><?php esc_html_e('Are you want to close this support ticket?', VISERLAB_PLUGIN_NAME); ?></p>
            </div>
            <div class="modal-footer">
                <form method="post" action="<?php echo viser_route_link('admin.ticket.close'); ?>&amp;id=<?php echo intval($ticket->id); ?>">
                    <?php viser_nonce_field('admin.ticket.close'); ?>
                    <input type="hidden" name="replayTicket" value="2">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php esc_html_e('No', VISERLAB_PLUGIN_NAME); ?></button>
                    <button type="submit" class="btn btn--primary"><?php esc_html_e('Yes', VISERLAB_PLUGIN_NAME); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        "use strict";
        $('.delete-message').on('click', function(e) {
            $('.message_id').val($(this).data('id'));
        })
        var fileAdded = 0;
        $('.extraTicketAttachment').on('click', function() {
            if (fileAdded >= 4) {
                alert('You\'ve added maximum number of file');
                return false;
            }
            fileAdded++;
            $("#fileUploadsContainer").append(`
                <div class="row">
                    <div class="col-9 mb-3">
                        <div class="file-upload-wrapper" data-text="Select your file!"><input type="file" name="attachments[]" id="inputAttachments" class="file-upload-field"/></div>
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn--danger extraTicketAttachmentDelete"><i class="la la-times ms-0"></i></button>
                    </div>
                </div>
            `)
        });

        $(document).on('click', '.extraTicketAttachmentDelete', function() {
            fileAdded--;
            $(this).closest('.row').remove();
        });
    });
</script>