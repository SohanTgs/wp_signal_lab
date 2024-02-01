<?php viser_layout('admin/layouts/master'); ?>

<div class="row">
    <div class="col-md-12"> 
        <div class="card">
            <form action="<?php echo viser_route_link('admin.setting.notification.telegram.update'); ?>" method="POST">
                <?php viser_nonce_field('admin.setting.notification.telegram.update') ?>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-control-label"><?php esc_html_e('Telegram Bot Api Token', VISERLAB_PLUGIN_NAME); ?></label>
                            <input type="text" class="form-control" name="bot_api_token" value="<?php echo esc_attr($telegramConfig->bot_api_token); ?>"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label><?php esc_html_e('BOT Username', VISERLAB_PLUGIN_NAME); ?></label>
                            <div class="input-group">
                                <span class="input-group-text"><?php esc_html_e('http://t.me/', VISERLAB_PLUGIN_NAME); ?></span>
                                <input type="text" name="bot_username" class="form-control" value="<?php echo esc_attr($telegramConfig->bot_username); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="telegramBotModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php esc_html_e('Telegram Bot Setup', VISERLAB_PLUGIN_NAME); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive overflow-hidden">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('To Do', VISERLAB_PLUGIN_NAME); ?></th>
                                <th><?php esc_html_e('Description', VISERLAB_PLUGIN_NAME); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php esc_html_e('Step 1', VISERLAB_PLUGIN_NAME); ?></td>
                            <td><?php esc_html_e('Install Telegram App.', VISERLAB_PLUGIN_NAME); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('Step 2', VISERLAB_PLUGIN_NAME); ?></td>
                            <td><?php esc_html_e('Open App and Search for ', VISERLAB_PLUGIN_NAME); ?><code class="text--primary">@BotFather</code></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('Step 3', VISERLAB_PLUGIN_NAME); ?></td>
                            <td><?php esc_html_e('Start Conversion As ', VISERLAB_PLUGIN_NAME); ?><code class="text--primary">/newbot</code></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('Step 4', VISERLAB_PLUGIN_NAME); ?></td>
                            <td><?php esc_html_e('Chose a Bot Name and Press Enter.', VISERLAB_PLUGIN_NAME); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('Step 5', VISERLAB_PLUGIN_NAME); ?></td>
                            <td><?php esc_html_e('Choose a username for your bot. It must end in `bot`. Like this, for example: TetrisBot or tetris_bot', VISERLAB_PLUGIN_NAME); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('Step 6', VISERLAB_PLUGIN_NAME); ?></td>
                            <td><?php esc_html_e('Bot will give you your BOT URL and API Key. Copy This and Paste Bellow.', VISERLAB_PLUGIN_NAME); ?></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('Step 7', VISERLAB_PLUGIN_NAME); ?></td>
                            <td><?php esc_html_e('Write your Bot Description using ', VISERLAB_PLUGIN_NAME); ?> <code class="text--primary">/setdescription</code></td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e('Step 8', VISERLAB_PLUGIN_NAME); ?></td>
                            <td><?php esc_html_e('Set Bot Privacy using ', VISERLAB_PLUGIN_NAME); ?> <code class="text--primary">/setprivacy</code></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php esc_html_e('Close', VISERLAB_PLUGIN_NAME); ?></button>
            </div>
        </div>
    </div>
</div>

<?php
$html = '<button type="button" data-bs-target="#telegramBotModal" data-bs-toggle="modal" class="btn btn-outline--primary mb-2"><i class="las la-question"></i>'. __("How To Create Telegram Bot", VISERLAB_PLUGIN_NAME).'</button>';
viser_push_breadcrumb($html);
?>
