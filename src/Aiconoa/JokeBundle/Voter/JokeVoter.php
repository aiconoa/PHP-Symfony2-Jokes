<?php

namespace Aiconoa\JokeBundle\Voter;

use Symfony\Component\Security\Core\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class JokeVoter
 * For more informations on voters, see http://symfony.com/doc/current/cookbook/security/voters_data_permission.html
 * @package Acme\DemoBundle\Security\Authorization\Voter
 */
class JokeVoter implements VoterInterface
{
    const ADD = 'add';
    const EDIT = 'edit';
    const DELETE = 'delete';

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, array(
                self::ADD,
                self::EDIT,
                self::DELETE,
            ));
    }

    public function supportsClass($class)
    {
        $supportedClass = 'Aiconoa\JokeBundle\Entity\Joke';

        return $supportedClass === $class || is_subclass_of($class, $supportedClass);
    }

    /**
     * @var \Aiconoa\JokeBundle\Entity\Joke $joke
     */
    public function vote(TokenInterface $token, $joke, array $attributes)
    {
        // check if class of this object is supported by this voter
        if (!$this->supportsClass(get_class($joke))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // check if the voter is used correct, only allow one attribute
        // this isn't a requirement, it's just one easy way for you to
        // design your voter
        if(1 !== count($attributes)) {
            throw new InvalidArgumentException(
                'Only one attribute is allowed for ADD or EDIT'
            );
        }

        // set the attribute to check against
        $attribute = $attributes[0];

        // check if the given attribute is covered by this voter
        if (!$this->supportsAttribute($attribute)) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        // get current logged in user
        $user = $token->getUser();

        // make sure there is a user object (i.e. that the user is logged in)
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }

        switch($attribute) {
            case 'add':
                    //every authenticated user can create a new joke
                    return VoterInterface::ACCESS_GRANTED;
                break;

            case 'edit':
                // the author is the only one who can edit a joke
                if ($user->getId() === $joke->getAuthor()->getId()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
            case 'delete':
                // the author is the only one who can delete a joke
                if ($user->getId() === $joke->getAuthor()->getId()) {
                    return VoterInterface::ACCESS_GRANTED;
                }
                break;
        }
    }
}