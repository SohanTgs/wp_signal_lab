<?php

namespace Viserlab\BackOffice;

use Viserlab\BackOffice\Router\Router;
use Viserlab\Controllers\Admin\AdminController;
use Viserlab\Hook\ExecuteRouter;

class AdminRequestHandler
{
    public function handle()
    {
        if (isset(viser_request()->page) && viser_request()->page == VISERLAB_PLUGIN_NAME) {
            if (!isset(viser_request()->module)) {
                $handler = new MiddlewareHandler();
                $handler->filterGlobalMiddleware();

                $routes = Router::$routes;
                foreach ($routes as $routeKey => $routeValue) {
                    foreach ($routeValue as $routerKey => $router) {
                        if (array_key_exists('query_string',$router) && $router['query_string'] == strtolower(VISERLAB_PLUGIN_NAME)) {
                            if (array_key_exists('middleware', $router)) {
                                $middleware = $router['middleware'];
                                $handler->handle($middleware);
                            }
                        }
                    }
                }


                $controller = new AdminController;
                $method = 'dashboard';
                $controller->$method();
            } else {
                $getActions = ExecuteRouter::executeAdminRouter();
                if (!empty($getActions)) {
                    $controller = new $getActions[0];
                    $method = $getActions[1];
                    $controller->$method();
                } else {
                    throw new \Exception("Something went wrong");
                }
            }
        }
    }
}
