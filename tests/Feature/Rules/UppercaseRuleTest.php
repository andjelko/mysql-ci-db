<?php

use App\Rules\UppercaseRule;

it('will pass for upper cased values', function(string $value, bool $expectedResult) {
    $result = (new UppercaseRule())->passes('name', $value);
    expect($result)->toBe($expectedResult);
})->with([
    ['MY STRING', true],
    ['my string', false],
    ['My string', false],
    ['MY string', false],
    ['MY STRINg', false],
]);
