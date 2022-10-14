<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function database()
    {
        return 'Users count: ' . User::count();
    }

    public function transaction()
    {
        $count = DB::transaction(static function () {
            return User::count();
        });
        return 'Users count: ' . $count;
    }
}
