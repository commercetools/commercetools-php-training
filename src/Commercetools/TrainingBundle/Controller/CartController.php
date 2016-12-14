<?php

namespace Commercetools\TrainingBundle\Controller;

use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Core\Model\Cart\LineItem;
use Commercetools\Core\Model\Cart\LineItemCollection;
use Commercetools\Core\Model\Common\LocalizedString;
use Commercetools\Core\Model\Common\Money;
use Commercetools\Core\Model\Common\Price;
use Commercetools\Core\Model\Common\TaxedPrice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $this->get('session');
        $cartId = $session->get('cartId');

        $context = $this->get('commercetools.context.factory')->build($request->getLocale());

        $repository = $this->get('commercetools_training.service.cart_repository');

        $cart = $repository->getOrCreateCart($cartId);
        $cart->setContext($context);

        $session->set('cartId', $cart->getId());

        return $this->render('@CommercetoolsTraining/cart/index.html.twig', ['cart' => $cart]);
    }

    public function addLineItemAction(Request $request)
    {
        $session = $this->get('session');
        $cartId = $session->get('cartId');

        $context = $this->get('commercetools.context.factory')->build($request->getLocale());
        $repository = $this->get('commercetools_training.service.cart_repository');

        $cart = $repository->getOrCreateCart($cartId);
        $cart->setContext($context);

        $productId = $request->get('productId');
        $variantId = (int)$request->get('variantId');
        $quantity = (int)$request->get('quantity');

        $cart = $repository->addLineItem($cart, $productId, $variantId, $quantity);
        $session->set('cartId', $cart->getId());

        return $this->redirectToRoute('_ctp_training_cart');
    }

    public function changeLineItemAction(Request $request)
    {
        $session = $this->get('session');
        $cartId = $session->get('cartId');

        if (!is_null($cartId)) {
            $context = $this->get('commercetools.context.factory')->build($request->getLocale());
            $repository = $this->get('commercetools_training.service.cart_repository');

            $cart = $repository->getOrCreateCart($cartId);
            $cart->setContext($context);

            $lineItemId = $request->get('lineItemId');
            $quantity = (int)$request->get('quantity');

            $repository->changeLineItemQuantity($cart, $lineItemId, $quantity);
        }

        return $this->redirectToRoute('_ctp_training_cart');
    }

    public function deleteLineItemAction(Request $request)
    {
        return $this->redirectToRoute('_ctp_training_cart');
    }
}
