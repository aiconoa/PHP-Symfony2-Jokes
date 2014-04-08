<?php

namespace Aiconoa\JokeBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class JokeRestController extends FOSRestController { //extending FOSRestController or Controller is required to access the service container
    // "get_jokes"     [GET] /jokes
    public function getJokesAction()
    {
        $jokes = $this->get("aiconoa_joke.jokeservice")->findAllJokes();
        //TODO here we should filter jokes and not return every user information, such as password...
        return array("jokes" => $jokes);
    }
//    /**
//     */
//    public function getJokeList() {
//        $jokes = $this->get("aiconoa_joke.jokeservice")->findAllJokes();
//        return array("jokes" => $jokes);
//    }
}