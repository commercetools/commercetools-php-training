<?php

namespace Commercetools\TrainingBundle\Controller;

use Commercetools\Core\Model\Common\Image;
use Commercetools\Core\Model\Common\ImageCollection;
use Commercetools\Core\Model\Common\LocalizedString;
use Commercetools\Core\Model\Common\Money;
use Commercetools\Core\Model\Common\Price;
use Commercetools\Core\Model\Product\ProductProjection;
use Commercetools\Core\Model\Product\ProductProjectionCollection;
use Commercetools\Core\Model\Product\ProductVariant;
use GuzzleHttp\Psr7\Uri;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CatalogController extends Controller
{
    public function indexAction(Request $request)
    {
        $description = 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt
         ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea
         rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor
         sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna
         aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd
         gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.';

        $context = $this->get('commercetools.context.factory')->build($request->getLocale());

        $facets = [
            'size' => [
                '34',
                '35',
            ],
            'color' => [
                'blue',
                'red'
            ]
        ];
        $products = ProductProjectionCollection::of()->setContext($context)
            ->add(
                ProductProjection::of()
                    ->setId('123456')
                    ->setName(LocalizedString::ofLangAndText('en', 'Test'))
                    ->setDescription(LocalizedString::ofLangAndText('en', $description))
                    ->setMasterVariant(
                        ProductVariant::of()
                            ->setPrice(
                                Price::ofMoney(Money::ofCurrencyAndAmount('EUR', 100))
                            )
                            ->setImages(
                                ImageCollection::of()->add(
                                    Image::of()->setUrl(
                                        'https://s3-eu-west-1.amazonaws.com/commercetools-maximilian/products/072595_1_large.jpg'
                                    )
                                )
                            )
                    )
            )
            ->add(
                ProductProjection::of()
                    ->setId('789012')
                    ->setName(LocalizedString::ofLangAndText('en', 'Test2'))
                    ->setDescription(LocalizedString::ofLangAndText('en', $description))
                    ->setMasterVariant(
                        ProductVariant::of()
                            ->setPrice(
                                Price::ofMoney(Money::ofCurrencyAndAmount('EUR', 100))
                            )
                            ->setImages(
                                ImageCollection::of()->add(
                                    Image::of()->setUrl(
                                        'https://s3-eu-west-1.amazonaws.com/commercetools-maximilian/products/079639_1_medium.jpg'
                                    )
                                )
                            )
                    )
            )
        ;
        return $this->render('@CommercetoolsTraining/catalog/index.html.twig', ['products' => $products, 'facets' => $facets]);
    }

    public function detailAction(Request $request)
    {
        $description = 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt
         ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea
         rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor
         sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna
         aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd
         gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.';
        $context = $this->get('commercetools.context.factory')->build($request->getLocale());

        $product = ProductProjection::of()->setContext($context)
            ->setId('123456')
            ->setName(LocalizedString::ofLangAndText('en', 'Test'))
            ->setDescription(LocalizedString::ofLangAndText('en', $description))
            ->setMasterVariant(
                ProductVariant::of()
                    ->setPrice(
                        Price::ofMoney(Money::ofCurrencyAndAmount('EUR', 100))
                    )
                    ->setImages(
                        ImageCollection::of()->add(
                            Image::of()->setUrl(
                                'https://s3-eu-west-1.amazonaws.com/commercetools-maximilian/products/072595_1_large.jpg'
                            )
                        )
                    )
            );
        return $this->render('@CommercetoolsTraining/catalog/product.html.twig', ['product' => $product]);
    }
}
