<?php

namespace App\Controller;

use App\Entity\Profession;
use App\Form\ProfessionType;
use App\Repository\ProfessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\VarDumper\Cloner\Data;

#[Route('/profession')]
class ProfessionController extends AbstractController
{
    #[Route('/', name: 'app_profession_index', methods: ['GET'])]
    public function index(ProfessionRepository $professionRepository): Response
    {
        return $this->render('profession/index.html.twig', [
            'professions' => $professionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_profession_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProfessionRepository $professionRepository): Response
    {
        $profession = new Profession();
        $form = $this->createForm(ProfessionType::class, $profession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $professionRepository->save($profession, true);

            return $this->redirectToRoute('app_profession_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profession/new.html.twig', [
            'profession' => $profession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_profession_show', methods: ['GET','POST'])]
    public function show(Profession $profession,ProfessionRepository $professionRepository,int $id):Response
    {
        $users = $professionRepository->findAllUsers($id);
        
        // return $this->render('profession/show.html.twig', [
        //     'profession' => $profession,
        // ]);

        // return  $this->json($profession, 200, [], ['groups'=>'post:read']);
        return $this->render('profession/show.html.twig', [
            'users'=> $users,
            'profession' => $profession,
            'professions' => $professionRepository->findAll(),
        ]);
        // return  $this->Json([
        //     'status' => 'success',
        //     'content' => $professionRepository->find($profession)
        // ]);
        
    }

    #[Route('/{id}/edit', name: 'app_profession_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Profession $profession, ProfessionRepository $professionRepository): Response
    {
        $form = $this->createForm(ProfessionType::class, $profession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $professionRepository->save($profession, true);

            return $this->redirectToRoute('app_profession_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profession/edit.html.twig', [
            'profession' => $profession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_profession_delete', methods: ['POST'])]
    public function delete(Request $request, Profession $profession, ProfessionRepository $professionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profession->getId(), $request->request->get('_token'))) {
            $professionRepository->remove($profession, true);
        }

        return $this->redirectToRoute('app_profession_index', [], Response::HTTP_SEE_OTHER);
    }
}
