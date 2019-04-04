<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        $i = 0;
        $photos = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $file = $form['Photos']->getData();

            if((!isset($file))){
                //$user->setUserImage('assets/img/default-user.png');
            } else {
                //dump($file);
                //s'assurer que le fait de n'avoir qu'un seul fichier ne casse pas la boucle foreach
                foreach ($file as $result){
                    $fileName = 'product-' . $product->getId() . '-'.$i.'.' . $result->guessExtension(); //On renomme l'image avec l'id du user connecté (pas le pseudo pour éviter les caractères spéciaux)

                    try {
                        $result->move(
                            $this->getParameter('products_directory'),
                            $fileName
                        );
                        array_push($photos, $fileName);
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    $i++;
                }

                $product->setPhotos($photos);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        //$file = $form['Photos']->getData();
        //dump($file);

        $i = 0;
        $photos = $product->getPhotos();
        //dump($photos);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['Photos']->getData();
            dump($file);
            //$this->getDoctrine()->getManager()->flush();

            //BUG POUR LES FICHIERS: ON NE RÉCUPÈRES PLUS LE TABLEAU DE LA DTB, CELUI-CI EST EFFACÉ AU SUBMIT SI AUCUNE IMAGE N'EST SELECT...
            if((!isset($file)) || empty($file) || $file == []){
                /*dump('toto');
                dump($photos);
                dump($product);*/
                //dump($product->getPhotos());
                $product->setPhotos($photos);
            } else {
                //dump($file);
                //s'assurer que le fait de n'avoir qu'un seul fichier ne casse pas la boucle foreach
                foreach ($file as $result){
                    $fileName = 'product-' . $product->getId() . '-'.$i.'.' . $result->guessExtension(); //On renomme l'image avec l'id du user connecté (pas le pseudo pour éviter les caractères spéciaux)

                    try {
                        $result->move(
                            $this->getParameter('products_directory'),
                            $fileName
                        );
                        array_push($photos, $fileName);
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    $i++;
                }

                $product->setPhotos($photos);
            }

            //$entityManager = $this->getDoctrine()->getManager();
            //$entityManager->persist($product);
            //$entityManager->flush();

            //return $this->redirectToRoute('product_index', [
            //    'id' => $product->getId(),
            //]);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
