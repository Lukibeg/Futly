<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
       
    }

    public function apiShow()
    {
        http_response_code(200);
        return json_encode(['teste' => 'Retornado']);
    }

}
