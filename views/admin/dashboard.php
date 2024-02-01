<?php viser_layout('admin/layouts/master'); ?>
<div class="row gy-4">
    <div class="col-xxl-3 col-sm-6">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
            <i class="fas fa-hand-holding-usd overlay-icon text--success"></i>
            <div class="widget-two__icon b-radius--5 bg--success">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="widget-two__content">
                <h3><?php echo viser_currency('sym'); ?><?php echo viser_show_amount($deposit['total']); ?></h3>
                <p><?php esc_html_e('Total Deposited', VISERLAB_PLUGIN_NAME); ?></p>
            </div>
            <a href="<?php echo viser_route_link('admin.deposit.list'); ?>" class="widget-two__btn btn btn-outline--success">
                <?php esc_html_e('View All', VISERLAB_PLUGIN_NAME); ?>
            </a>
        </div> 
    </div>
    <!-- dashboard-w1 end -->
    <div class="col-xxl-3 col-sm-6">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
            <i class="fas fa-spinner overlay-icon text--warning"></i>
            <div class="widget-two__icon b-radius--5 bg--warning">
                <i class="fas fa-spinner"></i>
            </div>
            <div class="widget-two__content">
                <h3><?php echo esc_html($deposit['pending']); ?></h3>
                <p><?php esc_html_e('Pending Deposits', VISERLAB_PLUGIN_NAME); ?></p>
            </div>
            <a href="<?php echo viser_route_link('admin.deposit.pending'); ?>" class="widget-two__btn btn btn-outline--warning">
                <?php esc_html_e('View All', VISERLAB_PLUGIN_NAME); ?>
            </a>
        </div>
    </div>
    <!-- dashboard-w1 end -->
    <div class="col-xxl-3 col-sm-6">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
            <i class="fas fa-ban overlay-icon text--danger"></i>
            <div class="widget-two__icon b-radius--5 bg--danger">
                <i class="fas fa-ban"></i>
            </div>
            <div class="widget-two__content">
                <h3><?php echo esc_html($deposit['rejected']); ?></h3>
                <p><?php esc_html_e('Rejected Deposits', VISERLAB_PLUGIN_NAME); ?></p>
            </div>
            <a href="<?php echo viser_route_link('admin.deposit.rejected'); ?>" class="widget-two__btn btn btn-outline--danger">
                <?php esc_html_e('View All', VISERLAB_PLUGIN_NAME); ?>
            </a>
        </div>
    </div>
    <!-- dashboard-w1 end -->
    <div class="col-xxl-3 col-sm-6">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
            <i class="fas fa-percentage overlay-icon text--primary"></i>
            <div class="widget-two__icon b-radius--5   bg--primary  ">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="widget-two__content">
                <h3><?php echo viser_currency('sym'); ?><?php echo viser_show_amount($deposit['charge']); ?></h3>
                <p><?php esc_html_e('Deposited Charge', VISERLAB_PLUGIN_NAME); ?></p>
            </div>
            <a href="<?php echo viser_route_link('admin.deposit.list'); ?>" class="widget-two__btn btn btn-outline--primary">
                <?php esc_html_e('View All', VISERLAB_PLUGIN_NAME); ?>
            </a>
        </div>
    </div>
    <!-- dashboard-w1 end -->
</div><!-- /row -->

<div class="row gy-4 mt-2">
    <div class="col-xxl-3 col-sm-6">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
            <i class="las la-signal overlay-icon text--primary"></i>
            <div class="widget-two__icon b-radius--5 border border--primary text--primary">
                <i class="las la-signal"></i>
            </div>
            <div class="widget-two__content">
                <h3><?php echo esc_html($signalStatistics['total']); ?></h3>
                <p><?php esc_html_e('Total Signals', VISERLAB_PLUGIN_NAME); ?></p>
            </div> 
            <a href="<?php echo viser_route_link('admin.signal.all') ?>" class="widget-two__btn border border--primary btn-outline--primary">
                <?php esc_html_e('View All', VISERLAB_PLUGIN_NAME); ?>
            </a>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
            <i class="las la-paper-plane overlay-icon text--success"></i>
            <div class="widget-two__icon b-radius--5 border border--success text--success">
                <i class="las la-paper-plane"></i>
            </div>
            <div class="widget-two__content">
                <h3><?php echo esc_html($signalStatistics['sent']); ?></h3>
                <p><?php esc_html_e('Sent Signals', VISERLAB_PLUGIN_NAME); ?></p>
            </div>
            <a href="<?php echo viser_route_link('admin.signal.sent') ?>" class="widget-two__btn border border--success btn-outline--success">
                <?php esc_html_e('View All', VISERLAB_PLUGIN_NAME); ?>
            </a>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
            <i class="las la-spinner overlay-icon text--warning"></i>
            <div class="widget-two__icon b-radius--5 border border--warning text--warning">
                <i class="las la-spinner"></i>
            </div>
            <div class="widget-two__content">
                <h3><?php echo esc_html($signalStatistics['notSent']); ?></h3>
                <p><?php esc_html_e('Not Sent Signals', VISERLAB_PLUGIN_NAME); ?></p>
            </div>
            <a href="<?php echo viser_route_link('admin.signal.not.send') ?>" class="widget-two__btn border border--warning btn-outline--warning">
                <?php esc_html_e('View All', VISERLAB_PLUGIN_NAME); ?>
            </a>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
            <i class="las la-box overlay-icon text--primary"></i>
            <div class="widget-two__icon b-radius--5 border border--primary text--primary">
                <i class="las la-box"></i>
            </div>
            <div class="widget-two__content">
                <h3><?php echo esc_html($totalPackage); ?></h3>
                <p><?php esc_html_e('Total Packages', VISERLAB_PLUGIN_NAME); ?></p>
            </div>
            <a href="<?php echo viser_route_link('admin.package.all') ?>" class="widget-two__btn border border--primary btn-outline--primary">
                <?php esc_html_e('View All', VISERLAB_PLUGIN_NAME); ?>
            </a>
        </div>
    </div>
</div><!-- row end-->

<div class="row mt-2">
    <div class="col-xl-12 mb-30">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php esc_html_e('Transactions Report', VISERLAB_PLUGIN_NAME); ?> (<?php esc_html_e('Last 30 Days', VISERLAB_PLUGIN_NAME); ?>)</h5>
                <div id="apex-line"></div>
            </div>
        </div>
    </div>
</div>

<?php wp_enqueue_script('apexcharts', viser_asset('admin/js/vendor/apexcharts.min.js'), array('jquery'), null, true); ?>

<script>
    jQuery(document).ready(function($) {
        "use strict";
        // apex-line chart
        var options = {
            chart: {
                height: 450,
                type: "area",
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    enabledSeries: [0],
                    top: -2,
                    left: 0,
                    blur: 10,
                    opacity: 0.08
                },
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                    name: "Plus Transactions",
                    data: [
                        <?php foreach ($plusTrx as $trx) { ?>
                            <?php echo viser_get_amount($trx->amount); ?>,
                        <?php } ?>
                    ]
                },
                {
                    name: "Minus Transactions",
                    data: [
                        <?php foreach ($minusTrx as $trx) { ?>
                            <?php echo viser_get_amount($trx->amount); ?>,
                        <?php } ?>
                    ]
                }
            ],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: [
                    <?php foreach ($plusTrx as $trx) { ?> 
                        "<?php echo date('d F', strtotime($trx->date)); ?>",
                    <?php } ?>
                ]
            },
            grid: {
                padding: {
                    left: 5,
                    right: 5
                },
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#apex-line"), options);

        chart.render();
    });
</script>