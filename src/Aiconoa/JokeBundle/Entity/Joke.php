<?php

namespace Aiconoa\JokeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Joke {
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title = "";

    /**
     * @ORM\Column(name="text", type="string")
     */
    private $text = "";

    /**
     * @ORM\Column(name="posted_on", type="datetime", nullable=true)
     */
    private $postedOn;

    //we will soon add $category and $author

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $postedOn
     */
    public function setPostedOn($postedOn)
    {
        $this->postedOn = $postedOn;
    }

    /**
     * @return string
     */
    public function getPostedOn()
    {
        return $this->postedOn;
    }

    public function __toString()
    {
        return "Joke { \n"
        . "id: " . $this->id . "\n"
        . "title: " . $this->title . "\n"
        . "text: " . $this->text . "\n"
        . "}\n";
    }

    /**
     * @return array
     */
    public function getArrayCopy() {
        return  array(
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'posted_on' => $this->postedOn,
        );
    }
}