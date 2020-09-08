<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DeactivateAccountService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function deactivate(Request $request, User $user, DeactivateAccountService $service)
    {
        return $service->execute($request, $user);
    }
}
