<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('id') == false) {
            return redirect()->route('admin.login')->with('error', 'Please login first!');
        } else {
            $admin = Admin::where('id', session('id'))->first();
            if ($admin == null) {
                return redirect()->route('admin.login')->with('error', 'You are not administrator!');
            }
        }
        return $next($request);
    }
}
