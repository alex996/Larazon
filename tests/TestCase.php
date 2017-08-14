<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Concerns\{CreatesApplication, InteractsWithJwt, InteractsWithStripe};

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, InteractsWithJwt, InteractsWithStripe;
}
