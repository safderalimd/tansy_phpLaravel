<?php

namespace app\Http\Middleware;

use Closure;
use Menu;

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
        $this->init();

        $this->generateSideBar($this->modules);

        return $next($request);
    }

    private function init()
    {
        $this->menuInfo = session('dbMenuInfo');
        $this->modules = $this->getModules();
    }

    private function generateSideBar($modules)
    {
        $menuList = collect($this->menuInfo);

        $sideMenu = Menu::make('sidebar', function ($menu) use ($modules) {
            foreach ($modules as $module) {
                $menu->add(studly_case($module), '#');
            }
        });

        foreach ($menuList->unique('link_group') as $group) {
            $module = camel_case($group['module_name']);
            $sideMenu->$module->add($group['link_group']);
        }

        foreach ($this->menuInfo as $item) {
            $module = camel_case($item['module_name']);
            $group = camel_case($item['link_group']);
            $url = "cabinet/" . $this->link($item['screen_name']);
            $sideMenu->$group->add($item['link_name'], $url);
        }

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
}
