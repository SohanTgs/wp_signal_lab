<?php

namespace Viserlab\Includes;

class Activator
{
    public function activate()
    {          
        // ALTER TABLE `wp_users` CHANGE `user_registered` `user_registered` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
        // ALTER TABLE `wp_users` ADD `package_id` INT(11) NOT NULL DEFAULT '0' AFTER `user_status`, ADD `validity` DATETIME NULL AFTER `package_id`;
        
        // ALTER TABLE wp_viser_notification_templates add COLUMN telegram_status tinyint(1) DEFAULT 1 AFTER sms_status
        // ALTER TABLE wp_viser_notification_templates add COLUMN telegram_body text(65000) AFTER sms_body
 
        // activation code will go here
    }

    public function deactivate()
    {
        // deactivation code will go here
    }
}
