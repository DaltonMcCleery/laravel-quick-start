<?php

namespace DaltonMcCleery\LaravelQuickStart\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Filesystem\Filesystem;

/**
 * Trait CacheTrait
 * @package DaltonMcCleery\LaravelQuickStart\Traits
 */
trait CacheTrait
{
	/**
	 * Set a new keyed Cache value with an optional timeout period
	 *
	 * @param string $key
	 * @param $data
	 * @param int $hours
	 * @param string|array|null $tags
	 */
	public function setCache(string $key, $data, int $hours = 4, string|array $tags = null) {
		if ($tags) {
			Cache::tags($tags)->put($key, $data, now()->addHours($hours));
		} else {
			Cache::put($key, $data, now()->addHours($hours));
		}
	}

	/**
	 * Get a keyed Cache value
	 * If no value found, an optional callback function can be given
	 *
	 * @param string $key
	 * @param null $callback
	 * @param string|array|null $tags
	 * @return mixed|null
	 */
	public function getCache(string $key, $callback = null, string|array $tags = null) {
		$cache = Cache::get($key);

		if ($tags) {
			$cache = Cache::tags($tags)->get($key);
		}

		if ($cache) {
			return $cache;
		} else {
			if ($callback) {
				return $callback();
			} else {
				return null;
			}
		}
	}

	/**
	 * Removes all cached resources
	 */
	public function clearAllCache() {
		Cache::flush();
	}

	/**
	 * Removes all cached resources
	 */
	public static function clearAllCacheStatically() {
		(new self)->clearAllCache();
	}

	/**
	 * Removes a resource from Cache from a given key
	 *
	 * @param $key
	 */
	public function clearCache($key) {
		Cache::forget($key);
	}

	/**
	 * Removes a resource from Cache from a given key
	 *
	 * @param $key
	 */
	public static function clearCacheStatically($key) {
		(new self)->clearCache($key);
	}

	/**
	 * Removes a resource from Cache from given tags
	 *
	 * @param string|array $tags
	 */
	public function clearTagCache($tags) {
		Cache::tags($tags)->flush();
	}

	/**
	 * Removes a resource from Cache from given tags
	 *
	 * @param string|array $tags
	 */
	public static function clearTagCacheStatically($tags) {
		(new self)->clearTagCache($tags);
	}
}
