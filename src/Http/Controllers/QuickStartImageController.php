<?php

namespace DaltonMcCleery\LaravelQuickStart\Http\Controllers;

use Illuminate\Support\Str;
use League\Glide\ServerFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;

class QuickStartImageController extends Controller
{
	public function show(Filesystem $filesystem, $path)
	{
		$validImageTypes = [
			'jpg', 'JPG',
			'jpeg', 'JPEG',
			'png', 'PNG',
			'gif', 'GIF',
			'webp', 'WebP', 'WEBP',
		];

		if (! Storage::exists($path) || ! Str::contains($path, $validImageTypes)) {
			abort(404, 'Image Not Found');
		}

		$server = ServerFactory::create([
			'response' => new LaravelResponseFactory(app('request')),
			'source' => $filesystem->getDriver(),
			'cache' => $filesystem->getDriver(),
			'cache_path_prefix' => '.cache',
			'driver' => config('quick_start.image_driver', 'imagick'),
			'base_url' => 'img',
			'max_image_size' => 2000 * 2000,
		]);

		return $server->getImageResponse($path, request()->all());
	}
}