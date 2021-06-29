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
        header('content-type: application/json');
        $errorMsg = json_encode(['status' => 'error', 'message' => $message]);
        echo $errorMsg;
        exit();
    }

    public function jsonFormat(
        $status_code = null,
        $status = null,
        $message = null,
        $data = null
    ) {
        return \response()->json([
            'status_code' => $status_code,
            'status' => $status,
            'message' => $message ? $message : 'Data loaded',
            'payload' => $data,
        ]);
    }

    public function getLastUserId()
    {
        $lastId = User::orderBy('user_id', 'desc')->first('user_id');
        $newId = $lastId ? $lastId['user_id'] + 1 : 1;
        $random = sprintf('%06d', mt_rand(1, 999999));
        return $random . '' . $newId;
    }

    public function getLastProfileId()
    {
        $lastId = Profile::orderBy('profile_id', 'desc')->first('profile_id');
        $newId = $lastId ? $lastId['profile_id'] + 1 : 1;
        return '00' . $newId;
    }
}
