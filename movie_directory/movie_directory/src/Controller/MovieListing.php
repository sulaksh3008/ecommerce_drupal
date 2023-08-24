<?php

namespace Drupal\movie_directory\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\dblog\Plugin\views\wizard\Watchdog;

class MovieListing extends ControllerBase
{

    // public function view()
    // {
    //     $this->listMovies();
    //     $content = [];
    //     $content = $this->listMovies();
    //     \Drupal::logger('content')->error($content[0]['name']);
    //     // $content['name'] = 'Oppenheimer';

    //     return [
    //         '#theme' => 'movie-listing',
    //         '#content' => $content,
    //     ];
    // }

    public function listMovies()
    {
        /**@var \Drupal\movie_directory\MovieAPIConnector $movie_api_connector_service */
        \Drupal::logger('test')->notice('test');
        $movie_api_connector_service = \Drupal::service('movie_directory.api_connector');
        $movie_list = $movie_api_connector_service->discoverMovies();
        \Drupal::logger('movielist')->error($movie_list[0]['title']);
        return [
            '#theme' => 'movie-listing',
            '#content' => $movie_list,
        ];

        // if (!empty($movie_list->results)) {
        //     return $movie_list->results;
        // }
        // return [];
    }
}
