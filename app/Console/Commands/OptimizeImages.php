<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tinify\Tinify;

class OptimizeImages extends Command
{

    protected $signature = 'images:optimize';
    protected $description = 'Optimize all images in the media library using TinyPNG';

    public function __construct()
    {
        parent::__construct();
        Tinify::setKey(config('app.TINYPNG_API_KEY'));
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $images = Media::query()->where('mime_type', 'like', 'image/%')
            ->whereNull('optimized_at') // Assuming you have an `optimized_at` column
            ->get();
        if ($images->isEmpty()) {
            $this->info('No unoptimized images found.');
            return 0;
        }
        $this->info('Optimizing images...');

        foreach ($images as $image) {
            $filePath = $image->getPath();
            if (file_exists($filePath)) {

                try {
                    $source =\Tinify\fromFile($filePath);
                    $source->toFile($filePath);
                    // Update the `optimized_at` column to mark the image as optimized
                    $image->update(['optimized_at' => now()]);
                    $this->info("Optimized: {$image->file_name}");
                } catch (\Exception $e) {
                    $this->error("Failed to optimize: {$image->file_name}. Error: {$e->getMessage()}");
                }
            } else {
                $this->warn("File does not exist: {$filePath}");
            }
        }
        $this->info('Image optimization complete.');
        return 0;
    }
}
