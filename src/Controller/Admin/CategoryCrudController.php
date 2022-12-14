<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CategoryCrudController extends AbstractCrudController
{
    public function configureFields(string $pageName): iterable
    {
        yield 'name';
        yield AssociationField::new('posts')->autocomplete()->hideWhenUpdating();
    }

    public static function getEntityFqcn(): string
    {
        return Category::class;
    }
}
