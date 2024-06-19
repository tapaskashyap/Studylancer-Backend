<?php

namespace App\Traits;

trait HttpResponses
{
	protected function success($message = null, $data, $code = 200)
	{
		return response()->json([
			'status'=> true, 
			'message' => $message, 
			'data' => $data
		], $code)->header('Content-Type', 'application/json');
	}

	protected function error($message = null, $error, $code)
	{
		return response()->json([
			'status'=>false,
			'message' => $message,
			'data' => $error
		], $code)->header('Content-Type', 'application/json');
	}

	protected function paginationSuccess($message = null, $data, $current_page, $last_page, $per_page, $total, $code = 200)
	{
		return response()->json([
			'status'=>true,
			'message' => $message,
			'current_page' => $current_page,
			'last_page' => $last_page,
			'per_page' => $per_page,
            'total' => $total,
			'data' => $data
		], $code)->header('Content-Type', 'application/json');
	}
}