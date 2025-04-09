<?php

use App\Domains\Betting\Actions\CalculateBetResultAction;
use App\Domains\Betting\Models\Bet;

it('can calculate bet with heads', function () {

    $betMock = mock(Bet::class)->makePartial();

    $betMock->shouldReceive('getAttribute')
        ->with('choice')
        ->andReturn('heads');

    $betMock->shouldReceive('getAttribute')
        ->with('client_seed')
        ->andReturn($clientSeed = 123);

    $betMock->shouldReceive('getAttribute')
        ->with('server_seed')
        ->andReturn($serverSeed = 456);

    $betMock->shouldReceive('getAttribute')
        ->with('nonce')
        ->andReturn($nonce = 'abc');

    $betMock->shouldReceive('getAttribute')
        ->with('result')
        ->andReturn(
            hash('sha256', $clientSeed.$serverSeed.$nonce)
        );

    $result = app(CalculateBetResultAction::class)($betMock);

    expect($result)->toBeTrue();
});
