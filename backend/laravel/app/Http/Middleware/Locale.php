<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Locale
{
    /**
     * @var string $defaultLocale
     */
    private $defaultLocale;
    
     /**
     * @param string $defaultLocale
     */
    public function __construct($defaultLocale = 'es')
    {
        $this->defaultLocale = $defaultLocale;
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($locale = $request->_locale) {
            app()->setLocale(session('locale', $locale));
        } else {
            app()->setLocale(session('locale', $this->defaultLocale));
        }

        return $next($request);
    }
}
