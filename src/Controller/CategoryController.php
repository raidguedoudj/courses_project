<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/categories', name: 'categories_list')]
    public function index(): Response
    {
        $categories = $this->em->getRepository(Category::class)->findBy([], ['createdAt' => 'DESC']);

        return $this->render('category/index.html.twig', compact('categories'));
    }

    #[Route('/categories/create', name: 'categories_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $this->em->persist($category);
           $this->em->flush();

           return $this->redirectToRoute('categories_list');
        }

        return $this->render('category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
