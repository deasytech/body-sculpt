<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeployRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_rejects_requests_without_a_token(): void
    {
        config(['deploy.token' => 'secret-token']);

        $response = $this->get('/deploy/optimize-clear');

        $response->assertForbidden();
    }

    public function test_it_rejects_requests_with_the_wrong_token(): void
    {
        config(['deploy.token' => 'secret-token']);

        $response = $this->get('/deploy/optimize-clear?token=wrong');

        $response->assertForbidden();
    }

    public function test_it_rejects_every_request_when_no_token_is_configured(): void
    {
        config(['deploy.token' => '']);

        $response = $this->get('/deploy/optimize-clear?token=');

        $response->assertForbidden();
    }

    public function test_it_runs_the_command_with_the_correct_token(): void
    {
        config(['deploy.token' => 'secret-token']);

        $response = $this->get('/deploy/optimize-clear?token=secret-token');

        $response->assertOk()->assertJson(['ok' => true, 'command' => 'optimize:clear']);
    }
}
