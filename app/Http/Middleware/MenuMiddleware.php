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
     * Set modules for links that don't appear in the sidebar.
     *
     * @var array
     */
    private $defaultModules = [
        // todo: add links here
    ];

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

        $this->generateTopMenubar($this->modules);
        $this->generateSideBar($this->modules);

        return $next($request);
    }

    private function init()
    {
        $this->menuInfo = session('dbMenuInfo');
        $this->modules = $this->getModules();
        $this->setCurrentModule();
    }

    private function generateTopMenubar($modules)
    {
        Menu::make('topbar', function ($menu) use ($modules) {
            foreach ($modules as $module) {
                $menu->add(ucwords($module), ['route' => ['cabinet', 'module' => $module]]);
            }

            $menu->add('Logout', 'cabinet/logout');
        });
    }

    private function generateSideBar($modules)
    {
        $menuList = collect($this->menuInfo);

        $sideMenu = Menu::make('sidebar', function ($menu) use ($modules) {
            foreach ($modules as $module) {
                $menu->add($module, '#');
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

        return $sideMenu;
    }

    private function setCurrentModule()
    {
        $currentModule = '';

        foreach ($this->modules as $module) {
            if ($this->isSamePath($module)) {
                $currentModule = $module;
                break;
            }
        }

        if (empty($currentModule)) {
            foreach ($this->menuInfo as $item) {
                if ($this->isSamePath($item['screen_name'])) {
                    $currentModule = $this->link($item['module_name']);
                    break;
                }
            }
        }

        if (empty($currentModule)) {
            $currentModule = 'admin';
        }

        \View::share('currentModule', $currentModule);
    }

    private function getModules()
    {
        return array_unique(array_column($this->menuInfo, 'module_name', 'module_id'));
    }

    private function isSamePath($path)
    {
        $path = 'cabinet/'.$this->link($path);

        if (\Request::path() == $path || \Request::is($path.'/*')) {
            return true;
        }

        return false;
    }

    private function link($name) {
        $name = strtolower($name);
        return str_replace(' ', '-', $name);
    }
}
