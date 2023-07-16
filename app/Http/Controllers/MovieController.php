<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * Class MovieController
 * @package App\Http\Controllers
 */
class MovieController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request)
    {

        $titleFromSearch = $request->get('title');

        if ($this->isThisMovieInDb($titleFromSearch)) {
            // Movie title found in db, skip Api call.
        } else {

            $apiDataAsJson = $this->getMovieDataFromApi($titleFromSearch, config('services.omdb.key'));
            $getApiStatus = $this->didApiFindData($apiDataAsJson);

            if ($getApiStatus == false) {
                return view('find-movie');
            }

            $formattedData = $this->formatMovieData($apiDataAsJson);
            $dataIsViable = $this->isApiDataViable($formattedData);

            $this->storeViableMovieRecord($dataIsViable, $formattedData);

        }

        $rowFoundInDb = $this->loadSingleMovieFromDbByTitle($titleFromSearch);

        // last safety check
        if ($rowFoundInDb) {
            return view('find-movie')->withData($rowFoundInDb);
        } else {
            return view('find-movie');
        }

    }

    /**
     * @param $title
     * @return bool
     */
    public function isThisMovieInDb($title)
    {
        return $this->dbMovieLookupByTitle($title);
    }

    /**
     * @param $search
     * @return bool
     */
    public function dbMovieLookupByTitle($search)
    {
        $dbMoviesCount = DB::table('movies')->where('title', 'LIKE', '%' . $search . '%')->count();

        if ($dbMoviesCount == 0) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * @param $title
     * @param $apiKey
     * @return array|mixed
     */
    public function getMovieDataFromApi($title, $apiKey)
    {
        $urlSafeTitle = urlencode($title);
        if ($urlSafeTitle) {
            $response = Http::get('http://www.omdbapi.com/', [
                'apikey' => $apiKey,
                't' => $urlSafeTitle,
                'plot' => 'full',]);
        }
        return $response->json();
    }

    /**
     * @param $api
     * @return bool
     */
    public function didApiFindData($api)
    {

        if ($api['Response'] == 'True') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $api
     * @return array
     */
    public function formatMovieData($api)
    {
        return [
            'title' => $api['Title'],
            'rated' => $api['Rated'],
            'genre' => $api['Genre'],
            'year' => $api['Year'],
            'plot' => $api['Plot'],
            'poster' => $api['Poster'],
            'metascore' => $api['Metascore']];
    }

    /**
     * @param $api
     * @return bool
     */
    public function isApiDataViable($api)
    {
        $viable = true;
        foreach ($api as $field) {
            if ($field == 'N/A') {
                $viable = false;
            }
        }
        return $viable;
    }

    /**
     * @param bool $dataIsViable
     * @param array $formattedData
     */
    public function storeViableMovieRecord(bool $dataIsViable, array $formattedData): void
    {
        if ($dataIsViable) {
            Movie::create($formattedData);
        }
    }

    /**
     * @param $title
     * @return \Illuminate\Support\TFirstDefault|\Illuminate\Support\TValue
     */
    public function loadSingleMovieFromDbByTitle($title)
    {
        $dbData = DB::table('movies')->where('title', 'LIKE', '%' . $title . '%')->get();
        return $dbData->first();
    }

}
