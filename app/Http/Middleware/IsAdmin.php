<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{

    public function handle(Request $request, Closure $next): Response
    {
        
        if (auth()->check() && auth()->user()->id_role == 1) {
            return $next($request);
        }

        // 2. Kalau bukan admin, lempar balik ke halaman utama/login dengan pesan error
        return redirect('/index')->with('error', 'Lu bukan Admin, gak usah iseng ke dashboard!');
    }
}