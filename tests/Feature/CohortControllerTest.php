<?php

namespace Tests\Feature\Controllers;

use App\Models\Cohort;
use App\Models\User; // Add the User model
use App\Services\CohortService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class CohortControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $cohortService;
    protected $user; // Declare the user property

    protected function setUp(): void
    {
        parent::setUp();

        $this->cohortService = Mockery::mock(CohortService::class);
        $this->app->instance(CohortService::class, $this->cohortService);

        // Create a user or fetch an existing one
        $this->user = User::factory()->create();
    }

    /**
     * Test index method.
     */
    public function test_it_can_list_cohorts()
    {
        $cohorts = Cohort::factory()->count(3)->make();

        $this->cohortService
            ->shouldReceive('getAllCohorts')
            ->once()
            ->andReturn($cohorts);

        // Authenticate the request
        $this->actingAs($this->user, 'api')->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('TestToken')->plainTextToken,
        ]);
        $response = $this->getJson('/api/cohorts');
        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /**
     * Test store method.
     */
    public function test_it_can_create_a_cohort()
    {
        $cohortData = [
            'number' => 1,
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
        ];

        $this->cohortService
            ->shouldReceive('createCohort')
            ->once()
            ->with($cohortData)
            ->andReturn(Cohort::make($cohortData));

        // Authenticate the request
        $this->actingAs($this->user, 'api')->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('TestToken')->plainTextToken,
        ]);
        $response = $this->postJson('/api/cohorts', $cohortData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['number' => 1]);
    }

    /**
     * Test show method.
     */
    public function test_it_can_show_a_single_cohort()
    {
        $cohort = Cohort::factory()->make(['id' => 1]);

        $this->cohortService
            ->shouldReceive('getCohortById')
            ->once()
            ->with(1)
            ->andReturn($cohort);

        // Authenticate the request
       // $response = $this->actingAs($this->user, 'api')->getJson('/api/cohorts/1');
        $this->actingAs($this->user, 'api')->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('TestToken')->plainTextToken,
        ]);
        $response = $this->getJson('/api/cohorts/1');
        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => 1]);
    }

    /**
     * Test update method.
     */
    public function test_it_can_update_a_cohort()
    {
        $cohort = Cohort::factory()->make(['id' => 1]);
        $updateData = [
            'number' => 2,
            'start_date' => '2023-01-01',
            'end_date' => '2023-12-31',
        ];
        $this->cohortService
            ->shouldReceive('updateCohort')
            ->once()
            ->with(1, $updateData)
            ->andReturn($cohort->fill($updateData));
        // Authenticate the request
        $this->actingAs($this->user, 'api')->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('TestToken')->plainTextToken,
        ]);
        $response = $this->putJson('/api/cohorts/1', $updateData);
        $response->assertStatus(200)
                 ->assertJsonFragment(['number' => 2]);
    }

    /**
     * Test destroy method.
     */
    public function test_it_can_delete_a_cohort()
    {
        $this->cohortService
            ->shouldReceive('deleteCohort')
            ->once()
            ->with(1)
            ->andReturn(true);

        // Authenticate the request
        //$response = $this->actingAs($this->user, 'api')->deleteJson('/api/cohorts/1');
        $this->actingAs($this->user, 'api')->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('TestToken')->plainTextToken,
        ]);
        $response = $this->deleteJson('/api/cohorts/1');
        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Cohort deleted successfully']);
    }
}
