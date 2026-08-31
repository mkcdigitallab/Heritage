<?php

namespace App;


abstract class AbstractEntity
{
    protected \DateTime $dateCreation;

    public function __construct(?\DateTime $dateCreation = null)
    {
        $this->dateCreation = $dateCreation ?? new \DateTime();
    }

   

    public function getDateCreation(): \DateTime
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }
}