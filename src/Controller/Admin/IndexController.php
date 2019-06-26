<?php


namespace App\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class IndexController
 * @Route("/admin")
 */
class IndexController extends AbstractController
{
    /**
     * @Route("", name="admin_home")
     */
    public function index()
    {
        return $this->redirectToRoute('admin_show_index');
    }
}
