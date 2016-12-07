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
        $context = $this->get('commercetools.context.factory')->build($request->getLocale());
        $cart = Cart::of()
            ->setContext($context)
            ->setLineItems(
                LineItemCollection::of()->add(
                    LineItem::of()
                        ->setId('12345678')
                        ->setName(LocalizedString::ofLangAndText('en', 'Test'))
                        ->setPrice(Price::ofMoney(Money::ofCurrencyAndAmount('EUR', 100)))
                        ->setTotalPrice(Money::ofCurrencyAndAmount('EUR', 100))
                )
            )
            ->setTotalPrice(Money::ofCurrencyAndAmount('EUR', 116))
            ->setTaxedPrice(
                TaxedPrice::of()
                    ->setTotalGross(Money::ofCurrencyAndAmount('EUR', 116))
                    ->setTotalNet(Money::ofCurrencyAndAmount('EUR', 100))
            )
        ;
        return $this->render('@CommercetoolsTraining/cart/index.html.twig', ['cart' => $cart]);
    }

    public function addLineItemAction(Request $request)
    {
        return $this->redirectToRoute('_ctp_training_cart');
    }

    public function changeLineItemAction(Request $request)
    {
        return $this->redirectToRoute('_ctp_training_cart');
    }

    public function deleteLineItemAction(Request $request)
    {
        return $this->redirectToRoute('_ctp_training_cart');
    }
}
