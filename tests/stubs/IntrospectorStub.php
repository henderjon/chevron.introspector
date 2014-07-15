<?php

use \Chevron\Introspector\Traits\IntrospectorTrait;

class IntrospectorStub {

	use IntrospectorTrait;

	public    $mouse = "mice";
	protected $goose = "geese";
	private   $deer  = "deer";

	protected $sheep;

	public function setSheep($input){
		$this->sheep = $input;
	}

}