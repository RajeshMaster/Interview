<?php
namespace App\Http\Middleware;
use Closure;
use Redirect;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    // The below function was added by Kumaran. 19/03/2018.
    // To overcome, CSRF_TOKEN mismatch error
    public function handle( $request, Closure $next )
    {
        if (
            $this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->shouldPassThrough($request) ||
            $this->tokensMatch($request)
        ) {
            return $this->addCookieToResponse($request, $next($request));
        }

        // redirect the user back to the last page and show error
        return Redirect::back()->withError('Sorry, we could not verify your request. Please try again.');
    }
}