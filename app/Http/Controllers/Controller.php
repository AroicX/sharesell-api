<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// Data types
define('BOOLEAN', '1');
define('INTEGER', '2');
define('STRING', '3');
define('IS_ARRAY', '4');
//Error Codes
define('REQUEST_METHOD_NOT_VALID', 100);
define('REQUEST_CONTENTTYPE_NOT_VALID', 101);
define('REQUEST_NOT_VALID', 102);
define('VALIDATE_PARAMETER_REQUIRED', 103);
define('VALIDATE_PARAMETER_DATATYPE', 104);

class Controller extends BaseController
{
    // use Helpers;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function validateParameter(
        $fieldName,
        $value,
        $dataType,
        $required = true
    ) {
        if ($required && empty($value)) {
            $this->throwError(
                VALIDATE_PARAMETER_REQUIRED,
                $fieldName . ' is required.'
            );
        }

        switch ($dataType) {
            case IS_ARRAY:
                if (!is_array($value)) {
                    $this->throwError(
                        VALIDATE_PARAMETER_DATATYPE,
                        $fieldName . ' is Not Valid.'
                    );
                }
                break;
            case BOOLEAN:
                if (!is_bool($value)) {
                    $this->throwError(
                        VALIDATE_PARAMETER_DATATYPE,
                        $fieldName . ' is Not Valid.'
                    );
                }
                break;
            case INTEGER:
                if (!is_numeric($value)) {
                    $this->throwError(
                        VALIDATE_PARAMETER_DATATYPE,
                        $fieldName . ' is Not Valid.'
                    );
                }
                break;
            case STRING:
                if (!is_string($value)) {
                    $this->throwError(
                        VALIDATE_PARAMETER_DATATYPE,
                        $fieldName . ' is Not Valid.'
                    );
                }
                break;

            default:
                $this->throwError(
                    VALIDATE_PARAMETER_DATATYPE,
                    $fieldName . ' is Not Valid.'
                );
                break;
        }

        // return $value;
    }

    public function throwError($code, $message)
    {
        header('Access-Control-Allow-Origin: *');
        header('content-type: application/json');

        $errorMsg = json_encode(['status' => 'error', 'message' => $message]);
        echo $errorMsg;
        exit();

        // return response()->json(
        //     ['status' => 'error', 'message' => $message],
        //     500
        // );
    }

    public function jsonFormat(
        $status_code = null,
        $status = null,
        $message = null,
        $data = null
    ) {
        return \response()->json(
            [
                'status_code' => $status_code,
                'status' => $status,
                'message' => $message ? $message : 'Data loaded',
                'payload' => $data,
            ],
            $status_code
        );
    }

    public function getLastUserId()
    {
        $lastId = User::orderBy('user_id', 'desc')->first('user_id');
        $newId = $lastId ? $lastId['user_id'] + 1 : 1;
        $random = mt_rand(1, 99);
        return '000' . $random . '' . $newId;
    }

    function random_string($length)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('A', 'Z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    // public function getLastProfileId()
    // {
    //     $lastId = Profile::orderBy('profile_id', 'desc')->first('profile_id');
    //     $newId = $lastId ? $lastId['profile_id'] + 1 : 1;
    //     return '00' . $newId;
    // }
}
