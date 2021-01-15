<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SalesFormDetail;
use Storage;
use Image;
use Log;

class ProcessResizeFormImage extends Model
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sales_form;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SalesForm $sales_form)
    {
        $this->sales_form = $sales_form;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit','512M');

        Log::info('START: ' . memory_get_usage());
        $path = $this->sales_form->foto;

        $file = Storage::disk('public')->get($path);
        $image = Image::make($file)->resize(480, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        // save to original file
        Storage::disk('public')->put($path, $image->encode());
        Log::info('FINISH:' .memory_get_usage());
    }
}
