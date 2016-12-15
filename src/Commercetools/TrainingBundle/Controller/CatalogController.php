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
        $repository = $this->get('commercetools_training.service.product_repository');

        $response = $repository->getProducts($request);

        $products = $response->toObject();


        $context = $this->get('commercetools.context.factory')->build($request->getLocale());

        $facetData = $response->getFacets();

        $facets = [];
        foreach ($facetData as $facetName => $facetResult) {
            foreach ($facetResult->getTerms() as $term) {
                $facets[$facetName][] = $term->getTerm() . ' (' . $term->getCount() . ')';
            }
        }

        return $this->render('@CommercetoolsTraining/catalog/index.html.twig', ['products' => $products, 'facets' => $facets]);
    }

    public function detailAction(Request $request)
    {
        $repository = $this->get('commercetools_training.service.product_repository');

        $context = $this->get('commercetools.context.factory')->build($request->getLocale());

        $product = $repository->getProductById($request->get('id'));
        $product->setContext($context);

        return $this->render('@CommercetoolsTraining/catalog/product.html.twig', ['product' => $product]);
    }
}
