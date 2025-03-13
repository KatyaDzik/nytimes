<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NYTControllerTest extends TestCase
{
    public function test_successful_response_from_nyt_api(): void
    {
        $response = $this->getJson('/api/best-sellers');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'copyright',
            'num_results',
            'results'
        ]);
    }

    public function test_successful_response_from_nyt_api_with_filter(): void
    {
        $response = $this->getJson('/api/best-sellers?isbn=0399178570');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'OK',
            'copyright' => 'Copyright (c) 2025 The New York Times Company.  All Rights Reserved.',
            'num_results' => 0,
            'results' => [],
        ]);
    }

    public function test_successful_response_from_fake_nyt_api(): void
    {
        Http::fake([
            config(['services.nyt.base_url']) => Http::response([
                "status" => "OK",
                "copyright" => "Copyright (c) 2025 The New York Times Company.  All Rights Reserved.",
                "num_results" => 36722,
                'results' => [
                    [
                        "title" => "\"I GIVE YOU MY BODY ...\"",
                        "description" => "The author of the Outlander novels gives tips on writing sex scenes, drawing on examples from the books.",
                        "contributor" => "by Diana Gabaldon",
                        "author" => "Diana Gabaldon",
                        "contributor_note" => "",
                        "price" => "0.00",
                        "age_group" => "",
                        "publisher" => "Dell",
                        "ranks_history" => [],
                    ]
                ]
            ], 200),
        ]);

        $response = $this->getJson('/api/best-sellers');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'copyright',
            'num_results',
            'results'
        ]);
    }

    public function test_wrong_credentials_response_from_nyt_api(): void
    {
        config(['services.nyt.api_key' => 'invalid_key']);

        $response = $this->getJson('/api/best-sellers');

        $response->assertStatus(503)
            ->assertJson(['error' => 'Failed to fetch data from NYT API']);
    }

    public function test_wrong_param_response_from_nyt_api(): void
    {
        $response = $this->getJson(
            '/api/best-sellers?author=AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA&isbn=123456&title=AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA&offset=2',
        );

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'The author field must not be greater than 255 characters. (and 3 more errors)',
                'errors' => [
                    'author' => [
                        'The author field must not be greater than 255 characters.'
                    ],
                    'isbn' => [
                        'The isbn field format is invalid.'
                    ],
                    'title' => [
                        'The title field must not be greater than 255 characters.'
                    ],
                    'offset' => [
                        'The offset field must be a multiple of 20.'
                    ]
                ]
            ]);
    }
}
