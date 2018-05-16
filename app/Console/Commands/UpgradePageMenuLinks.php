<?php

namespace App\Console\Commands;

use App\Model\Link;
use App\Model\Menu;
use App\Model\Page;
use Illuminate\Console\Command;
use App\Classes\Repositories\MenuRepository;
use App\Classes\Repositories\PageRepository;

class UpgradePageMenuLinks extends Command
{
    private $menus;

    private $pages;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade:page_links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade for version 5.0.1';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PageRepository $pages, MenuRepository $menus)
    {
        parent::__construct();

        $this->pages = $pages;

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
            $link = new Link;

            /** @var Page $page */
            $page = $this->pages->whereID($menu->page_id);

            if ($menu->getAttribute('parent_id')) {
                $prefix = str_slug($menu->parent->title);
            } else {
                $prefix = '';
            }

            $page->setAttribute('prefix', $prefix)->save();

            $link->model($menu, $page)->save();

            $this->info($menu->title.' => '.$page->getAttribute('seo_title').' ('.$page->getAttribute('prefix').'/'.$page->getAttribute('slug').')');
        }
    }
}
