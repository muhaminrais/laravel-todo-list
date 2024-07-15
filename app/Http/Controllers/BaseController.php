<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
  protected static $response = [
    'meta' => [
      'code' => 200,
      'status' => 'Ok',
      'message' => null
    ],
    'data' => null
  ];

  public static function sendSuccess($data = null, $message = null)
  {
    self::$response['meta']['message'] = $message;
    self::$response['data'] = $data;

    return response()->json(self::$response, self::$response['meta']['code']);
  }

  public static function sendError($message = null, $code = 400, $status = 'Bad Request')
  {
    self::$response['meta']['code'] = $code;
    self::$response['meta']['status'] = $status;
    self::$response['meta']['message'] = $message;

    return response()->json(self::$response, self::$response['meta']['code']);
  }
}
