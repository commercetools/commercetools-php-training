<?php

namespace Commercetools\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends Controller
{
    public function successAction(Request $request)
    {
        return $this->render('@CommercetoolsTraining/cart/cartSuccess.html.twig', []);
    }
}
