<?php

namespace Chevron\Introspector\Traits;
/**
 * adds a way of inspecting $this. Originally meant to be used as a serializer
 * that didn't choke on Closures. Useful for serializing complex objects for
 * logging
 *
 * @package Chevron\Introspector
 */
trait IntrospectorTrait {

	/**
	 * whether or not to inspect sub objects
	 */
	protected $_deep = false;

	/**
	 * toggle a deeper dive into object properties
	 * @param boolean $deep
	 */
	public function setDeep($deep){
		$this->_deep = !!$deep;
	}

	/**
	 * parse $this
	 */
	public function introspect(){
		return $this->_parseObject($this);
	}

	/**
	 * evaluate a property's value
	 */
	protected function _typeLoop($val){
		switch(true){
			case is_scalar($val) :
				return $this->_parseScalar($val);

			case is_array($val) :
				return $this->_parseArray($val);

			case is_object($val) && $this->_deep :
				return $this->_parseObject($val);

			case is_object($val) && !$this->_deep :
				return $this->_parseObjectShallow($val);

			case is_resource($val) :
				return $this->_parseResource($val);

			default :
				return $this->_parseOther($val);
		}
	}

	/**
	 * handle a scalar value
	 * @param scalar $val the value to handle
	 */
	protected function _parseScalar($val){
		return $val;
	}

	/**
	 * handle an array value
	 * @param scalar $val the value to handle
	 */
	protected function _parseArray(array $val){
		$final = [];
		foreach($val as $k => $v){
			$final[$k] = $this->_typeLoop($v);
		}
		return $final;
	}

	/**
	 * handle a object value
	 * @param scalar $val the value to handle
	 */
	protected function _parseObject($val){
		$obj = new \ReflectionClass($val);
		$props = $obj->getProperties();
		$final = [];
		foreach($props as $prop){
			$prop->setAccessible(true);
			$final[$prop->getName()] = $this->_typeLoop($prop->getValue($val));
		}
		return $final ?: get_class($val);
	}

	/**
	 * handle a resource value
	 * @param scalar $val the value to handle
	 */
	protected function _parseResource($val){
		return get_resource_type($val);
	}

	/**
	 * handle a value not already handled
	 * @param scalar $val the value to handle
	 */
	protected function _parseOther($val){
		return gettype($val);
	}

	/**
	 * handle an object without diving any deeper into it's object properties
	 * @param scalar $val the value to handle
	 */
	protected function _parseObjectShallow($val){
		$props = get_object_vars($val);
		$final = [];
		foreach($props as $k => $v){
			$final[strtr($k, "\0", "-")] = $this->_typeLoop($v);
		}
		return $final ?: get_class($val);
	}

}


