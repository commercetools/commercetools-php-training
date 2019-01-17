<?php

namespace Commercetools\Training;

use Commercetools\Core\Builder\Request\RequestBuilder;
use Commercetools\Core\Builder\Update\ActionBuilder;
use Commercetools\Core\Model\Cart\Cart;
use Commercetools\Core\Model\Cart\CartDraft;
use Commercetools\Core\Model\Common\Address;
use Commercetools\Core\Model\Customer\Customer;
use Commercetools\Core\Model\CustomField\CustomFieldObjectDraft;
use Commercetools\Core\Model\CustomField\FieldContainer;
use Commercetools\Core\Model\Product\ProductProjection;
use Commercetools\Core\Model\ShoppingList\ShoppingList;
use Commercetools\Core\Request\Carts\CartUpdateRequest;
use Commercetools\Core\Request\Carts\Command\CartAddDiscountCodeAction;
use Commercetools\Core\Request\Carts\Command\CartAddLineItemAction;
use Commercetools\Core\Request\Carts\Command\CartAddShoppingListAction;

class CartService extends AbstractService
{
    /**
     * @param Customer $customer
     * @return Cart
     */
    public function createCart(Customer $customer)
    {
        //TODO: 3.1 create cart request
        $request = RequestBuilder::of()->carts()->create(
            CartDraft::ofCurrency('EUR')
                ->setCountry('DE')
                ->setCustomerId($customer->getId())
                ->setShippingAddress(Address::of()->setCountry('DE'))
        );

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);

    }

    /**
     * @param ProductProjection $product
     * @param Cart $cart
     * @return Cart
     */
    public function addProductToCart(ProductProjection $product, Cart $cart)
    {
        //TODO: 3.1 update cart with product
//        $request = CartUpdateRequest::ofIdAndVersion($cart->getId(), $cart->getVersion())->addAction(
//            CartAddLineItemAction::ofSkuAndQuantity($product->getMasterVariant()->getSku(), 1)
//        );
//        $request = RequestBuilder::of()->carts()->update($cart)->addAction(
//            CartAddLineItemAction::ofSkuAndQuantity($product->getMasterVariant()->getSku(), 1)
//        );
//        $request = RequestBuilder::of()->carts()->update($cart)->setActions(
//            ActionBuilder::of()->carts()->addLineItem(
//                CartAddLineItemAction::ofSkuAndQuantity($product->getMasterVariant()->getSku(), 1)
//            )->getActions()
//        );
//        $request = RequestBuilder::of()->carts()->update($cart)->setActions(
//            ActionBuilder::of()->carts()->addLineItem(
//                function (CartAddLineItemAction $action) use ($product) {
//                    $action->setSku($product->getMasterVariant()->getSku());
//                    return $action;
//                }
//            )->getActions()
//        );
        $request = RequestBuilder::of()->carts()->update($cart)->addAction(
            CartAddLineItemAction::ofProductIdVariantIdAndQuantity(
                $product->getId(),
                $product->getMasterVariant()->getId(),
                1
            )->setCustom(
                CustomFieldObjectDraft::ofTypeKey(
                    'jenstype'
                )->setFields(FieldContainer::of()->set('wrist_length', "48"))
            )
        );

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }

    /**
     * @param string $code
     * @param Cart $cart
     * @return Cart
     */
    public function addDiscountToCart($code, Cart $cart)
    {
        //TODO: 5.1 add discount to cart
        $request = RequestBuilder::of()->carts()->update($cart)->addAction(
            CartAddDiscountCodeAction::ofCode($code)
        );

        $response = $this->client->execute($request);
        return $request->mapFromResponse($response);
    }
}
