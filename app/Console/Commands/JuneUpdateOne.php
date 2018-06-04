<?php

namespace App\Console\Commands;

use App\Model\Page;
use Illuminate\Console\Command;
use App\Plugins\Pages\Model\PageTypes;
use App\Plugins\Pages\Model\PageOptions;
use App\Classes\Repositories\PageRepository;

class JuneUpdateOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upgrade:june_one';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrades to the new binary bitwise settings.';

    /**
     * Pages Repository.
     *
     * @return PageRepository
     */
    public $pages;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PageRepository $pages)
    {
        parent::__construct();

        $this->pages = $pages;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Page $page */
        foreach ($this->pages->all() as $page) {
            if ($page->slug == 'index') {
                $page->identifier = 'index';
            }

            if (! $page->editable && ! $page->special) {
                $page->type = (PageTypes::TYPE_FRAMEWORK | PageTypes::TYPE_STANDARD);
                $page->option = PageOptions::OPTION_PUBLIC | PageOptions::OPTION_SITEMAP;
            } elseif ($page->plugin) {
                $page->type = PageTypes::TYPE_PLUGIN;
                $page->option = PageOptions::OPTION_DEFAULT;
            } elseif ($page->identifier == 'newsletter.success') {
                $page->type = PageTypes::TYPE_PLUGIN;
                $page->option = PageOptions::OPTION_PUBLIC;
            } else {
                $page->type = PageTypes::TYPE_STANDARD;
                if ($page->enabled) {
                    $page->option = PageOptions::OPTION_PUBLIC | PageOptions::OPTION_SITEMAP;
                }
            }

            $this->error($page->seo_title);

            $this->info('Type: '.$page->type.' Option: '.$page->option);

            $page->save();
        }
    }
}
