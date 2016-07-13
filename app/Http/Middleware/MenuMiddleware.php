<?php

namespace app\Http\Middleware;

use Closure;
use Menu;
use Session;

class MenuMiddleware
{
    /**
     * @var array;
     */
    private $menuInfo;

    /**
     * The list of modules.
     *
     * @var array
     */
    private $modules;

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->menuInfo = session('dbMenuInfo');

        $this->generateSideBar();

        return $next($request);
    }

    private function generateSideBar()
    {
        $this->orderSidebarLinks();

        $menuList = collect($this->menuInfo);
        $modules = $this->getModules();

        $sideMenu = Menu::make('sidebar', function ($menu) use ($modules) {
            foreach ($modules as $module) {
                $menu->add(studly_case($module), '#');
            }
        });

        $siteUrls = [];
        foreach ($this->menuInfo as $item) {
            $module = camel_case($item['module_name']);
            $url = "cabinet/" . $this->link($item['screen_name']);
            $siteUrls[] = [
                'url'         => '/' . $url,
                'screen_id'   => $item['screen_id'],
                'screen_name' => $item['screen_name'],
            ];
            $sideMenu->$module->add($item['link_name'], $url);
        }

        Session::put('siteUrls', $siteUrls);

        $sideMenu->add('Logout', 'cabinet/logout');

        return $sideMenu;
    }

    private function getModules()
    {
        return array_unique(array_column($this->menuInfo, 'module_name', 'module_id'));
    }

    private function link($name) {
        $name = strtolower($name);
        return str_replace(' ', '-', $name);
    }

    public function orderSidebarLinks()
    {
        usort($this->menuInfo, function($a, $b) {
            if ($a['module_id'] == $b['module_id']) {
                if ($a['link_group_sequence'] == $b['link_group_sequence']) {
                    return $a['link_name_sequence'] > $b['link_name_sequence'];
                }
                return $a['link_group_sequence'] > $b['link_group_sequence'];
            }
            return $a['module_id'] > $b['module_id'];
        });
    }
}
