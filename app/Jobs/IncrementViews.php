<?php

namespace App\Jobs;

use App\Model\Page;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;

class IncrementViews
{
    /*
     * Class traits.
     */
    use Dispatchable, SerializesModels;

    /**
     * @param Model $model
     */
    private $model;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->model->increment('views');

        $this->model->save();
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed($exception)
    {
        // Send user notification of failure, etc...
    }
}
