<?php

function success(string $message)
{
    request()->session()->flash('flash.banner', $message);
    request()->session()->flash('flash.bannerStyle', 'success');
}

function error(string $message)
{
    request()->session()->flash('flash.banner', $message);
    request()->session()->flash('flash.bannerStyle', 'danger');
}
