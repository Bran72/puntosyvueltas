<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, ProductRepository $productRepository)
    {
        return $this->render('home/index.html.twig', [
            'products' => $productRepository->findBy([], ['date'=>'DESC']),
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('home/contact.html.twig');
    }

    /**
     * @Route("/atelier", name="atelier")
     */
    public function atelier()
    {
        return $this->render('home/atelier.html.twig');
    }

    /**
     * @Route("/creation/{id}", name="creation", methods={"GET"})
     */
    public function creation(Product $product, ProductRepository $productRepository)
    {
        return $this->render('home/creation.html.twig', [
            'product' => $product,
            'products' => $productRepository->findBy([], ['date'=>'DESC']),
        ]);
    }
}
