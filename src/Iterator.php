<?php 

namespace Foreacher;
use Foreacher\Limit;
use Foreacher\Cycle;
use Foreacher\Multi;
use Foreacher\Filter;
use Foreacher\Regex;

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

	/**
	 * Limits the loop to the first N elements of a named array.
	 *
	 * @param  string  $id  Key of the stored array.
	 * @param  int  $number  Number of elements to loop over, starting in the first element.
	 * @param  callable  $callable  Function to apply on the looped items.
	 *
	 * @since  1.0.0
	 * @uses  Foreacher\Limit
	 * @return  void()
	 */
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

	/**
	 * Limits the loop to the last N elements of a named array.
	 *
	 * @param  string  $id  Key of the stored array.
	 * @param  int  $number  Number of elements to loop over, starting from the Nth element before the last.
	 * @param  callable  $callable  Function to apply on the looped items.
	 *
	 * @since  1.0.0
	 * @uses  Foreacher\Limit
	 * @return  void()
	 */
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

	/**
	 * Limits the loop to all elements starting from the Nth element.
	 *
	 * @param  string  $id  Key of the stored array.
	 * @param  int  $number  Position to starting the loop from in the array.
	 * @param  callable  $callable  Function to apply on the looped items.
	 *
	 * @since  1.0.0
	 * @uses  Foreacher\Limit
	 * @return  void()
	 */
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

	/**
	 * Performs the loop a certain number of times or cycles.
	 *
	 * @param  string  $id  Key of the stored array.
	 * @param  float  $number  Number of cycles or revolutions.
	 * @param  callable  $callable  Function to apply on the looped items.
	 *
	 * @since  1.0.0
	 * @uses  Foreacher\Cycle
	 * @return  void()
	 */
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

	/**
	 * Loops all stored arrays using the same given callback.
	 *
	 * @param  callable  $callable  Function to apply on the looped items.
	 *
	 * @since  1.0.0
	 * @uses  Foreacher\Multi
	 * @return  void()
	 */
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

	/**
	 * Exclude or filters elements from the loop by value.
	 *
	 * @param  string  $id  Key of the stored array.
	 * @param  mixed  $values  Array, integer or string representing the values to be filtered.
	 * @param  callable  $callable  Function to apply on the looped items.
	 *
	 * @since  1.1.0
	 * @uses  Foreacher\Filter
	 * @return  void()
	 */
	public function filterValues(string $id, mixed $values, callable $callable, array $args = null)
	{
		$filter = new Filter($this->arrays[$id], $values);

		foreach ($filter as $item) {

			call_user_func($callable, $item, $args);

			if(is_array($callable)) {
				foreach($callable as $function) {
					
					call_user_func($function, $item, $args);
				}
			}
		}

	}

	/**
	 * Exclude or filters elements from the loop by keys.
	 *
	 * @param  string  $id  Key of the stored array.
	 * @param  mixed  $keys  Array, integer or string representing the keys to be filtered.
	 * @param  callable  $callable  Function to apply on the looped items.
	 *
	 * @since  1.1.0
	 * @uses  Foreacher\Filter
	 * @return  void()
	 */
	public function filterKeys(string $id, mixed $keys, callable $callable, array $args = null)
	{
		$filter = new Filter($this->arrays[$id], null, $keys);

		foreach ($filter as $item) {

			call_user_func($callable, $item, $args);

			if(is_array($callable)) {
				foreach($callable as $function) {
					
					call_user_func($function, $item, $args);
				}
			}
		}
	}

	/**
	 * Limits the loop to all elements that matches the submitted regex pattern.
	 *
	 * @param  string  $id  Key of the stored array.
	 * @param  string  $regex  Regex expression to find matches.
	 * @param  callable  $callable  Function to apply on the looped items.
	 *
	 * @since  1.2.0
	 * @uses  Foreacher\Regex
	 * @return  void()
	 */
	public function regexMatch(string $id, string $regex, callable $callable, array $args = null)
	{
		$match = new Regex($this->arrays[$id], $regex);

		foreach ($match as $item) {

			call_user_func($callable, $item, $args);

			if(is_array($callable)) {
				foreach($callable as $function) {
					
					call_user_func($function, $item, $args);
				}
			}
		}
	}
}