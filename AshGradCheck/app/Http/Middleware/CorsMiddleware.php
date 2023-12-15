<?php


namespace App\Http\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
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
        // header("Access-Control-Allow-Origin: *");

        // $headers = [
        //     'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
        //     'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization'
        // ];
        // if ($request->getMethod() == "OPTIONS") {
        //     return response('OK')
        //         ->withHeaders($headers);
        // }

        // $response = $next($request);
        // foreach ($headers as $key => $value)
        //     $response->header($key, $value);
        // return $response;
        return $next($request)
        ->header('Access-Control-Allow-Origin', "*")
        ->header('Access-Control-Allow-Methods', "PUT,POST,DELETE,GET,OPTIONS")
        ->header('Access-Control-Allow-Headers',"Accept,Authorization,Content-Type");
    }
}
