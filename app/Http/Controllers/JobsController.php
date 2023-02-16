<?php

namespace App\Http\Controllers;

use App\Jobs\Homework;
use Illuminate\Http\Request;
use Illuminate\Queue\Events\JobQueued;

class JobsController extends Controller
{
    public function job(Request $request)
    {
        Homework::dispatch($request->info)
        ->onQueue('mail');
        return response()->json(["JALA queue...{$request->info}"]);


    }
}
