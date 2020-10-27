<?php

namespace App\Middleware;

use Cake\Http\Response;
use Cake\Http\ServerRequest;
use  Cake\Http\Exception\ForbiddenException;
use Exception;

class Token
{
    public function __invoke(ServerRequest $request, Response $response, callable $next)
    {
        try {
            $token = $request->getHeader('x-auth-token');
            if (is_array($token)) {
                $token = reset($token);
            }
        } catch (Exception $e) {
            throw new ForbiddenException();
        }

        if ($token == env('AUTH_TOKEN')) {
            return $next($request, $response);
        } else {
            throw new ForbiddenException();
        }

        return $next($request, $response);
    }
}
