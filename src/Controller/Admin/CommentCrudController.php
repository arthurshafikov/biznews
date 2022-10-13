<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommentCrudController extends AbstractCrudController
{
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideWhenUpdating();
        yield AssociationField::new('post')->autocomplete();
        yield AssociationField::new('user')->autocomplete();
        yield TextField::new('content')->formatValue(
            fn ($value) => substr($value, 0, 10) . "..."
        );
        yield 'created_at';
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->disable(Action::NEW);
    }

    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }
}
