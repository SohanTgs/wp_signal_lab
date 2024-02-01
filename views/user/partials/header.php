<div class="header<?php if(is_admin_bar_showing() && current_user_can('administrator')){ ?> mt-4 <?php } ?>">
    <div class="container">
        <div class="header-bottom">
            <div class="header-bottom-area align-items-center">
                <div class="logo">
                    <a href="<?php echo home_url('/'); ?>">
                        <img src="<?php echo viser_get_image(viser_file_path('logoIcon').'/logo.png'); ?>" alt="<?php esc_html_e('Logo', VISERLAB_PLUGIN_NAME); ?>">
                    </a>
                </div>
                <ul class="menu ms-auto">
                    <li>
                        <a href="<?php echo viser_route_link('user.home'); ?>">
                            <?php esc_html_e('Dashboard', VISERLAB_PLUGIN_NAME); ?>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><?php esc_html_e('Deposit', VISERLAB_PLUGIN_NAME); ?></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo viser_route_link('user.deposit.index'); ?>">
                                    <?php esc_html_e('Deposit Now', VISERLAB_PLUGIN_NAME); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo viser_route_link('user.deposit.history'); ?>">
                                    <?php esc_html_e('Deposit History', VISERLAB_PLUGIN_NAME); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo viser_route_link('user.packages'); ?>">
                            <?php esc_html_e('Packages', VISERLAB_PLUGIN_NAME); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo viser_route_link('user.signals'); ?>">
                            <?php esc_html_e('Signals', VISERLAB_PLUGIN_NAME); ?>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><?php esc_html_e('Support', VISERLAB_PLUGIN_NAME); ?></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo viser_route_link('user.ticket.create'); ?>">
                                    <?php esc_html_e('New Ticket', VISERLAB_PLUGIN_NAME); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo viser_route_link('user.ticket.index'); ?>">
                                    <?php esc_html_e('My Tickets', VISERLAB_PLUGIN_NAME); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)"><?php esc_html_e('Account', VISERLAB_PLUGIN_NAME); ?></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="<?php echo viser_route_link('user.profile.setting'); ?>">
                                    <?php esc_html_e('Profile', VISERLAB_PLUGIN_NAME); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo viser_route_link('user.change.password'); ?>">
                                    <?php esc_html_e('Change Password', VISERLAB_PLUGIN_NAME); ?>
                                </a>
                            </li>
                        
                            <li>
                                <a href="<?php echo viser_route_link('user.transaction.index'); ?>">
                                    <?php esc_html_e('Transactions', VISERLAB_PLUGIN_NAME); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo viser_route_link('user.logout'); ?>">
                                    <?php esc_html_e('Logout', VISERLAB_PLUGIN_NAME); ?>    
                                </a>
                            </li>
                        </ul>
                    </li>

                    <?php if(current_user_can('administrator')) { ?>
                        <li class="ms-xl-4 ms-lg-2 d-flex align-items-center justify-content-between mt-lg-0 mt-2">
                            <a href="<?php echo esc_url(admin_url()); ?>" class="btn btn--base btn--sm rounded-5 text-white">
                            <i class="la la-wordpress"></i>
                                <?php esc_html_e('WP Admin', VISERLAB_PLUGIN_NAME); ?>    
                            </a>
                        </li>
                    <?php }else{ ?>
                        <li class="ms-xl-4 ms-lg-2 d-flex align-items-center justify-content-between mt-lg-0 mt-2">
                            <a href="<?php echo viser_route_link('user.logout'); ?>" class="btn btn--base btn--sm rounded-5 text-white">
                                <?php esc_html_e('Logout', VISERLAB_PLUGIN_NAME); ?>    
                            </a>
                        </li>
                    <?php } ?>

                </ul>
                <div class="header-trigger-wrapper d-flex d-lg-none align-items-center">
                    <div class="header-trigger">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
