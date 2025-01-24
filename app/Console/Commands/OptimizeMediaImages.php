<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class OptimizeMediaImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:optimize-images';
    protected $description = 'Optimize all unoptimized images in the media table';
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Create the optimizer chain
        $optimizerChain = OptimizerChainFactory::create();

        // Fetch all media items with images that need optimization
        $mediaItems = Media::query()->where('mime_type', 'like', 'image/%')
            ->whereNull('optimized_at') // Assuming you have an `optimized_at` column
            ->get();

        if ($mediaItems->isEmpty()) {
            $this->info('No unoptimized images found.');
            return 0;
        }

        $this->info('Optimizing images...');

        foreach ($mediaItems as $media) {
            $filePath = $media->getPath();

            if (file_exists($filePath)) {
                try {
                    // Optimize the image
                    $optimizerChain->optimize($filePath);

                    // Update the `optimized_at` column to mark the image as optimized
                    $media->update(['optimized_at' => now()]);

                    $this->info("Optimized: {$media->file_name}");

                } catch (\Exception $e) {
                    $this->error("Failed to optimize: {$media->file_name}. Error: {$e->getMessage()}");
                }
            } else {
                $this->warn("File does not exist: {$filePath}");
            }
        }

        $this->info('Image optimization complete.');

        return 0;
    }
}
