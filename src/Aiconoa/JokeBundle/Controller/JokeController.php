<?php

namespace Aiconoa\JokeBundle\Controller;

use Aiconoa\JokeBundle\Entity\Joke;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    /**
     * no need to call for render if use the Template annotation
     * @Template()
     */
    public function deleteAction($id)
    {
        $joke = $this->get("aiconoa_joke.jokeservice")->findJoke($id);
        if (false === $this->get('security.context')->isGranted('add', $joke)) {
            throw new AccessDeniedException();
        }
        $joke = $this->get("aiconoa_joke.jokeservice")->deleteJoke($id);
        return $this->redirect($this->generateUrl('aiconoa_joke_list'));
    }

    /**
     * @Template("AiconoaJokeBundle:Joke:addOrEdit.html.twig")
     */
    public function addAction(Request $request)
    {

        $joke = new Joke();
        // only authors can add a new joke
        if (false === $this->get('security.context')->isGranted('add', $joke)) {
            throw new AccessDeniedException();
        }

        return $this->addOrEdit($request, $joke, $this->generateUrl('aiconoa_joke_add'));
    }

    /**
     * @Template("AiconoaJokeBundle:Joke:addOrEdit.html.twig")
     */
    public function editAction(Request $request, $id)
    {
        $joke = $this->get("aiconoa_joke.jokeservice")->findJoke($id);
        // only authors can add a new joke
        if (false === $this->get('security.context')->isGranted('edit', $joke)) {
            throw new AccessDeniedException();
        }
        return $this->addOrEdit($request, $joke, $this->generateUrl('aiconoa_joke_edit', array('id' => $id)));
    }

    protected function addOrEdit(Request $request, $joke, $url) {
        $form = $this->buildJokeForm($joke, $url);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $joke = $form->getData();
                $joke->setAuthor($this->get('security.context')->getToken()->getUser());
                // @Template is ignored if Response object is returned
                $this->get("aiconoa_joke.jokeservice")->createOrUpdateJoke($joke);
                return $this->redirect($this->generateUrl('aiconoa_joke_list'));
            }
        }
        return array('form' => $form->createView());
    }

    protected function buildJokeForm($joke, $url)
    {
        $form = $this->createFormBuilder($joke, array(
                            'action' => $url,
                            'method' => 'POST'))
            ->add('title', 'text')
            ->add('text', 'textarea')
            ->add('valider', 'submit')
            ->getForm();

        return $form;
    }
}
