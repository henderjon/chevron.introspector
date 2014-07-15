<?php

class IntrospectionTest extends PHPUnit_Framework_TestCase {

	public function test_IntrospectorTrait_clean() {

		$obj = new IntrospectorStub;

		$result = $obj->introspect();

		$expected = [
			"mouse" => "mice",
			"goose" => "geese",
			"deer"  => "deer",
			'_deep' => false,
			"sheep" => "NULL",
		];

		$this->assertEquals($expected, $result);

	}

	public function test_IntrospectorTrait_closure() {

		$obj = new IntrospectorStub;

		$obj->setSheep(function(){
			return "moose";
		});

		$result = $obj->introspect();

		$expected = [
			"mouse" => "mice",
			"goose" => "geese",
			"deer"  => "deer",
			'_deep' => false,
			"sheep" => "Closure",
		];

		$this->assertEquals($expected, $result);

	}

}