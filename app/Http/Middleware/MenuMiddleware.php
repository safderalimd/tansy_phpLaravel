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

    private function init()
    {
        $this->menuInfo = session('dbMenuInfo');
    }

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->init();

        $this->generateTopBar($this->getModules());
        $this->generaSideBar();

        return $next($request);
    }

    /**
     * @return array
     */
    private function getModules()
    {
        return array_unique(array_column($this->menuInfo, 'module_name', 'module_id'));
    }

    /**
     * @param array $modules
     * @return \Lavary\Menu\Builder
     */
    private function generateTopBar(array $modules)
    {
        $topMenu = Menu::make('topbar', function ($menu) use ($modules) {
            foreach ($modules as $module) {
                $menu->add($module, ['route' => ['cabinet', 'module' => $module]]);
            }

            $menu->add('logout', 'cabinet/logout');
        });

        return $topMenu;
    }


    /**
     * @return \Lavary\Menu\Builder
     */
    private function generaSideBar()
    {
        $menuInfoCollection = collect($this->menuInfo);

        $modules = $this->getModules();

        $sideMenu = Menu::make('sidebar', function ($menu) use ($modules) {
            foreach ($modules as $module) {
                $menu->add($module, '#');
            }
        });

        foreach ($menuInfoCollection->unique('link_group') as $group) {
            $module = camel_case($group['module_name']);
            $sideMenu->$module->add($group['link_group']);
        }

        foreach ($this->menuInfo as $item) {
            $module = camel_case($item['module_name']);
            $group = camel_case($item['link_group']);
            $sideMenu->$group->add($item['link_name'], "cabinet/" . camel_case($item['screen_name']));
        }

        return $sideMenu;
    }
}