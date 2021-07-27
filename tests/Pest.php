<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Tests\CreatesApplication;
use function Pest\Laravel\actingAs;

uses(TestCase::class, CreatesApplication::class, RefreshDatabase::class)->in('Unit', 'Feature');

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
