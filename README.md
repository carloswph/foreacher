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