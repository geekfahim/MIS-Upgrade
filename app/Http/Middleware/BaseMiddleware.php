<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\UnauthorizedException;

class BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->is_admin) {
            $routeArray = explode("__", $request->route()->getName());
            $permission = $routeArray[0] ?? null;
            try {
                if (!auth()->user()->hasPermissionTo($permission)) {
                    return $request->ajax() ? response()->json(["message" => "Sorry! you don't have sufficient permission"], Response::HTTP_FORBIDDEN) : redirect()->back()->with('warning', "Unauthorized access");
                }
            } catch (PermissionDoesNotExist $e) {
                return response()->json(["message" => $e->getMessage()], Response::HTTP_FORBIDDEN);
            } catch (UnauthorizedException $e) {
                return redirect()->back()->with('warning', $e->getMessage());
            }
        }

        if (in_array(Str::lower($request->method()), ['post', 'put'])) {
            $request->merge([
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
            ]);
        }
        return $next($request);
    }
}
