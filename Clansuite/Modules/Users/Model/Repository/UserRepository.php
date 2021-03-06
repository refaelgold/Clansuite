<?php

namespace Repository;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    public function getLastRegisteredUsers($limit)
    {
        $q = $this->_em->createQueryBuilder();
        $q->select('
                            partial u.{user_id, nick, email, country, joined}
                       ')
            ->from('Entity\User', 'u')
            ->where('u.activated = 1')
            ->orderBy('u.joined', 'DESC')
            ->setMaxResults( $limit );

        $query = $q->getQuery();
        $result = $query->getArrayResult();

        #\\Koch\Debug\Debug::printR( $result );

         return $result;
    }

}
