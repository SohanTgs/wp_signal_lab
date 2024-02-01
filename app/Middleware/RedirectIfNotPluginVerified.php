<?php

namespace Viserlab\Middleware;

use Viserlab\Lib\VerifiedPlugin;

class RedirectIfNotPluginVerified
{
    public function filterRequest()
    {
        if (!VerifiedPlugin::check()) {
            viser_redirect(home_url(VISERLAB_PLUGIN_NAME.'-activation'));
        }
    }
}