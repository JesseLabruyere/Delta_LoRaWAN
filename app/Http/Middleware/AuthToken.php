<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Dingo\Api\Http\Response;
use Closure;
use Illuminate\Support\Facades\Auth;
use Delta\DeltaVerification\Tokens\TokenRepositoryInterface as TokenRepository;

class AuthToken
{
    /**
     * @var TokenRepositoryInterface
     */
    protected $token;

    /**
     * bind instances to class
     */
    public function __construct(TokenRepository $token)
    {
        $this->token = $token;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(
        Request $request,
        Closure $next
    ) {
        $token = $request->bearerToken();
        // dd(app()->make('config')->get('delta_verification'));
        if (is_null($token)) {
            $this->error(400, 'No bearer token included');
        }

        if (!$this->token->findUserByToken($token)) {
            $this->error(400, 'Invallid bearer token included');
        }


        return $next($request);
    }

    /**
     * Return an error response.
     *
     * @param  int     $statusCode
     * @param  string  $message
     * @return \Illuminate\Http\Reponse
     */
    protected function error($statusCode, $message)
    {
        $error = [
            'message' => $message,
            'status_code' => $statusCode,
        ];

        return (new Response($error))->setStatusCode($statusCode);
    }
}
