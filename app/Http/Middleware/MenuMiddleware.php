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

        $this->setCurrentModule();
    }

    public function setCurrentModule()
    {
        $currentModule = '';

        $modules = $this->getModules();
        foreach ($modules as $module) {
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

    public function isSamePath($path)
    {
        $path = 'cabinet/'.$this->link($path);

        if (\Request::path() == $path || \Request::is($path.'/*')) {
            return true;
        }

        return false;
    }

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->init();

        $this->generateTopMenubar($this->getModules());
        $this->generateSideBar();

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
    private function generateTopMenubar(array $modules)
    {
        $topMenu = Menu::make('topbar', function ($menu) use ($modules) {
            foreach ($modules as $module) {
                $menu->add(ucwords($module), ['route' => ['cabinet', 'module' => $module]]);
            }

            $menu->add('Logout', 'cabinet/logout');
        });

        return $topMenu;
    }

    /**
     * @return \Lavary\Menu\Builder
     */
    private function generateSideBar()
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
            $url = "cabinet/" . $this->link($item['screen_name']);
            $sideMenu->$group->add($item['link_name'], $url);
        }

        return $sideMenu;
    }

    public function link($name) {
        $name = strtolower($name);
        return str_replace(' ', '-', $name);
    }
}
