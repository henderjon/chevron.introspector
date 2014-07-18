<?php

class ExtrospectionTest extends PHPUnit_Framework_TestCase {

	public function test_ExtrospectorTrait_clean() {

		$obj = new ExtrospectorStub;

		$ex = new Chevron\Introspector\Extrospector();

		$result = $ex->extrospect($obj);

		$expected = [
			"mouse" => "mice",
			"goose" => "geese",
			"deer"  => "deer",
			"sheep" => "NULL",
		];

		$this->assertEquals($expected, $result);

	}

	/**
	 * @expectedException \Exception
	 */
	public function test_ExtrospectorTrait_exception() {

		$ex = new Chevron\Introspector\Extrospector();

		$result = $ex->extrospect($obj);

	}

}