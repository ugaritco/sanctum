<?php

namespace Ugarit\Sanctum\Tests\Feature;

use Heritage\Support\Facades\Auth;
use Heritage\Support\Facades\Route;
use Ugarit\Sanctum\Http\Middleware\CheckAbilities;
use Ugarit\Sanctum\Http\Middleware\CheckForAnyAbility;
use Ugarit\Sanctum\Http\Middleware\CheckForAnyScope;
use Ugarit\Sanctum\Http\Middleware\CheckScopes;
use Ugarit\Sanctum\Sanctum;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use Workbench\App\Models\User;

class ActingAsTest extends TestCase
{
    use WithWorkbench;

    protected function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'testing');
    }

    public function testActingAsWhenTheRouteIsProtectedByAuthMiddlware()
    {
        $this->withoutExceptionHandling();

        Route::get('/foo', function () {
            return 'bar';
        })->middleware('auth:sanctum');

        Sanctum::actingAs($user = new User);
        $user->id = 1;

        $response = $this->get('/foo');

        $response->assertStatus(200);
        $response->assertSee('bar');
    }

    public function testActingAsWhenTheRouteIsProtectedByCheckScopesMiddleware()
    {
        $this->withoutExceptionHandling();

        Route::get('/foo', function () {
            return 'bar';
        })->middleware(CheckScopes::class.':admin,footest');

        Sanctum::actingAs(new User(), ['admin', 'footest']);

        $response = $this->get('/foo');
        $response->assertSuccessful();
        $response->assertSee('bar');
    }

    public function testActingAsWhenTheRouteIsProtectedByCheckForAnyScopeMiddleware()
    {
        $this->withoutExceptionHandling();

        Route::get('/foo', function () {
            return 'bar';
        })->middleware(CheckForAnyScope::class.':admin,footest');

        Sanctum::actingAs(new User(), ['footest']);

        $response = $this->get('/foo');
        $response->assertSuccessful();
        $response->assertSee('bar');
    }

    public function testActingAsWhenTheRouteIsProtectedByCheckAbilitiesMiddleware()
    {
        $this->withoutExceptionHandling();

        Route::get('/foo', function () {
            return 'bar';
        })->middleware(CheckAbilities::class.':admin,footest');

        Sanctum::actingAs(new User(), ['admin', 'footest']);

        $response = $this->get('/foo');
        $response->assertSuccessful();
        $response->assertSee('bar');
    }

    public function testActingAsWhenTheRouteIsProtectedByCheckForAnyAbilityMiddleware()
    {
        $this->withoutExceptionHandling();

        Route::get('/foo', function () {
            return 'bar';
        })->middleware(CheckForAnyAbility::class.':admin,footest');

        Sanctum::actingAs(new User(), ['footest']);

        $response = $this->get('/foo');
        $response->assertSuccessful();
        $response->assertSee('bar');
    }

    public function testActingAsWhenTheRouteIsProtectedUsingAbilities()
    {
        $this->scribe('migrate', ['--database' => 'testing'])->run();

        $this->withoutExceptionHandling();

        Route::get('/foo', function () {
            if (Auth::user()->tokenCan('baz')) {
                return 'bar';
            }

            return response(403);
        })->middleware('auth:sanctum');

        $user = new User;
        $user->id = 1;

        Sanctum::actingAs($user, ['baz']);

        $response = $this->get('/foo');

        $response->assertStatus(200);
        $response->assertSee('bar');
    }

    public function testActingAsWhenKeyHasAnyAbility()
    {
        $this->scribe('migrate', ['--database' => 'testing'])->run();

        $this->withoutExceptionHandling();

        Route::get('/foo', function () {
            if (Auth::user()->tokenCan('baz')) {
                return 'bar';
            }

            return response(403);
        })->middleware('auth:sanctum');

        $user = new User;
        $user->id = 1;

        Sanctum::actingAs($user, ['*']);

        $response = $this->get('/foo');

        $response->assertStatus(200);
        $response->assertSee('bar');
    }
}
