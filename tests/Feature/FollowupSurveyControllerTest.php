<?php

namespace Tests\Feature;

use App\Models\FollowupSurvey;
use App\Models\Survey;
use App\Models\Cohort;
use App\Models\Applicant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FollowupSurveyControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index method.
     */
    public function test_index_returns_all_followup_surveys()
    {
        $followupSurvey = FollowupSurvey::factory()->create();

        $response = $this->getJson('followupSurveys');

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $followupSurvey->id]);
    }

    /**
     * Test store method.
     */
    public function test_store_creates_a_new_followup_survey()
    {
        $cohort = Cohort::factory()->create();
        $applicant = Applicant::factory()->create(['company_name' => 'Acme Corp']);
        $survey = Survey::factory()->create([
            'applicant_name' => 'John Doe',
            'company_name' => 'Acme Corp',
            'cohort_id' => $cohort->id,
            'cohort_tag' => 'Spring 2024',
        ]);

        $data = [
            'survey_id' => $survey->id,
            'cohort_id' => $survey->cohort_id,
            'survey_tag' => 'Spring 2024 Follow-up',
            'date' => now()->toDateString(),
            'status' => 'Pending',
        ];

        $response = $this->postJson('followupSurveys/create', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['message' => 'Follow-up survey created successfully']);

        //$this->assertDatabaseHas('followup_surveys', ['survey_tag' => 'Spring 2024 Follow-up']);
    }

    /**
     * Test show method.
     */
    public function test_show_returns_the_specified_followup_survey()
    {
        $followupSurvey = FollowupSurvey::factory()->create();

        $response = $this->getJson('followupSurveys/'.$followupSurvey->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $followupSurvey->id]);
    }

    /**
     * Test update method.
     */
    public function test_update_modifies_the_specified_followup_survey()
    {
        $followupSurvey = FollowupSurvey::factory()->create();
        $survey = Survey::factory()->create();
        $cohort = Cohort::factory()->create();

        $data = [
            'survey_id' => $survey->id,
            'cohort_id' => $cohort->id,
            'survey_tag' => 'Summer 2024 Follow-up',
            'date' => now()->toDateString(),
            'status' => 'In Progress',
        ];

        $response = $this->putJson('followupSurveys.'. $followupSurvey->id , $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Follow-up survey updated successfully']);

        $this->assertDatabaseHas('followup_surveys', ['id' => $followupSurvey->id, 'survey_tag' => 'Summer 2024 Follow-up']);
    }

    /**
     * Test destroy method.
     */
    public function test_destroy_deletes_the_specified_followup_survey()
    {
        $followupSurvey = FollowupSurvey::factory()->create();

        $response = $this->deleteJson('followupSurveys/'. $followupSurvey->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Follow-up survey deleted successfully']);

        $this->assertDatabaseMissing('followup_surveys', ['id' => $followupSurvey->id]);
    }
}
