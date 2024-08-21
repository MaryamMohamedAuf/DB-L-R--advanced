<?php

namespace Tests\Feature;

use App\Models\Survey;
use App\Models\Cohort;
use App\Models\Applicant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurveyControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index method.
     */
    public function test_index_returns_all_surveys()
    {
        $survey = Survey::factory()->create();

        $response = $this->getJson(route('surveys.index'));

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $survey->id]);
    }

    /**
     * Test store method.
     */
    public function test_store_creates_a_new_survey()
    {
        $cohort = Cohort::factory()->create();
        $applicant = Applicant::factory()->create(['company_name' => 'Acme Corp']);

        $data = [
            'applicant_name' => 'John Doe',
            'company_name' => 'Acme Corp',
            'cohort_id' => $cohort->id,
            'cohort_tag' => 'Spring 2024',
        ];

        $response = $this->postJson(route('surveys.store'), $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['message' => 'Survey created successfully']);
                 
        $this->assertDatabaseHas('surveys', ['applicant_name' => 'John Doe']);
    }

    /**
     * Test show method.
     */
    public function test_show_returns_the_specified_survey()
    {
        $survey = Survey::factory()->create();

        $response = $this->getJson(route('surveys.show', $survey->id));

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $survey->id]);
    }

    /**
     * Test update method.
     */
    public function test_update_modifies_the_specified_survey()
    {
        $survey = Survey::factory()->create();
        $cohort = Cohort::factory()->create();
        $applicant = Applicant::factory()->create(['company_name' => 'Acme Corp']);
        $data = [
            'applicant_name' => 'Jane Doe',
            'company_name' => 'Acme Corp',
            'cohort_id' => $cohort->id,
            'cohort_tag' => 'Summer 2024',
        ];

        $response = $this->putJson(route('surveys.update', $survey->id), $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Survey updated successfully']);
                 
        $this->assertDatabaseHas('surveys', ['id' => $survey->id, 'applicant_name' => 'Jane Doe']);
    }

    /**
     * Test destroy method.
     */
    public function test_destroy_deletes_the_specified_survey()
    {
        $survey = Survey::factory()->create();

        $response = $this->deleteJson(route('surveys.destroy', $survey->id));

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Survey deleted successfully']);
                 
        $this->assertDatabaseMissing('surveys', ['id' => $survey->id]);
    }
}
