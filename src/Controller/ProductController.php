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

use App\Entity\Gamme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


/**
 * @Route("/admin/product")
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
            $date = new \DateTime();
            $product->setDate($date);
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
        //$form = $this->createForm(ProductType::class, $product);
        $form = $this->createFormBuilder($product)
        ->add('titre', TextType::class, ['label' => 'Nom : '])
        ->add('description', TextareaType::class, ['label' => 'Description : ', 'label_attr' => ['class' => 'label-top'], 'required' => false])
        ->add('Fil', TextareaType::class, ['label' => 'Fil : ', 'label_attr' => ['class' => 'label-top'], 'attr' => ['placeholder' => 'description du fil (nom, composition)'], 'required' => false])
        ->add('taillefils', IntegerType::class, ['label' => 'Taile du fil (m) : ', 'attr' => ['class' => 'number'], 'required' => false])
        ->add('gamme', EntityType::class, ['label' => 'Choisir une gamme : ', 'choice_label' => 'nom', 'class' => Gamme::class, 'label_attr' => ['class' => 'label-gamme']])
        ->add('dimensions', TextType::class, ['label' => 'Dimensions : ', 'attr' => ['placeholder' => 'longueur x largeur'], 'required' => false])
        ->add('duree', IntegerType::class, ['label' => 'Temps de travail : ', 'attr' => ['class' => 'number'], 'required' => false])
        ->add('Surmesure', CheckboxType::class, ['label' => 'Disponnible à la vente : ', 'attr' => ['class' => 'checkbox'], 'required' => false])
        ->add('Prix', IntegerType::class, ['label' => 'Prix : ', 'attr' => ['placeholder' => 'ne pas écrire la devise (€)'], 'attr' => ['class' => 'number'], 'required' => false])
        ->getForm();

        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit_pics", name="product_edit_pics", methods={"GET","POST"})
     */
    public function editPics(Request $request, Product $product): Response
    {
        //$form = $this->createForm(ProductType::class, $product);
        $form = $this->createFormBuilder()
            ->add('Photos', FileType::class, [
                'label' => 'Modifier les photos : ',
                'multiple' => true,
                'by_reference' => false,
                'required' => false,
                'attr'     => [
                    'accept' => 'image/*',
                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        $productPics = $product->getPhotos();
        $i = 0;
        $photos = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form["Photos"]->getData();

            if($data == []){
                //Aucune autre photo n'a été sélectionnée
                //Flush message: "aucune photo n'a été sélectionnée"
                print_r("aucune photo n'a été sélectionnée");
            } else{
                $nbfile = count($data);
                if($nbfile >= 10){
                    print_r("Vous avez sélectionné trop de photos...");
                } else{
                    //on supprime les anciennes photos
                    $filesystem = new Filesystem();
                    foreach ($productPics as $pic){
                        $fileName = $this->getParameter('products_directory').'/'.(string) $pic;
                        //dump($fileName);
                        $filesystem->remove($fileName);
                    }

                    foreach ($data as $result){
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

                    //dump($photos);
                    $product->setPhotos($photos);

                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit_pics.html.twig', [
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
