<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NYTControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_successful_response_from_mocked_api()
    {
        // Подменяем реальный HTTP-запрос фейковым ответом
        Http::fake([
            'https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json*' => Http::response([
                'results' => [
                    ['title' => 'Test Book', 'author' => 'Test Author']
                ]
            ], 200)
        ]);

        // Отправляем тестовый запрос
        $response = $this->getJson('/api/nyt-best-sellers?title=Test+Book');

        // Проверяем, что ответ корректный
        $response->assertStatus(200)
            ->assertJsonStructure(['results' => [['title', 'author']]]);
    }

    public function test_invalid_request_returns_validation_error()
    {
        $response = $this->getJson('/api/nyt-best-sellers?offset=-10');

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['offset']);
    }

    public function test_api_failure_returns_error_response()
    {
        Http::fake([
            'https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json*' => Http::response(null, 500)
        ]);

        $response = $this->getJson('/api/nyt-best-sellers?title=Invalid');

        $response->assertStatus(503)
            ->assertJson(['error' => 'Failed to fetch data from NYT API']);
    }
}
