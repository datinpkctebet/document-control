<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $userLevelId = $user->id_level;

        // Map role names to level IDs
        $roleMap = [
            'superadmin' => 1,
            'petugas' => 2,
            'surveyor' => 3,
            'unit' => 4,
            'dokumen_kontrol' => 5,
        ];

        foreach ($roles as $role) {
            if (isset($roleMap[$role]) && $userLevelId == $roleMap[$role]) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}