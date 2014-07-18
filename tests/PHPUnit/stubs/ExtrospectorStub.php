<?php

class ExtrospectorStub {

	public    $mouse = "mice";
	protected $goose = "geese";
	private   $deer  = "deer";

	protected $sheep;

	public function setSheep($input){
		$this->sheep = $input;
	}

}