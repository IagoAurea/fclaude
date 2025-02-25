<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Aws\S3\S3Client;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use Illuminate\Filesystem\FilesystemAdapter;

class MinioStorageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('minio', function ($app, $config) {
            $client = new S3Client([
                'credentials' => [
                    'key'    => $config["key"],
                    'secret' => $config["secret"]
                ],
                'region'      => $config["region"],
                'version'     => "latest",
                'bucket_endpoint' => false,
                'use_path_style_endpoint' => true,
                'endpoint'    => $config["endpoint"],
            ]);

            $adapter =  new AwsS3V3Adapter($client, $config["bucket"]);

            return new FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }
}
