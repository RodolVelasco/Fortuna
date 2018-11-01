<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class SorteoRepository extends EntityRepository
{
    public function getActive()
    {
        // Comme vous le voyez, le délais est redondant ici, l'idéale serait de le rendre configurable via votre bundle
        $delay = new \DateTime();
        $delay->setTimestamp(strtotime('2 minutes ago'));

        $qb = $this->createQueryBuilder('u')
            ->where('u.lastActivity > :delay')
            ->setParameter('delay', $delay)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getSorteos()
    {
        $qb = $this->createQueryBuilder('u')
                ->leftJoin('u.primeraImage', 'img1')
                ->addSelect('img1')
                ->leftJoin('u.segundaImage', 'img2')
                ->addSelect('img2')
                ->leftJoin('u.terceraImage', 'img3')
                ->addSelect('img3')
        ;

        return $qb->getQuery()->getResult();
    }

    public function search($searchParam) {
        extract($searchParam);
       $qb = $this->createQueryBuilder('u')
                ->leftJoin('u.primeraImage', 'img1')
                ->addSelect('img1')
                ->leftJoin('u.segundaImage', 'img2')
                ->addSelect('img2')
                ->leftJoin('u.terceraImage', 'img3')
                ->addSelect('img3')
                ->where('u.tipoSorteo = 1 AND u.estado = 1')
            ;

        if(!empty($keyword))
            $qb->andWhere('u.titulo like :keyword or u.descripcion like :keyword')
                ->setParameter('keyword', '%'.$keyword.'%');

        if(!empty($ids))
            $qb->andWhere('u.id in (:ids)')->setParameter('ids', $ids);
        if(!empty($sortBy)){
            $sortBy = in_array($sortBy, array('titulo', 'descripcion', 'precio')) ? $sortBy : 'id';
            $sortDir = ($sortDir == 'DESC') ? 'DESC' : 'ASC';
            $qb->orderBy('u.' . $sortBy, $sortDir);
        }
        if(!empty($perPage)) $qb->setFirstResult(($page - 1) * $perPage)->setMaxResults($perPage);

       return new Paginator($qb->getQuery());
    }

    public function counter() {
        $qb = $this->createQueryBuilder('s')->select('COUNT(s)');
        return $qb->getQuery()->getSingleScalarResult();
        //$sql = 'SELECT count(u) FROM AppBundle\Entity\Sorteo u';
        //$query = $this->_em->createQuery($sql);
        //return $query->getOneOrNullResult();
    }
}
