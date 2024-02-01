<?php
wp_enqueue_style('iziToast', viser_assets('global/css/iziToast.min.css'));
wp_enqueue_script('iziToast', viser_assets('global/js/iziToast.min.js'), array('jquery'), null, true);
?>


<?php if (viser_session()->has('errors')) {
        foreach (viser_session()->get('errors') as $msg) { ?>
            <script>
            jQuery(document).ready(function($) {
                "use strict";
                iziToast["error"]({
                    message: "<?php echo esc_html($msg) ?>",
                    position: "topRight"
                });
            });
        </script>
        <?php } ?>
    <?php } ?>

<?php if (viser_session()->has('notify')) {
    foreach (viser_session()->get('notify') as $msg) { ?>
        <script>
            jQuery(document).ready(function($) {
                "use strict";
                iziToast["<?php echo esc_html($msg[0]) ?>"]({
                    message: "<?php echo esc_html($msg[1]) ?>",
                    position: "topRight"
                });
            });
        </script>
    <?php } ?>
<?php } ?>

<script>
    jQuery(document).ready(function($) {
        "use strict";
        function notify(status, message) {
            iziToast[status]({
                message: message,
                position: "topRight"
            });
        }
    });
</script>