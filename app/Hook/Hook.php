<?php

namespace Viserlab\Hook;

use Viserlab\Controllers\ActivationController;
use Viserlab\Controllers\CronController;
use Viserlab\Hook\AdminMenu;
use Viserlab\Lib\VerifiedPlugin;

class Hook{

    public function init()
    {
        add_action('admin_menu', [new AdminMenu,'menuSetting']);

        add_action('init',[new ExecuteRouter,'execute']);
        add_filter('template_include', [new ExecuteRouter,'includeTemplate'], 1000, 1);
        add_action('query_vars',[new ExecuteRouter,'setQueryVar']);

        $loadAssets = new LoadAssets('admin');
        add_action('admin_enqueue_scripts',[$loadAssets,'enqueueScripts']);
        add_action('admin_enqueue_scripts',[$loadAssets,'enqueueStyles']);

        $loadAssets = new LoadAssets('public');
        add_action('wp_enqueue_scripts',[$loadAssets,'enqueueScripts']);
        add_action('wp_enqueue_scripts',[$loadAssets,'enqueueStyles']);

        if (VerifiedPlugin::check()) {
            $this->authHooks();
        }
        
        add_action('plugin_loaded',function(){
            load_plugin_textdomain(
                VISERLAB_PLUGIN_NAME,
                false,
                dirname(dirname(dirname(plugin_basename(__FILE__)))).'/languages'
            );
        });

        add_action('wp_dashboard_setup',function(){
            $widget = new Widget();
            $widget->loadWidget();
        });
        
        add_filter('admin_body_class', function($classes){
            if(isset($_GET['page']) && $_GET['page'] == VISERLAB_PLUGIN_NAME) {
                $classes .= ' vl-admin';
            }
            return $classes;
        });

        add_action('init', function(){
            ob_start();
        });

        add_filter('redirect_canonical',function ($redirect_url){
            if (is_404()) {
                return false;
            }
            return $redirect_url;
        });

        //corn-job
        wp_schedule_event(time(), 'every_minute', 'signal_cron');
        add_action('signal_cron', function () {
            $cronController = new CronController;
            $cronController->cron();
        });

        add_action('wp_login', 'after_login_redirect', 10, 2);

        add_shortcode('signallab_packages', function(){
            ob_start();
                echo '<div class="signallab-package-wrapper">';
                    viser_include('user/packages');
                echo '</div>';
            return ob_get_clean(); 
        });
       
        // add_action('admin_init',[new Demo, 'protectPost']);
        // add_filter('plugin_action_links',[new Demo, 'disablePluginDeactivation'], 10, 4 );

        add_action('admin_init',function(){
            if (!VerifiedPlugin::check()) {
                add_action('admin_notices', function(){
                    $activationUrl = viser_route_link('plugin.activation');
                    echo "<div class='notice notice-error is-dismissible'><p><strong>".__('Please',VISERLAB_PLUGIN_NAME)." <a href='$activationUrl'>".__('activate',VISERLAB_PLUGIN_NAME)."</a> ".__('the '.VISERLAB_PLUGIN_NAME.' Plugin',VISERLAB_PLUGIN_NAME)."</strong></p></div>";
                });
            } 
        });

        add_action('wp_ajax_active-plugin',function(){
            $controller = new ActivationController;
            $controller->activationSubmit();
        });


        add_action('admin_enqueue_scripts', function(){
            wp_enqueue_style( 'global_admin', esc_url(plugin_dir_url('/') .VISERLAB_PLUGIN_NAME.  "/assets/admin/css/global_admin.css"), array(), VISERLAB_PLUGIN_VERSION, 'all' );
        });
    }

    public function authHooks()
    {
        $authorization = new Authorization;
        add_action('after_setup_theme', [$authorization,'removeAdminBar']);
        add_action('admin_init', [$authorization,'redirectHome'], 1);
        add_action('login_init', [$authorization,'restrictWpLogin'], 1);
        add_filter('login_url', [$authorization,'redirectLogin'], 10, 2);
        add_action('wp_login_failed', [$authorization,'authFailed']);
        add_filter('authenticate', [$authorization,'authenticate'], 20, 3);
        add_filter('wp_authenticate_user', [$authorization,'verifyUser'], 1);
        add_action('edit_user_profile', [$authorization,'userProfile']);
        add_action('edit_user_profile_update', [$authorization,'updateUserProfile']);
    }
    
}