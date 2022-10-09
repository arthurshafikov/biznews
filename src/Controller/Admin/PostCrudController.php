<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield 'title';
        yield TextField::new('slug')->hideOnIndex();
        yield TextField::new('image')->hideOnIndex();
        yield TextField::new('content')->hideOnIndex();
        yield AssociationField::new('category')->autocomplete();
        yield AssociationField::new('tags')
            ->autocomplete()
            ->setFormTypeOption('by_reference', false)
            ->hideOnIndex();
        yield 'created_at';
    }
}
