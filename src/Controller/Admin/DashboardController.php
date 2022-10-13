<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Setting;
use App\Entity\SubscribedEmail;
use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Biznews');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Go to Website', 'fa fa-home', 'app_home');
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Posts', 'fas fa-list', Post::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-list', Tag::class);
        yield MenuItem::linkToCrud('Subscribed Emails', 'fas fa-envelope', SubscribedEmail::class);
        yield MenuItem::linkToCrud('Comments', 'fas fa-comment', Comment::class);
        yield MenuItem::linkToCrud('Settings', 'fas fa-gears', Setting::class);
    }
}
