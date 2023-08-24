<?php

namespace Drupal\movie_directory;

use Drupal\Core\Http\ClientFactory;
use Drupal\dblog\Plugin\views\wizard\Watchdog;
use Drupal\migrate\Plugin\migrate\process\Get;
use GuzzleHttp\Client;

class MovieAPIConnector
{
    private $client;
    private $query;
    public function __construct(ClientFactory $client)
    {
        $movie_api_config = \Drupal::state()->get(\Drupal\movie_directory\Form\MovieAPI::MOVIE_API_CONFIG_PAGE);
        $api_url = ($movie_api_config['api_base_url']) ?: 'https://fakestoreapi.com';
        $api_key = ($movie_api_config['api_key']) ?: '';

        $query = ['api_key' => $api_key];

        $this->query = $query;
        $this->client = $client->fromOptions(
            [
                'base_uri' => $api_url,
                'query' => $query
            ]
        );
    }

    public function discoverMovies()
    {
        $data = [];
        $endpoint = '/products';
        $options = ['query' => $this->query];

        try {
            $request = $this->client->get($endpoint, $options);
            $response = $request->getBody()->getContents();
            $responseData = json_decode($response, true);
            // if ($responseData) {
            //     $data = $responseData['results'];
            //     \Drupal::logger('succ')->error($data[0]['name']);
            // } else {
            //     \Drupal::logger('datA')->error('Invalid or missing "result" in API response.');
            // }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Handle the exception. You can log the error message or perform other actions.
            // watchdog_exception('movie_directory', $e);
        }

        return $responseData;
    }
}
