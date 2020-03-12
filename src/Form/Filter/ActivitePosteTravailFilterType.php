<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 12/03/2020
 * Time: 16:45
 *
 * Copyright 2018-2019, Rémi Fongaufier, All rights reserved.
 */

namespace App\Form\Filter;


use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\FilterType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivitePosteTravailFilterType extends FilterType
{

    public function getParent()
    {
        return NumberType::class;
    }
    public function filter(QueryBuilder $queryBuilder, FormInterface $form, array $metadata)
    {
        $queryBuilder
            ->join('entity.activitePosteTravails', 'actpdt')
            ->groupBy('actpdt.posteTravail')
            ->andWhere('actpdt.posteTravail = test');

    }
}