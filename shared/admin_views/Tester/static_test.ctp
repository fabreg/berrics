<?php 


class test1 {

	public static $fuck = "yup";

}

class test2 extends test1 {

	public function test() {

		static::$fuck = " Wet Pussy";

	}

}



$b = new test2();

test1::$fuck = "Yup";

echo $b::$fuck;

$a = new test1();

$b::$fuck = " Pussy";

echo $a::$fuck;

$b->test();

echo $a::$fuck;
?>