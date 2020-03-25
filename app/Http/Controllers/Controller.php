<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function notFoundResponse()
    {
        return $this->response(false, 403, trans('general.notfound'));
    }

    public function validationResponse($validator)
    {
    	return $this->response(false, 402, null, null, $validator->errors()->first());
    }

    public function serverErrorResponse($exception)
    {
    	return $this->response(false, 500, null, null, $exception->getMessage());
    }

    public function successResponseWithData($data)
    {
    	return $this->response(true, 200, null, $data);
    }

    public function successResponseWitMessage($msg = 'تمت العملية بنجاح')
    {
    	return $this->response(true, 200, $msg);
    }

    public function errorResponseWitMessage($msg = 'عملية غير صحيحة')
    {
        return $this->response(false, 200, $msg);
    }

    public function response($success = true, $status_code = 200, $msg = null, $data = null, $error = null)
    {
    	return response()->Json([
    		'success' => $success,
    		'msg' => $msg,
    		'data' => $data,
    		'error' => $error
    	], $status_code);
    }
}
