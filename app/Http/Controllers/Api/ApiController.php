<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * @var $statusSuccess -> integer
     * @var $statusAccepted -> integer
     * @var $statusNotFound -> integer
     * @var $statusServerError -> integer
     * @string $successAtrArray -> attribute uses in some responses (success request)
     * @string $errorsAtrArray -> attribute uses in some responses (errors in request)
     * @string $messageAtrArray -> attribute uses in some responses (message after request)
     */
    public $statusSuccess = 200;
    public $statusAccepted = 202;
    public $statusNotFound = 204;
    public $statusUnauthorized = 401;
    public $statusValidationFailed = 422;
    public $statusServerError = 500;
    public $successAtrArray = 'success';
    public $errorsAtrArray = 'errors';
    public $messageAtrArray = 'message';
    public $responseAtrArray = 'response';
}
