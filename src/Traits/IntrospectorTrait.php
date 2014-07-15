<?php

namespace Chevron\Introspector\Traits;

trait IntrospectorTrait {

	protected $_deep = false;

	public function setDeep($deep){
		$this->_deep = !!$deep;
	}

	public function introspect(){
		return $this->_parseObject($this);
	}

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

	protected function _parseScalar($val){
		return $val;
	}

	protected function _parseArray(array $val){
		$final = [];
		foreach($val as $k => $v){
			$final[$k] = $this->_typeLoop($v);
		}
		return $final;
	}

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

	protected function _parseResource($val){
		return get_resource_type($val);
	}

	protected function _parseOther($val){
		return gettype($val);
	}

	protected function _parseObjectShallow($val){
		$props = get_object_vars($val);
		$final = [];
		foreach($props as $k => $v){
			$final[strtr($k, "\0", "-")] = $this->typeLoop($v);
		}
		return $final ?: get_class($val);
	}

}
