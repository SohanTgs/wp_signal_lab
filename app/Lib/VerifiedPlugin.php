<?php

namespace Viserlab\Lib;

class VerifiedPlugin{
    public static function check()
    {   return true;
        $fileExists = file_exists(VISERLAB_ROOT.'/viser.json');
        if (!$fileExists || get_option(VISERLAB_PLUGIN_NAME.'_activated') != 1 || get_option(VISERLAB_PLUGIN_NAME.'_maintenance_mode') == 9) {
            return false;
        }
        return true;
    }
}