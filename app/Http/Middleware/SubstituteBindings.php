<?php
/**
 * Created by PhpStorm.
 * User: Alexandr
 * Date: 13.06.2017
 * Time: 13:19
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\App;

class SubstituteBindings
{
    /**
     * The router instance.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new bindings substitutor.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Registrar $router)
    {
        $this->router = $router;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->router->substituteBindings($route = $request->route());
        $this->router->substituteImplicitBindings($route);

        foreach ($route->parameters as $parameter) {
            if (is_object($parameter) &&
                is_subclass_of($parameter, \App\CustomModel::class) &&
                $parameter->hasAttribute('company_id') &&
                $parameter->company_id !== auth()->user()->id) abort(403);
        }

        return $next($request);
    }
}