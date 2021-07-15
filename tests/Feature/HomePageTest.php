<?php

it('can render the homepage', function() {
   $this
       ->get('/')
       ->assertSee('My Blog')
       ->assertSee('Parallel php');
});
