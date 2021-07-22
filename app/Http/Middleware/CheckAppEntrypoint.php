<?php
/**
 * @copyright SportM4te 2021 - present
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;
use Jenssegers\Agent\Agent;

class CheckAppEntrypoint extends Middleware
{
    public const INTRO_URI = 'https://sportm4te.com/';
    public const DOWNLOAD_URI = 'https://sportm4te.com/download/';

    public function handle($request, Closure $next)
    {
        $agent = new Agent();

        if ($agent->isDesktop()) {
            return redirect($request->path() === '/' ? self::INTRO_URI : self::DOWNLOAD_URI);
        }

        return $next($request);
    }
}
