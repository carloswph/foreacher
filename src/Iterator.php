<?php 

namespace Foreacher;
use Foreacher\Limit;
use Foreacher\Cycle;
use Foreacher\Multi;

/**
 * Transform and store arrays as ArrayIterator objects, allowing
 * more complex iterations and operations with data.
 *
 * @since  1.0.0
 * @author  WP Helpers | Carlos Matos
 * @uses  \ArrayIterator
 */
class Iterator
{
	protected $arrays = [];

	/**
	 * Class constructor
	 *
	 * @since  1.0.0
	 * @param  array  $arrays  Array of IDs and data from sequences and arrays supplied.
	 */
	public function __construct($arrays)
	{
		foreach ($arrays as $key => $data) {
			$this->arrays[$key] = new \ArrayIterator($data);
		}
	}

	/**
	 * Pushes new arrays with IDs to the class storage.
	 *
	 * @since  1.0.0
	 * @param  string  $id  ID of the array pushed.
	 * @param  array  $data  Array data.
	 */
	public function push(string $id, array $data) 
	{
		$this->arrays[$id] = new \ArrayIterator($data);
	}

	public function limitFirst(string $id, int $number, callable $callable, array $args = null)
	{
		foreach (new Limit($this->arrays[$id], 0, $number) as $item) {

			call_user_func($callable, $item, $args);

			if(is_array($callable)) {
				foreach($callable as $function) {

					call_user_func($function, $item, $args);
				}
			}
		}
	}

	public function limitLast(string $id, int $number, callable $callable, array $args = null)
	{
		foreach (new Limit($this->arrays[$id], count($this->arrays[$id]) - $number) as $item) {
			
			call_user_func($callable, $item, $args);

			if(is_array($callable)) {
				foreach($callable as $function) {
					
					call_user_func($function, $item, $args);
				}
			}
		}
	}

	public function limitFrom(string $id, int $number, callable $callable, array $args = null)
	{
		foreach (new Limit($this->arrays[$id], $number) as $item) {
			
			call_user_func($callable, $item, $args);

			if(is_array($callable)) {
				foreach($callable as $function) {
					
					call_user_func($function, $item, $args);
				}
			}
		}
	}

	public function looping(string $id, float $number, callable $callable, array $args = null)
	{
		$cycle = new Cycle($this->arrays[$id]);

		foreach (new Limit($cycle, 0, $number * count($this->arrays[$id])) as $item) {
			
			call_user_func($callable, $item, $args);

			if(is_array($callable)) {
				foreach($callable as $function) {
					
					call_user_func($function, $item, $args);
				}
			}
		}
	}

	public function loopAll(callable $callable, array $args = null)
	{
		$multiple = new Multi(Multi::MIT_NEED_ANY|Multi::MIT_KEYS_ASSOC);

		foreach ($this->arrays as $key => $array) {
			
			$multiple->attachIterator($array, $key);
		}

		foreach ($multiple as $item) {
			
			call_user_func($callable, $item, $args);
		}
	}
}