<?php

namespace App\Console\Commands;

use App\Model\Menu;
use App\Model\Page;
use Illuminate\Console\Command;
use App\Classes\PageRouteBuilder;
use App\Classes\Repositories\MenuRepository;

class GeneratePageRoutes extends Command
{
    /**
     * @var MenuRepository
     */
    private $menus;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page.routes.generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the page routes based on the linked menus.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MenuRepository $menus)
    {
        parent::__construct();

        $this->menus = $menus;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Menu $menu */
        foreach ($this->menus->all() as $menu) {
            PageRouteBuilder::link($menu->page, $menu);

            $this->info("{$menu->title} was linked to {$menu->page->slug}");
        }

        return true;
    }
}
