<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    config()->set('mobile-pass.apple.webservice.secret', 'correct-secret');
});

it('responds with 401 when the passkit authorization header is wrong or missing', function (string $method, string $uri, array $headers) {
    $this->withHeaders($headers)
        ->call($method, $uri, ['pushToken' => 'token'])
        ->assertUnauthorized();
})->with([
    'register device' => ['POST', 'passkit/v1/devices/device/registrations/pass.be.spatie.demo/serial'],
    'check for updates' => ['GET', 'passkit/v1/passes/pass.be.spatie.demo/serial'],
    'unregister device' => ['DELETE', 'passkit/v1/devices/device/registrations/pass.be.spatie.demo/serial'],
])->with([
    'wrong header' => [['Authorization' => 'ApplePass wrong-secret']],
    'missing header' => [[]],
]);

it('responds with 401 when a google callback has no bearer token', function () {
    $this->post('passkit/v1/google/callbacks')->assertUnauthorized();
});

it('lets requests with the correct passkit authorization header through', function () {
    $this->withHeaders(['Authorization' => 'ApplePass correct-secret'])
        ->get('passkit/v1/passes/pass.be.spatie.demo/unknown-serial')
        ->assertNotFound();
});
