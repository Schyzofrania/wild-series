<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Program;

    /**
    * @Route("/categories", name="category_")
    */

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {   
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $category
        ]);
    }
    /**
     * Getting a program by id
     *
     * @Route("/{categoryName}", name="show")
     * @return Response
     */
    public function show(string $categoryName): Response
    {   
        if (!$categoryName) {
            throw $this->createNotFoundException(
                'No program with id : '.$categoryName.' found in program\'s table.'
            );
        }
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        $program = $this->getDoctrine()
        ->getRepository(Program::class);    

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'program' => $program,
        ]);
    }
}
