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

class ProcessResizeFormDetailImage extends Model
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $form_detail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SalesFormDetail $form_detail)
    {
        $this->form_detail = $form_detail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit','256M');

        Log::info('START: ' . memory_get_usage());
        $path = $this->form_detail->foto;

        $file = Storage::disk('public')->get($path);
        $image = Image::make($file)->resize(480, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        // save to original file
        Storage::disk('public')->put($path, $image->encode());
        Log::info('FINISH:' .memory_get_usage());
    }
}
