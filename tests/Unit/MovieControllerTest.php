<?php

namespace Tests\Unit;

use App\Http\Controllers\MovieController;
use PHPUnit\Framework\TestCase;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MovieControllerTest extends TestCase
{

    private $controller;

    protected function setUp(): void
    {
        $this->controller = new MovieController();
    }

    public function test_that_data_validator_allows_valid_data(): void
    {
        $data = [
            'title' => ['Title'],
            'rated' => ['Rated'],
            'genre' => ['Genre']];

        $viable = $this->controller->isApiDataViable($data);

        $this->assertTrue($viable);
    }

    public function test_that_data_validator_fails_invalid_data(): void
    {
        $data = ['title' => 'N/A'];
        $viable = $this->controller->isApiDataViable($data);
        $this->assertFalse($viable);
    }

    public function test_sucessful_api_calls_data_return_true(): void
    {
        $api = ['Title' => 'The Matrix', 'Response' => true];
        $check = $this->controller->didApiFindData($api);
        $this->assertTrue($check);
    }

    public function test_unsucessful_api_calls_return_false(): void
    {
        $api = ['Title' => 'The Matrix', 'Response' => False];
        $check = $this->controller->didApiFindData($api);
        $this->assertFalse($check);
    }

    public function test_if_early_redirect_skipped(): void
    {
        $getApiStatus = true;
        $check = $this->controller->redirectEarlyOnApiFail($getApiStatus);
        $this->assertEquals($check, true);
    }

    public function test_a_basic_request(): void
    {
        $response = $this->get('/lucky');
        $response->assertStatus(200);
    }





    /**
     *
     *  test calls remote api
     *  should be teated as an optional one
     *
     *  Could expand with assertJson
     *
     * @group skip
     */
    public function test_the_api_service_returns_data()
    {
        $check = $this->controller->getMovieDataFromApi('John wick', '2798607a');
        $this->assertSame($check['Response'], 'True');
    }

    /**
     * @group skip
     */
    public function test_db_row_load_finds_valid_entry(): void
    {
        $movie = $this->controller->loadSingleMovieFromDbByTitle('thor');
        $this->assertTrue($movie);
    }

    /**
     *
     * Db Dependant Tests have an issue with class reflection
     *  could change local settings to get round it,
     * but really the correct thing is to refactor the
     * tested code for better dependency injection
     *
     * @group skip
     */
    public function test_basic_db_lookup_finds_valid_entry(): void
    {
        $movie = $this->controller->lookup('thor');
        $this->assertTrue($movie);
    }

    /**
     * @group skip
     */
    public function test_lookup_returns_false_if_movie_not_valid(): void
    {
        $movie = $this->controller->lookup('dfjhdfjhdsjfhsjk');
        $this->assertTrue($movie);

    }



}
