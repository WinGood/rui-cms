<?php
class Model
{
	public static function factory($name)
	{
		$name = 'Models_'.ucfirst($name);
		return new $name;
	}
}