<?php
namespace AlexDoctrine\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CustomersRepository extends EntityRepository
{

    /**
     *get all data as array
     * @return type array
     */
    public function findAllToArray ()
    {
        $dql = 'SELECT u FROM AlexDoctrine\Entity\Customers u ';
        $query = $this->getEntityManager()->createQuery($dql);
        $result = $query->getArrayResult();
        return $result;
    }

}

