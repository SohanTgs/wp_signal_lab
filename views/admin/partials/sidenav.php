<div class="sidebar bg--dark">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="<?php menu_page_url(VISERLAB_PLUGIN_NAME); ?>" class="sidebar__main-logo">
                <img src="<?php echo viser_get_image(viser_file_path('logoIcon').'/logo.png'); ?>" alt="Logo">
            </a>
        </div>

        <div class="sidebar__menu-wrapper position-relative" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                
                <li class="sidebar-menu-item <?php viser_menu_active('admin.'.VISERLAB_PLUGIN_NAME, dashboard: true) ?>">
                    <a href="<?php menu_page_url(VISERLAB_PLUGIN_NAME) ?>" class="nav-link">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title"><?php esc_html_e('Dashboard', VISERLAB_PLUGIN_NAME) ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item <?php viser_menu_active(['admin.package.all']) ?>">
                    <a href="<?php echo viser_route_link('admin.package.all');?>" class="nav-link">
                        <i class="menu-icon las la-box"></i>
                        <span class="menu-title"><?php esc_html_e('Manage Package', VISERLAB_PLUGIN_NAME) ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item <?php viser_menu_active(['admin.users.all', 'admin.users.detail']) ?>">
                    <a href="<?php echo viser_route_link('admin.users.all');?>" class="nav-link">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title"><?php esc_html_e('All Users', VISERLAB_PLUGIN_NAME) ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="<?php viser_menu_active([
                                                            'admin.signal.all',
                                                            'admin.signal.sent',
                                                            'admin.signal.not.send',
                                                            'admin.signal.edit',
                                                            'admin.signal.add.page',
                                                        ], 3) ?>">
                        <i class="menu-icon la la-signal"></i>
                        <span class="menu-title"><?php esc_html_e('Manage Signal', VISERLAB_PLUGIN_NAME); ?></span>
                    </a>
                    <div class="sidebar-submenu <?php viser_menu_active([
                                                        'admin.signal.all',
                                                        'admin.signal.sent',
                                                        'admin.signal.not.send',
                                                        'admin.signal.edit',
                                                        'admin.signal.add.page'
                                                ], 2) ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php viser_menu_active(['admin.signal.sent']) ?>">
                                <a href="<?php echo viser_route_link('admin.signal.sent') ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Send Signals', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php viser_menu_active(['admin.signal.not.send']) ?>">
                                <a href="<?php echo viser_route_link('admin.signal.not.send') ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Not Send Signals', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php viser_menu_active(['admin.signal.all']) ?>">
                                <a href="<?php echo viser_route_link('admin.signal.all') ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('All Signals', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="<?php viser_menu_active([
                                                            'admin.gateway.automatic',
                                                            'admin.gateway.automatic.edit',
                                                            'admin.gateway.manual',
                                                            'admin.gateway.manual.create',
                                                            'admin.gateway.manual.edit'
                                                        ], 3) ?>">
                        <i class="menu-icon las la-credit-card"></i>
                        <span class="menu-title"><?php esc_html_e('Payment Gateways', VISERLAB_PLUGIN_NAME); ?></span>
                    </a>
                    <div class="sidebar-submenu <?php viser_menu_active([
                                                    'admin.gateway.automatic',
                                                    'admin.gateway.automatic.edit',
                                                    'admin.gateway.manual',
                                                    'admin.gateway.manual.create',
                                                    'admin.gateway.manual.edit'
                                                ], 2) ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php viser_menu_active(['admin.gateway.automatic', 'admin.gateway.automatic.edit']) ?>">
                                <a href="<?php echo viser_route_link('admin.gateway.automatic') ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Automatic Gateways', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php viser_menu_active(['admin.gateway.manual', 'admin.gateway.manual.create', 'admin.gateway.manual.edit']) ?>">
                                <a href="<?php echo viser_route_link('admin.gateway.manual') ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Manual Gateways', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="sidebar-menu-item sidebar-dropdown">

                    <a href="javascript:void(0)" class="<?php viser_menu_active(['admin.deposit.pending', 'admin.deposit.approved', 'admin.deposit.successful', 'admin.deposit.rejected', 'admin.deposit.initiated', 'admin.deposit.list', 'admin.deposit.details'], 3); ?>">
                        <i class="menu-icon las la-file-invoice-dollar"></i>
                        <span class="menu-title"><?php esc_html_e('Deposits', VISERLAB_PLUGIN_NAME); ?></span>
                        <?php if(0 < pending_deposit_count()){?>
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        <?php } ?>
                    </a>

                    <div class="sidebar-submenu <?php viser_menu_active(['admin.deposit.pending', 'admin.deposit.approved', 'admin.deposit.successful', 'admin.deposit.rejected', 'admin.deposit.initiated', 'admin.deposit.list', 'admin.deposit.details'], 2); ?>">
                        <ul>

                            <li class="sidebar-menu-item <?php viser_menu_active('admin.deposit.pending'); ?>">
                                <a href="<?php echo viser_route_link('admin.deposit.pending'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Pending Deposits', VISERLAB_PLUGIN_NAME); ?></span>
                                    <?php if(pending_deposit_count()){?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo esc_html(pending_deposit_count());?></span>
                                    <?php } ?>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php viser_menu_active('admin.deposit.approved'); ?>">
                                <a href="<?php echo viser_route_link('admin.deposit.approved'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Approved Deposits', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php viser_menu_active('admin.deposit.successful'); ?>">
                                <a href="<?php echo viser_route_link('admin.deposit.successful'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Successful Deposits', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php viser_menu_active('admin.deposit.rejected'); ?>">
                                <a href="<?php echo viser_route_link('admin.deposit.rejected'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Rejected Deposits', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php viser_menu_active('admin.deposit.initiated'); ?>">

                                <a href="<?php echo viser_route_link('admin.deposit.initiated'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Initiated Deposits', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php viser_menu_active('admin.deposit.list'); ?>">
                                <a href="<?php echo viser_route_link('admin.deposit.list'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('All Deposits', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="<?php viser_menu_active(['admin.ticket.pending', 'admin.ticket.closed', 'admin.ticket.answered', 'admin.ticket.index', 'admin.ticket.view'], 3); ?>">
                        <i class="menu-icon la la-ticket"></i>
                        <span class="menu-title"><?php esc_html_e('Support Ticket', VISERLAB_PLUGIN_NAME); ?></span>
                        <?php if(0 < pending_ticket_count()){?>
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        <?php } ?>
                    </a>
                    <div class="sidebar-submenu <?php viser_menu_active(['admin.ticket.pending', 'admin.ticket.closed', 'admin.ticket.answered', 'admin.ticket.index', 'admin.ticket.view'], 2); ?> ">
                        <ul>
                            <li class="sidebar-menu-item <?php viser_menu_active('admin.ticket.pending'); ?> ">
                                <a href="<?php echo viser_route_link('admin.ticket.pending'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Pending Ticket', VISERLAB_PLUGIN_NAME); ?></span>
                                    <?php if(pending_ticket_count()){?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo esc_html(pending_ticket_count());?></span>
                                    <?php } ?>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php viser_menu_active('admin.ticket.closed'); ?> ">
                                <a href="<?php echo viser_route_link('admin.ticket.closed'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Closed Ticket', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php viser_menu_active('admin.ticket.answered'); ?> ">
                                <a href="<?php echo viser_route_link('admin.ticket.answered'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Answered Ticket', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php viser_menu_active('admin.ticket.index'); ?> ">
                                <a href="<?php echo viser_route_link('admin.ticket.index'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('All Ticket', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" 
                        class="<?php viser_menu_active(['admin.report.transaction', 'admin.report.notification.history', 'admin.report.signal.history'], 3); ?>">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title"><?php esc_html_e('Report', VISERLAB_PLUGIN_NAME); ?></span>
                    </a>
                    <div class="sidebar-submenu <?php viser_menu_active(['admin.report.transaction', 'admin.report.notification.history', 'admin.report.signal.history'], 2); ?> ">
                        <ul>
                            <li class="sidebar-menu-item <?php viser_menu_active('admin.report.transaction'); ?>">
                                <a href="<?php echo viser_route_link('admin.report.transaction'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Transaction Log', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php viser_menu_active('admin.report.signal.history'); ?>">
                                <a href="<?php echo viser_route_link('admin.report.signal.history'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Signal Log', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar__menu-header"><?php esc_html_e('Settings', VISERLAB_PLUGIN_NAME); ?></li>

                <li class="sidebar-menu-item <?php viser_menu_active('admin.setting.index'); ?>">
                    <a href="<?php echo viser_route_link('admin.setting.index'); ?>" class="nav-link">
                        <i class="menu-icon las la-life-ring"></i>
                        <span class="menu-title"><?php esc_html_e('General Setting', VISERLAB_PLUGIN_NAME); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item <?php viser_menu_active('admin.setting.system.configuration'); ?>">
                    <a href="<?php echo viser_route_link('admin.setting.system.configuration'); ?>" class="nav-link">
                        <i class="menu-icon las la-cog"></i>
                        <span class="menu-title"><?php esc_html_e('System Configuration', VISERLAB_PLUGIN_NAME); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item <?php viser_menu_active('admin.extension.index'); ?>">
                    <a href="<?php echo viser_route_link('admin.extension.index'); ?>" class="nav-link">
                        <i class="menu-icon las la-cogs"></i>
                        <span class="menu-title"><?php esc_html_e('Extensions', VISERLAB_PLUGIN_NAME); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item <?php viser_menu_active('admin.setting.logo.icon') ?>">
                    <a href="<?php echo viser_route_link('admin.setting.logo.icon') ?>" class="nav-link">
                        <i class="menu-icon las la-images"></i>
                        <span class="menu-title"><?php esc_html_e('Logo & Favicon', VISERLAB_PLUGIN_NAME); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="<?php viser_menu_active(['admin.setting.notification.global', 'admin.setting.notification.email', 'admin.setting.notification.sms', 'admin.setting.notification.templates'], 3); ?>">
                        <i class="menu-icon las la-bell"></i>
                        <span class="menu-title"><?php esc_html_e('Notification Setting', VISERLAB_PLUGIN_NAME); ?></span>
                    </a>
                    <div class="sidebar-submenu <?php viser_menu_active(['admin.setting.notification.global', 'admin.setting.notification.email', 'admin.setting.notification.sms', 'admin.setting.notification.templates', 'admin.setting.notification.telegram'], 2); ?> ">
                        <ul>
                            <li class="sidebar-menu-item <?php viser_menu_active('admin.setting.notification.global'); ?> ">
                                <a href="<?php echo viser_route_link('admin.setting.notification.global'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Global Template', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php viser_menu_active('admin.setting.notification.email'); ?> ">
                                <a href="<?php echo viser_route_link('admin.setting.notification.email'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Email Setting', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php viser_menu_active('admin.setting.notification.sms'); ?> ">
                                <a href="<?php echo viser_route_link('admin.setting.notification.sms'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('SMS Setting', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php viser_menu_active('admin.setting.notification.telegram'); ?> ">
                                <a href="<?php echo viser_route_link('admin.setting.notification.telegram'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Telegram Setting', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php viser_menu_active('admin.setting.notification.templates'); ?> ">
                                <a href="<?php echo viser_route_link('admin.setting.notification.templates'); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php esc_html_e('Notification Templates', VISERLAB_PLUGIN_NAME); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item  <?php viser_menu_active('admin.request.report') ?>">
                    <a href="<?php echo viser_route_link('admin.request.report') ?>" class="nav-link" data-default-url="<?php viser_route_link('admin.request.report') ?>">
                        <i class="menu-icon las la-bug"></i>
                        <span class="menu-title"><?php esc_html_e('Report & Request', VISERLAB_PLUGIN_NAME); ?></span>
                    </a>
                </li>

            </ul>
            <div class="text-center mb-5 text-uppercase">
                <span class="text--primary"><?php esc_html_e(viser_system_details()['name'], VISERLAB_PLUGIN_NAME) ?></span>
                <span class="text--success"><?php esc_html_e('V', VISERLAB_ROOT) ?><?php esc_html_e(viser_system_details()['version'], VISERLAB_PLUGIN_NAME) ?></span>
            </div>
        </div>
    </div>
    <div class="back-dashboard__buttons">
        <a href="<?php echo admin_url(); ?>" class="back-dashboard__button btn btn--info"> 
            <i class="fab fa-wordpress"></i> <?php esc_html_e('WP Admin', VISERLAB_PLUGIN_NAME);?>
        </a>
        <a href="<?php echo viser_route_link('user.home') ?>" class="back-dashboard__button btn btn--info">
            <img src="<?php echo viser_get_image(viser_file_path('logoIcon').'/favicon.png'); ?>" alt="" style='width:16px;' class="rounded-circle"> 
            <?php esc_html_e('User Panel', VISERLAB_PLUGIN_NAME);?>
        </a>                                        
    </div>
</div>
<!-- sidebar end -->


<script>
    jQuery(document).ready(function($) {
        "use strict";
        if ($('li').hasClass('active')) {
            $('#sidebar__menuWrapper').animate({
                scrollTop: eval($(".active").offset().top - 320)
            }, 500);
        }
    });
</script>