<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @return
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }

}
