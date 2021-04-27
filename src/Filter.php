<?php 

namespace Foreacher;

/**
 * 
 */
class Filter extends \FilterIterator
{
	protected $values = [];

	protected $keys = [];

	public function __construct(\ArrayIterator $iterator , mixed $valueFilter = null, mixed $keyFilter = null )
    {
        parent::__construct($iterator);

        if(!is_null($valueFilter) && is_array($valueFilter)) {
        	$this->values = $valueFilter;
        } elseif(!is_null($valueFilter) && is_string($valueFilter)) {
        	$this->values[] = $valueFilter;
        } elseif(!is_null($valueFilter) && is_numeric($valueFilter)) {
            $this->values[] = $valueFilter;
        }

        if(!is_null($keyFilter) && is_array($keyFilter)) {
        	$this->keys = array_merge($this->keys, $keyFilter);
        } elseif(!is_null($keyFilter) && is_string($keyFilter)) {
        	$this->keys = $keyFilter;
        } elseif(!is_null($keyFilter) && is_numeric($keyFilter)) {
            $this->keys = $keyFilter;
        }
    }

    public function accept()
    {
    	$value = $this->getInnerIterator()->current();
    	$key = $this->getInnerIterator()->key();

    	if(in_array($value, $this->values)) {
    		return false;
    	}

    	if(!empty($this->keys) && in_array($key, $this->keys)) {
    		return false;
    	}

    	return true;
    }
}