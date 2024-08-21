<?php

namespace Tests\Feature\Controllers;

use App\Models\Applicant;
use App\Models\User;
use App\Models\Cohort;

use App\Services\ApplicantService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class ApplicantControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $applicantService;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->applicantService = Mockery::mock(ApplicantService::class);
        $this->app->instance(ApplicantService::class, $this->applicantService);

        $this->user = User::factory()->create();
    }
    /**
     * Test index method.
     */
    public function test_it_can_list_applicants()
    {
        $applicants = Applicant::factory()->count(3)->make();

        $this->applicantService
            ->shouldReceive('getAllApplicants')
            ->once()
            ->andReturn($applicants);

        $this->actingAs($this->user, 'api')->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('TestToken')->plainTextToken,
        ]);

        $response = $this->getJson('/api/applicants');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /**
     * Test store method.
     */
    public function test_it_can_create_an_applicant()
    {
        $lastCohortId = Cohort::latest('id')->value('id');

        $applicantData = [
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'company_name' => $this->faker->name,
            'cohort_id' => $lastCohortId,
        ];

        $this->applicantService
            ->shouldReceive('createApplicant')
            ->once()
            ->with($applicantData)
            ->andReturn(Applicant::make($applicantData));

        $this->actingAs($this->user, 'api')->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('TestToken')->plainTextToken,
        ]);

        $response = $this->postJson('/api/applicants', $applicantData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => $applicantData['name']]);
    }

    /**
     * Test show method.
     */
    public function test_it_can_show_a_single_applicant()
    {
        $applicant = Applicant::factory()->make(['id' => 1]);

        $this->applicantService
            ->shouldReceive('getApplicantById')
            ->once()
            ->with(1)
            ->andReturn($applicant);

        $this->actingAs($this->user, 'api')->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('TestToken')->plainTextToken,
        ]);

        $response = $this->getJson('/api/applicants/1');
        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => 1]);
    }

    /**
     * Test update method.
     */
    public function test_it_can_update_an_applicant()
    {
        $applicant = Applicant::factory()->make(['id' => 1]);

        $updateData = [
            'first_name' => 'Updated Name',
            'last_name' => 'Updated Name',
            'email' => 'updated@example.com',
            'company_name' => 'updated company name',
      ];

        $this->applicantService
            ->shouldReceive('updateApplicant')
            ->once()
            ->with(1, $updateData)
            ->andReturn($applicant->fill($updateData));

        $this->actingAs($this->user, 'api')->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('TestToken')->plainTextToken,
        ]);

        $response = $this->putJson('/api/applicants/1', $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $updateData['name']]);
    }

    /**
     * Test destroy method.
     */
    public function test_it_can_delete_an_applicant()
    {
        $this->applicantService
            ->shouldReceive('deleteApplicant')
            ->once()
            ->with(1)
            ->andReturn(true);

        $this->actingAs($this->user, 'api')->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->createToken('TestToken')->plainTextToken,
        ]);

        $response = $this->deleteJson('/api/applicants/1');

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Applicant deleted successfully']);
    }

   
    // public function test_it_can_filter_applicants()
    // {
    //     $filterData = [
    //         'filters' => ['gender' => 'female']
    //     ];

    //     $applicants = Applicant::factory()->count(2)->make();

    //     $this->applicantService
    //         ->shouldReceive('filterApplicants')
    //         ->once()
    //         ->with($filterData, 'John')
    //         ->andReturn($applicants);

    //     $this->actingAs($this->user, 'api')->withHeaders([
    //         'Authorization' => 'Bearer ' . $this->user->createToken('TestToken')->plainTextToken,
    //     ]);

    //     $response = $this->postJson('/api/applicants/filter', $filterData);

    //     $response->assertStatus(200)
    //              ->assertJsonCount(2);
    // }

   
    // public function test_it_can_get_filter_options()
    // {
    //     $filterOptions = [
    //         'statuses' => ['active', 'inactive'],
    //         'genders' => ['male', 'female'],
    //         // Add more filter options as needed
    //     ];

    //     $this->applicantService
    //         ->shouldReceive('getFilterOptions')
    //         ->once()
    //         ->andReturn($filterOptions);

    //     $this->actingAs($this->user, 'api')->withHeaders([
    //         'Authorization' => 'Bearer ' . $this->user->createToken('TestToken')->plainTextToken,
    //     ]);

    //     $response = $this->getJson('/api/applicants/filter-options');

    //     $response->assertStatus(200);
    //           //   ->assertJsonFragment(['statuses' => ['active', 'inactive']]);
    // }
}
