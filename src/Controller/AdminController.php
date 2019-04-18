<?php
/**
 * Created by PhpStorm.
 * User: brandonleininger
 * Date: 06/02/2019
 * Time: 11:26
 */

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index()
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
