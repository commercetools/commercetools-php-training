<?php

namespace Commercetools\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CommercetoolsTrainingBundle:Default:index.html.twig');
    }
}
