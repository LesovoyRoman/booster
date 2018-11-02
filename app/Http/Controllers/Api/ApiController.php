<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * @var $statusNotFound -> integer
     * @var $statusSuccess -> integer
     * @var $statusServerError -> integer
     * @string $successAtrArray -> attribute uses in some responses (success request)
     * @string $errorsAtrArray -> attribute uses in some responses (errors in request)
     * @string $messageAtrArray -> attribute uses in some responses (message after request)
     */
    public $statusNotFound = 204;
    public $statusSuccess = 200;
    public $statusServerError = 500;
    public $successAtrArray = 'success';
    public $errorsAtrArray = 'errors';
    public $messageAtrArray = 'message';
    public $responseAtrArray = 'response';
}
