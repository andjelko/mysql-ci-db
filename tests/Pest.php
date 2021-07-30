<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Tests\CreatesApplication;
use Tests\DuskTestCase;
use function Pest\Laravel\actingAs;

uses(TestCase::class, CreatesApplication::class, RefreshDatabase::class)->in('Unit', 'Feature');
uses(DuskTestCase::class)->in('Browser');

function login(User $user = null)
{
    actingAs($user ?? User::factory()->admin()->create());
}

function createRequest($method, $uri): Request
{
    $symfonyRequest = SymfonyRequest::create(
        $uri,
        $method,
    );

    return Request::createFromBase($symfonyRequest);
}

expect()->extend('isForbidden', function() {
    return expect($this->value->isForbidden())->toBeTrue();
});

expect()->extend('isSuccessfulOrRedirect', function() {
    return expect($this->value->status())->toBeIn([200, 301, 302]);
});

expect()->extend('toBeInTheRange', function(int $min, int $max) {
    return $this
        ->toBeGreaterThanOrEqual($min)
        ->toBeLessThanOrEqual($max);
});
