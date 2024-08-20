<?php

namespace Tests\Feature;

use App\Models\Cohort;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CohortControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(); // Assuming you have a User factory
    }

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_it_can_list_cohorts()
    {
        // Seed the database with some cohorts
        Cohort::factory()->count(3)->create();

        $response = $this->actingAs($this->user)->getJson('/api/cohorts');

        $response->assertStatus(200)
                 ->assertJsonCount(3)
                 ->assertJsonStructure([
                     '*' => ['id', 'name', 'description', 'created_at', 'updated_at']
                 ]);
    }

    /**
     * Test the store method.
     *
     * @return void
     */
    public function test_it_can_create_a_cohort()
    {
        $cohortData = [
            'name' => 'Test Cohort',
            'description' => 'This is a test cohort',
        ];

        $response = $this->actingAs($this->user)->postJson('/api/cohorts', $cohortData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Test Cohort'])
                 ->assertJsonStructure([
                     'message',
                     'cohort' => ['id', 'name', 'description', 'created_at', 'updated_at']
                 ]);

        $this->assertDatabaseHas('cohorts', $cohortData);
    }

    /**
     * Test the show method.
     *
     * @return void
     */
    public function test_it_can_show_a_single_cohort()
    {
        $cohort = Cohort::factory()->create();

        $response = $this->actingAs($this->user)->getJson('/api/cohorts/' . $cohort->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $cohort->name])
                 ->assertJsonStructure(['id', 'name', 'description', 'created_at', 'updated_at']);
    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_it_can_update_a_cohort()
    {
        $cohort = Cohort::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'description' => 'Updated description',
        ];

        $response = $this->actingAs($this->user)->putJson('/api/cohorts/' . $cohort->id, $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Name'])
                 ->assertJsonStructure([
                     'message',
                     'cohort' => ['id', 'name', 'description', 'created_at', 'updated_at']
                 ]);

        $this->assertDatabaseHas('cohorts', $updateData);
    }

    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function test_it_can_delete_a_cohort()
    {
        $cohort = Cohort::factory()->create();

        $response = $this->actingAs($this->user)->deleteJson('/api/cohorts/' . $cohort->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Cohort deleted successfully']);

        $this->assertDatabaseMissing('cohorts', ['id' => $cohort->id]);
    }
}
//php artisan test --filter=CohortControllerTest
