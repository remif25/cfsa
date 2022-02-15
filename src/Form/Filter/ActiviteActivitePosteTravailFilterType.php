<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 13/03/2020
 * Time: 14:18
 *
 * Copyright 2018-2019, Rémi Fongaufier, All rights reserved.
 */

namespace App\Form\Filter;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\FilterType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormInterface;

class ActiviteActivitePosteTravailFilterType extends FilterType
{

    public function getParent()
    {
        return NumberType::class;
    }

    public function filter(QueryBuilder $queryBuilder, FormInterface $form, array $metadata)
    {
        $queryBuilder
            ->addSelect('actpdt')
            ->leftJoin('entity.activitePosteTravails', 'actpdt')
            ->groupBy('actpdt.activite')
            ->having('count(actpdt.activite) = :numberOf')
            ->setParameter('numberOf', $form->getData())
            ->getQuery()
            ->getResult();

    }
}
