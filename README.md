# Foreacher

Dealing with arrays and data can be consuming in terms of resources and sometimes troublesome. PHP natively offer a serie of classes that, from converting arrays in objects, allow us to perform a number of advanced queries and loops on data. This library aims to simplify the process of using classes like ArrayIterator, InfiniteIterator, RegexIterator and so on, providing a comprehensive and friendly way to use them and apply functions and methods to their results.

# Starting

The class Iterator is the heart of this library. It stores all arrays under keys, which can be lately used to perform operations and loops with their data. The remaining classes extend those from PHP, in order to support the Iterator class methods. So, first and foremost, you can start by providing some arrays and creating a new instance of Iterator.

```php
use Foreacher\Iterator;

require __DIR__ . '/vendor/autoload.php';

$entries =[
	'1' => [1, 3, 5, 6, 7, 11, 15, 24, 34, 56, 66, 77, 124],
	'2' => [3, 455, 5, 89, 72, 2434, 1, 1233, 4]
];

$iterator = new Iterator($entries);
```
Once the arrays are stored, you can start performing operations with them individually, without changing or modifying the initial data, which remains protected under the property $arrays. Also, the class has an additional method push($id, $data) that can be used anytime to add new named arrays to the pool.

## Limiting loops

First utility of this class involves the possibility of limiting the loops to part of the named array. That means you can loop in an array starting from the third value, for instance. Also, you can do the opposite: just loop over the last three elements. Finally, one can also loop just starting from a given element.

What about the operations to be applied to each of the looped elements. Well, of course you can provide a callable function when determining the limits of your loop. So let's see an example:

```php
function echoR($item)
{
	echo $item . PHP_EOL;
	echo $item + 4 . PHP_EOL;
}

$iterator->limitFirst('1', 4, 'echoR');

// Returns: 1 5 3 7 5 9 6 10

$iterator->limitLast('1', 4, 'echoR');

// Returns: 56 60 66 70 77 81 124 128

$iterator->limitFrom('1', 4, 'echoR');

// Returns: 7 11 11 15 15 19 24 28 34 38 56 60 66 70 77 81 124 128
```
## Performing a loop (n) times

Another possibility is using the method looping() on any of the stored arrays to perform a partial ou (n) sequential loops over the same array elements. For this case, the second argument actually accepts not only integers, but floats as well. So:

```php
function echoR($item)
{
	echo $item . PHP_EOL;
}

$iterator->looping('1', 2.5, 'echoR');

// Returns: 1 3 5 6 7 11 15 24 34 56 66 77 124 1 3 5 6 7 11 15 24 34 56 66 77 124 1 3 5 6 7 11
```
## Looping all stored arrays

It is also possible to loop all stored arrays applying the same function. In this case, the result will be a single array in which elements are actually subarrays that bring a key-value logic, where the key refers to the stored array name and the value the respective value in the loop position. Let's apply it to the same two arrays to make it clearer.

```php
function echoR($item)
{
	var_dump($item);
}

$iterator->loopAll('echoR');

/* Returns:

array(2) {
  [1]=>
  int(1)
  [2]=>
  int(3)
}
array(2) {
  [1]=>
  int(3)
  [2]=>
  int(455)
}
array(2) {
  [1]=>
  int(5)
  [2]=>
  int(5)
} ... and so on...
*/ 

```
## Filter iterations

It is also possible to apply filters before starting the loop, by using the filterValues() method. Doing that, the iteration won't be occurring for the filtered values. The method accepts integers, strings, floats or an array of those elements.

```php
function echoR($item)
{
  echo $item . PHP_EOL;
}

$iterator->filterValues('1', [1, '3', 11], 'echoR');
// Returns: 5 6 7 15 24 34 56 66 77 124

$iterator->filterKeys('1', [1, '3', 11], 'echoR');
// Returns: 1 5 7 11 15 24 34 56 66 124

```
## Regex matching

From 1.2.0v, stored arrays can be traversed only on matching elements, from a given Regex expression, using the method regexMatch().

```php
function echoR($item)
{
  echo $item . PHP_EOL;
}

$iterator->regexMatch('1', "/^[1-3]+[0-3]*$/", 'echoR');
// Returns: 1 3 11

```