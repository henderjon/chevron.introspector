<?php

namespace Chevron\Introspector;

class Extrospector {

	use \Chevron\Introspector\Traits\IntrospectorTrait;

	protected $that;

	function __construct($obj, $deep = false){
		$this->that = $obj;
		$this->setDeep($deep);
	}

	public function introspect(){ /* noop */ }

	public function extrospect(){
		return $this->_parseObject($this->that);
	}

}
