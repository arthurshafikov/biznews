<?php

namespace App\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SluggerSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly ManagerRegistry $managerRegistry) {}

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setEntitySlug'],
            BeforeEntityUpdatedEvent::class => ['setEntitySlug'],
        ];
    }

    public function setEntitySlug(BeforeEntityPersistedEvent|BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!method_exists($entity, 'setSlug')) {
            return;
        }

        if (method_exists($entity, 'getTitle')) {
            $sluggableValue = $entity->getTitle();
        } else {
            $sluggableValue = $entity->getName();
        }
        $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z\d-]+/', '-', $sluggableValue)));

        $entityClass = get_class($entity);
        $repositoryClassName = "\\App\\Repository\\" .
            ltrim(substr($entityClass, strrpos($entityClass, '\\')), '\\') . "Repository";

        /**
         * @var $repositoryClass ServiceEntityRepository
         */
        $repositoryClass = new $repositoryClassName($this->managerRegistry);

        $slug = $baseSlug;
        for ($i = 1;; $i++) {
            $databaseObject = $repositoryClass->findOneBy([
                'slug' => $slug,
            ]);
            if ($databaseObject === null || $entity->getId() === $databaseObject->getId()) {
                break;
            }
            $slug = "$baseSlug-$i";
        }

        $entity->setSlug($slug);
    }
}
