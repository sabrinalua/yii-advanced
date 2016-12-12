<?php
namespace vendor;

interface Iterator{

	public function rewind();
	public function current();
	public function key();
	public function next();
	public function valid();
}

?>