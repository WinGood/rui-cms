<?php

/**
 * Валидация данных
 * @author  Румянцев Олег
 * @version 0.1
 * Create: 18.04.14
 * Last.Update: 18.04.14
 */

class Validation
{
	static private $_instance;
	static private $data;
	static private $error;
	private function __construct(){}
	private function __clone(){}

	public static function run($data, $rules)
	{
		self::$data = $data;
		$res = array();
		$html = '';
		foreach($data as $field => $value)
		{
			foreach($rules as $fieldRul => $nameRul)
			{
				$code = $fieldRul;
				$name = '';

				$fieldRul = explode('|', $fieldRul);

				if(count($fieldRul) > 1)
				{
					$code = $fieldRul[1];
					$name = $fieldRul[0];
				}

				// Если не передано норм. название поля то берем название input'а
				$nameField = !empty($name) ? $name : $code;

				if($field == $code)
				{
					$rulList = explode('|', $nameRul);
					$rulArr  = array();

					//Проверка на правила с параметром
					foreach($rulList as $item)
					{
						$rulArr[] = explode(':', $item);
					}

					foreach($rulArr as $rul)
					{
						// Если правило с параметром
						if(count($rul) > 1)
						{
							$param = $rul[1];
							if($err = self::$rul[0]($nameField, $value, $param))
							{
								self::$error[$code][] = $err;
								$res[] = $err;
							}
						}
						else
						{
							if($err = self::$rul[0]($nameField, $value))
							{
								self::$error[$code][] = $err;
								$res[] = $err;
							}
						}
					}
				}
			}
		}

		return self::printError($res);
	}

	public static function getError($field)
	{
		$errors = self::$error[$field];
		return self::printError($errors);
	}

	private static function printError($errors)
	{
		$html = '';

		if(!empty($errors))
		{
			foreach($errors as $err)
			{
				$html .= "<p>$err</p>";
			}
		}

		return $html;
	}

	// $val - текущее значение, $reField - с каким полем сравнивать
	private static function password($nameField, $val, $reField)
	{
		$reVal = self::$data[$reField];
		if($val != $reVal)
			return 'Пароли не совпадают';
	}

	private static function max($nameField, $val, $max)
	{
		if(strlen($val) > $max)
			return 'Длина поля ' . $nameField . ' не должна превышать ' . $max . ' символов';
	}

	private static function min($nameField, $val, $min)
	{
		if(strlen($val) < $min)
			return 'Длина поля ' . $nameField . ' должна быть больше ' . $min . ' символов';
	}

	private static function required($nameField, $val)
	{
		if(empty($val))
			return 'Поле ' . $nameField . ' не заполнено!';
	}

	private static function numeric($nameField, $val)
	{
		if(!is_numeric($val))
			return 'Поле ' . $nameField . ' не является числом';
	}
}