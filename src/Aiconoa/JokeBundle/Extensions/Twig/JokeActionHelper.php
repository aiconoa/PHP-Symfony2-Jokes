<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 08/04/14
 * Time: 19:11
 */

namespace Aiconoa\JokeBundle\Extensions\Twig;

use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContext;

class JokeActionHelper extends \Twig_Extension {

    private $router;
    private $securityContext;

    function __construct(Router $router, SecurityContext $securityContext)
    {
        $this->router = $router;
        $this->securityContext = $securityContext;
    }


    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "joke_actions_helper";
    }

    public function getFunctions()
    {
        return array(
            'joke_actions'  => new \Twig_Function_Method($this,
                                                         'generateJokeActionHTML',
                                                          array('is_safe' => array('html')) // no need for | raw filter in twig templates
                ),
        );
    }

    public function generateJokeActionHTML($joke, $actions) {
        $html = "";

        if (isset($actions['add'])
        && $this->securityContext->isGranted('add', $joke)) {
            $html .= '<a class="btn btn-success" href="'.$this->router->generate('aiconoa_joke_add').'" role="button">'
                . $actions['add']
                .'</a>';
        }

        if (isset($actions['edit'])
        && $this->securityContext->isGranted('edit', $joke)) {
            $html .= '<a class="btn btn-default" href="'.$this->router->generate('aiconoa_joke_edit', array('id' => $joke->getId())).'" role="button">'
                . $actions['edit']
                .'</a>';
        }

        if (isset($actions['delete'])
        && $this->securityContext->isGranted('delete', $joke)) {
            $html .= '<a class="btn btn-danger" href="'.$this->router->generate('aiconoa_joke_delete', array('id' => $joke->getId())).'" role="button">'
            . $actions['delete']
            .'</a>';
        }

        return $html;
    }
} 