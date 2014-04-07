<?php

namespace Aiconoa\JokeBundle\Service;

use Aiconoa\JokeBundle\Entity\Joke;

class DoctrineJokeService implements JokeService {

    private $doctrine;

    function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param null $offset
     * @param null $limit
     * @param null $order
     * @return ResultSet of $jokes
     */
    public function findAllJokes($offset = null, $limit = null, $order = null)
    {
        $repository = $this->doctrine->getManager()->getRepository('AiconoaJokeBundle:Joke');
        return $repository->findAll();
    }

    public function findJoke($id)
    {
        $repository = $this->doctrine->getManager()->getRepository('AiconoaJokeBundle:Joke');
        return $repository->find((int) $id);
    }

    public function createOrUpdateJoke(Joke $joke)
    {
        $em = $this->doctrine->getManager();
        if($joke->getId() == null) {
            $em->persist($joke);
            $em->flush();
        } else {
            $joke = $em->merge($joke);
            $em->flush();
        }

        return $joke;
        // else throw new \Exception('Can not update Joke: id does not exist');

    }

    /**
     * @param int $id
     */
    public function deleteJoke($id)
    {
        $em = $this->doctrine->getManager();
        $joke = $em->getRepository('AiconoaJokeBundle:Joke')->find($id);
        $em->remove($joke);
        $em->flush();
    }

} 