<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;

class Admin
{
    /**
     * Handle an incoming request
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      $id = Auth::user()->id;

      $user = User::where('id', $id)->first();

      if ($user->role == 'ADMIN') {
        return $next($request);
      } else {
        return redirect()->route('home');
      }
    }
}