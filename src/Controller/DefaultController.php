<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return new Response('Admin Page');
    }

    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function dashboard()
    {
        return new Response('Dashboard');
    }

    /**
     * @Route("/admin/relatorios", name="relatorios")
     */
    public function relatorios()
    {
        return new Response('Relatorios');
    }

    /**
     * @Route("/login", name="login")
     * @Template("/default/login.html.twig")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        return [
            'error' => $error,
            'lastUsername' => $lastUsername
        ];
    }

    /**
     * @Route("/insert", name="insert")
     */
    public function insert(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername('savio');
        $user->setEmail('savio@savio.com');
        $user->setRoles("ROLE_USER");

        $encoder = $this->get('security.password_encoder');
        $pass = $encoder->encodePassword($user, "123456");

        $user->setPassword($pass);

        $em->persist($user);

        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@admin.com');
        $user->setRoles("ROLE_ADMIN");

        $encoder = $this->get('security.password_encoder');
        $pass = $encoder->encodePassword($user, "123456");

        $user->setPassword($pass);

        $em->persist($user);

        $em->flush();

        return new Response('SUCESSO');
    }

}