<?php

namespace Aiconoa\JokeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class JokeController extends Controller
{

    public function listAction()
    {
        $jokes = $this->get("aiconoa_joke.jokeservice")->findAllJokes();
        return $this->render(
            'AiconoaJokeBundle:Joke:list.html.twig',
            array("jokes" => $jokes)
        );
    }

    /**
     * no need to call for render if use the Template annotation
     * @Template()
     */
    public function showAction($id)
    {
        $joke = $this->get("aiconoa_joke.jokeservice")->findJoke($id);
        return array('joke' => $joke);
    }
}
