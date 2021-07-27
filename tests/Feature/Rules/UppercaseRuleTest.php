<?php

use App\Rules\UppercaseRule;

it('will pass for upper cased values', function() {
    $result = (new UppercaseRule())->passes('name', 'MY STRING');
    expect($result)->toBeTrue();

    $result = (new UppercaseRule())->passes('name', 'my string');
    expect($result)->toBeFalse();

    $result = (new UppercaseRule())->passes('name', 'My string');
    expect($result)->toBeFalse();

    $result = (new UppercaseRule())->passes('name', 'MY string');
    expect($result)->toBeFalse();

    $result = (new UppercaseRule())->passes('name', 'MY STRINg');
    expect($result)->toBeFalse();
});
