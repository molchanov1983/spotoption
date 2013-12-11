<?php
namespace AlexDoctrine\Service;

use Doctrine\ORM\EntityManager;

class EMService
{
    protected $em;

    public function setEntityManager(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getEntityManager()
    {
        if (null === $this->em)
        {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

}