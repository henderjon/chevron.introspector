<?php

namespace Chevron\Introspector;
/**
 * adds a way of inspecting an object to which you're otherwise unable to add
 * IntrospectorTrait.
 *
 * @package Chevron\Introspector
 */
class Extrospector {

	use \Chevron\Introspector\Traits\IntrospectorTrait;

	/**
	 * @param bool $deep Toggle how deep to inspect
	 */
	function __construct($deep = false){
		$this->setDeep($deep);
	}

	/**
	 * override the Trait's introspect method since we're not INTROspecting
	 */
	public function introspect(){ /* noop */ }

	/**
	 * tirgger the inspection of the previously supplied object
	 * @param mixed $obj The object to inspect
	 */
	public function extrospect($obj){
		if(!is_object($obj)){
			throw new \Exception("Only instantiated objects can be extrospected.");
		}
		return $this->_parseObject($obj);
	}

}
