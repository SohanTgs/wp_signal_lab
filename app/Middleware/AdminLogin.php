<?php

namespace Viserlab\Middleware;

class AdminLogin{
    public function filterRequest()
    {
        $current_user = wp_get_current_user();
        if(!user_can( $current_user, 'administrator' )){
            viser_redirect(admin_url());
        }
    }
}