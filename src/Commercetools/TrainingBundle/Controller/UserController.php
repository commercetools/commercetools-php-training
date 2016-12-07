<?php


namespace Commercetools\TrainingBundle\Controller;

use Commercetools\Core\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'CommercetoolsTrainingBundle:user:login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error
            ]
        );
    }
}
