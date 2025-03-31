<?php

namespace Tests\Feature;

use App\Models\TestCase;
use App\Models\TestResult;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestResultControllerTest extends TestCase
{
    use RefreshDatabase; // Очищает БД перед каждым тестом

    /** @test */
    public function it_shows_test_results_list()
    {
        $testResult = TestResult::factory()->create();

        $response = $this->get(route('admin.test_results.index'));

        $response->assertStatus(200);
        $response->assertSee($testResult->id);
    }

    /** @test */
    public function it_shows_specific_test_case_results()
    {
        $testCase = TestCase::factory()->create();
        $testResult = TestResult::factory()->create(['test_case_id' => $testCase->id]);

        $response = $this->get(route('admin.test_results.show', $testCase));

        $response->assertStatus(200);
        $response->assertSee($testResult->status);
    }

    /** @test */
    public function it_stores_a_new_test_result()
    {
        $testCase = TestCase::factory()->create();

        $response = $this->postJson(route('admin.test_results.store'), [
            'test_case_id' => $testCase->id,
            'execution_time' => 1.23,
            'status' => 'success',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('test_results', ['test_case_id' => $testCase->id, 'status' => 'success']);
    }

    /** @test */
    public function it_deletes_a_test_result()
    {
        $testResult = TestResult::factory()->create();

        $response = $this->deleteJson(route('admin.test_results.destroy', $testResult));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('test_results', ['id' => $testResult->id]);
    }
}
