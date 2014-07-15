<?php

class ExtrospectionTest extends PHPUnit_Framework_TestCase {

	public function test_ExtrospectorTrait_clean() {

		$obj = new ExtrospectorStub;

		$ex = new Chevron\Introspector\Extrospector($obj);

		$result = $ex->extrospect();

		$expected = [
			"mouse" => "mice",
			"goose" => "geese",
			"deer"  => "deer",
			"sheep" => "NULL",
		];

		$this->assertEquals($expected, $result);

	}

}