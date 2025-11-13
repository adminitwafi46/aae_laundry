<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\ApiResponseTrait;

class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiResponseTrait;
}
