<?php

namespace App;

use Nette\Application\IRouter;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;

class RouterFactory
{
    /**
     * @return IRouter
     */
    public static function createRouter()
    {
        $router = new RouteList();

        /*
         * Admin router
         */
        $admin = new RouteList('Admin');

        $admin[] = new Route('admin/prihlasit', 'Sign:in');

        $admin[] = new Route('admin/odhlasit', 'Sign:out');

        $admin[] = new Route('admin/zapomenute-heslo', 'Sign:forgottenPassword');

        $admin[] = new Route('admin/<presenter>/<action>[/<id>]', 'Homepage:default');

        $router[] = $admin;

        /*
         * Front router
         */
        $front = new RouteList('Front');
        
        $front[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

        $router[] = $front;

        return $router;
    }
}
