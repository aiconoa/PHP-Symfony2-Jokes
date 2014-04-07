<?php

namespace Aiconoa\JokeBundle\Service;
use Aiconoa\JokeBundle\Entity\Joke;

interface JokeService  {

    public function findAllJokes($offset, $limit, $order);

    public function findJoke($id);

    public function createOrUpdateJoke(Joke $joke);

    public function deleteJoke($id);
}