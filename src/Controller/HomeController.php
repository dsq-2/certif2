<?php

namespace App\Controller;

use App\Entity\Profession;
use App\Entity\Projet;
use App\Entity\SearchFilter;
use App\Entity\User;
use App\Form\SearchFilterType;
use App\Repository\ProfessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name:'home')]
    public function index(EntityManagerInterface $em, Request $request,PaginatorInterface $paginator ): Response
    {
        $search = new SearchFilter();
        $form = $this->createForm(SearchFilterType::class, $search);
        $form->handleRequest($request);

        $professions = $em->getRepository(Profession::class)->findAll();
        $projets = $em->getRepository(Projet::class)->findAll();
        $users =$paginator->paginate($em->getRepository(User::class)->findAllArtisans($search),
        $request->query->getInt('page',1),5);
        // $usermetier = $em->getRepository(user::class)->userByProfession($search);
        // dd($users);

        
        return $this->render('home/index.html.twig', [
            'users' => $users,
            'professions' => $professions,
            'projet' => $projets,
            'form' => $form->createView()
        
    ]);
    }












    // #[Route('/home', name: 'app_profession')]
    // public function AllMetiers(ManagerRegistry $doctrine):Response
    // {
    //     $metiers = $doctrine->getRepository(ProfessionRepository::class)->findAll();
    //     dd($metiers);
    //     return $this->render('home/index.html.twig',[
    //         'metiers' => '$metiers'
    //     ]);
    // }
}
