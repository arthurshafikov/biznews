<?php

namespace App\Controller\Admin;

use App\Entity\SubscribedEmail;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class SubscribedEmailCrudController extends AbstractCrudController
{
    public function configureFields(string $pageName): iterable
    {
        yield 'email';
        yield BooleanField::new('verified')->hideOnIndex();
        yield DateTimeField::new('created_at');
    }

    public static function getEntityFqcn(): string
    {
        return SubscribedEmail::class;
    }
}
