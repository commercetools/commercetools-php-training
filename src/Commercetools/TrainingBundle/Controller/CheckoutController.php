<?php

namespace Commercetools\TrainingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends Controller
{
    public function successAction(Request $request)
    {
        $session = $this->get('session');
        $cartId = $session->get('cartId');

        $cartRepository = $this->get('commercetools_training.service.cart_repository');
        $cart = $cartRepository->getCart($cartId);
        $repository = $this->get('commercetools_training.service.order_repository');

        $order = $repository->createOrder($cart);
        $session->remove('cartId');

        return $this->render('@CommercetoolsTraining/cart/cartSuccess.html.twig', ['orderId' => $order->getId()]);
    }
}
