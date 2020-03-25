<?php

namespace App;

class Helpers
{
	public static function generateHash($string)
	{
		return hash('sha512', 'asdklfj23#23' . $string . 'asd213423#23');
	}

	public static function makeSlug($string)
	{
		$new_string = str_replace(' ', '-', $string);
		$new_string = str_replace('%', '', $new_string);
		return $new_string;
	}

	public static function prepareInputs($request, $input_data)
    {
        $data = array();
        foreach ($input_data as $input) {
            if (! empty($request[$input])) {
                $data[$input] = $request[$input];
            }
        }

        return $data;
    }
}