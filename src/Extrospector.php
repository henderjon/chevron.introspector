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
	 * the object to inspect
	 */
	protected $that;

	/**
	 * @param mixed $obj The object to inspect
	 * @param bool $deep Toggle how deep to inspect
	 */
	function __construct($obj, $deep = false){
		$this->that = $obj;
		$this->setDeep($deep);
	}

	/**
	 * override the Trait's introspect method since we're not INTROspecting
	 */
	public function introspect(){ /* noop */ }

	/**
	 * tirgger the inspection of the previously supplied object
	 */
	public function extrospect(){
		return $this->_parseObject($this->that);
	}

}
