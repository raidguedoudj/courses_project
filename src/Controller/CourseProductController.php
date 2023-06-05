<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\CourseProduct;
use App\Form\CourseProductType;
use App\Repository\CourseProductRepository;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/course/product')]
class CourseProductController extends AbstractController
{

    #[Route('/', name: 'app_course_product_index', methods: ['GET'])]
    public function index(CourseProductRepository $courseProductRepository): Response
    {
        return $this->render('course_product/index.html.twig', [
            'course_products' => $courseProductRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_course_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CourseProductRepository $courseProductRepository): Response
    {
        $courseProduct = new CourseProduct();
        $form = $this->createForm(CourseProductType::class, $courseProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseProductRepository->save($courseProduct, true);

            return $this->redirectToRoute('app_course_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('course_product/new.html.twig', [
            'course_product' => $courseProduct,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_course_product_show', methods: ['GET'])]
    public function show(CourseProduct $courseProduct): Response
    {
        return $this->render('course_product/show.html.twig', [
            'course_product' => $courseProduct,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_course_product_edit', methods: ['GET', 'PUT'])]
    public function edit(Request $request, CourseProduct $courseProduct, CourseProductRepository $courseProductRepository): Response
    {
        $form = $this->createForm(CourseProductType::class, $courseProduct, [
            'method' => 'PUT'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $courseProductRepository->save($courseProduct, true);

            return $this->redirectToRoute('app_course_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('course_product/edit.html.twig', [
            'course_product' => $courseProduct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_course_product_delete', methods: ['POST'])]
    public function delete(Request $request, CourseProduct $courseProduct, CourseProductRepository $courseProductRepository): Response
    {
        /* if ($this->isCsrfTokenValid('delete'.$courseProduct->getId(), $request->request->get('_token'))) {
            $courseProductRepository->remove($courseProduct, true);
        } */

        return $this->redirectToRoute('app_course_product_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/validate/panier', name: 'app_course_product_validate_panier', methods: ['GET', 'POST'])]
    public function validatePanier(EntityManagerInterface $em, PanierRepository $panierRepository): Response
    {
        $paniers = $panierRepository->findAll();
        $course = new Course();
        $em->persist($course);
        $em->flush();
        
        foreach ($paniers as $panier) {
            $courseProduct = new CourseProduct();
            $courseProduct->setCourse($course);
            $courseProduct->setProduct($panier->getProduct());
            $courseProduct->setQuantity($panier->getQuantity());
            $em->persist($courseProduct);
            $em->remove($panier);
            $em->flush();
        }

        return $this->redirectToRoute('app_course_index', [], Response::HTTP_SEE_OTHER);
    }
}
