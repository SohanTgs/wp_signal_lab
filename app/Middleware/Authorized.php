<?php

namespace Viserlab\Middleware;

class Authorized{
    public function filterRequest()
    {
        if (is_user_logged_in()) {
            viser_redirect(home_url());
            exit;
        }
    }
}