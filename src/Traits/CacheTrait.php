<?php

namespace DaltonMcCleery\LaravelQuickStart\Traits;

use Illuminate\Support\Facades\Cache;

/**
 * Trait CacheTrait
 * @package DaltonMcCleery\LaravelQuickStart\Traits
 */
trait CacheTrait
{
	/**
	 * Set a new keyed Cache value with an optional timeout period
	 *
	 * @param $key
	 * @param $data
	 * @param $hours
	 */
	public function setCache($key, $data, $hours = 4) {
		Cache::put($key, $data, now()->addHours($hours));
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
		Cache::forget($key);
	}

	/**
	 * Get a keyed Cache value
	 * If no value found, an optional callback function can be given
	 *
	 * @param $key
	 * @param null $callback
	 * @return mixed|null
	 */
	public function getCache($key, $callback = null) {
		$cache = Cache::get($key);
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
}