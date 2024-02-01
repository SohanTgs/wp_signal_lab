<?php

namespace Viserlab\Hook;

use Viserlab\BackOffice\AdminRequestHandler;

class AdminMenu{

    public function menuSetting()
    {
        add_menu_page(
            __('Viserlab'),
            __('Viserlab',VISERLAB_PLUGIN_NAME ),
            'manage_options',
            viser_route('admin.viserlab')->query_string,
            [new AdminRequestHandler(),'handle'],
            'dashicons-admin-settings',
           2
        );
    }
}