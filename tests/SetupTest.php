<?php

namespace Commercetools\Training\Tests;

use Commercetools\Core\Builder\Request\RequestBuilder;
use Commercetools\Core\Builder\Update\ActionBuilder;
use Commercetools\Core\Model\CartDiscount\AbsoluteCartDiscountValue;
use Commercetools\Core\Model\CartDiscount\CartDiscountDraft;
use Commercetools\Core\Model\CartDiscount\CartDiscountReferenceCollection;
use Commercetools\Core\Model\CartDiscount\LineItemsTarget;
use Commercetools\Core\Model\Category\CategoryDraft;
use Commercetools\Core\Model\Category\CategoryReferenceCollection;
use Commercetools\Core\Model\Common\Attribute;
use Commercetools\Core\Model\Common\AttributeCollection;
use Commercetools\Core\Model\Common\LocalizedString;
use Commercetools\Core\Model\Common\Money;
use Commercetools\Core\Model\Common\MoneyCollection;
use Commercetools\Core\Model\DiscountCode\DiscountCodeDraft;
use Commercetools\Core\Model\Product\ProductDraft;
use Commercetools\Core\Model\Product\ProductVariantDraft;
use Commercetools\Core\Model\ProductType\AttributeDefinition;
use Commercetools\Core\Model\ProductType\AttributeDefinitionCollection;
use Commercetools\Core\Model\ProductType\ProductTypeDraft;
use Commercetools\Core\Model\ProductType\ProductTypeReference;
use Commercetools\Core\Model\ProductType\StringType;
use Commercetools\Core\Request\CartDiscounts\CartDiscountQueryRequest;
use Commercetools\Core\Request\Categories\CategoryQueryRequest;
use Commercetools\Core\Request\DiscountCodes\DiscountCodeQueryRequest;
use Commercetools\Core\Request\Products\Command\ProductAddToCategoryAction;
use Commercetools\Core\Request\Products\ProductQueryRequest;
use Commercetools\Core\Request\ProductTypes\ProductTypeByKeyGetRequest;
use Commercetools\Core\Request\ProductTypes\ProductTypeQueryRequest;
use Commercetools\Core\Request\Project\Command\ProjectChangeLanguagesAction;
use Commercetools\Training\ClientService;
use PHPUnit\Framework\TestCase;

class SetupTest extends TestCase
{
    public function testSetupProject()
    {
        $client = (new ClientService())->createClient();

        $projectGetRequest = RequestBuilder::of()->project()->get();
        $response = $client->execute($projectGetRequest);
        $project = $projectGetRequest->mapFromResponse($response);

        $projectUpdateRequest = RequestBuilder::of()->project()->update($project);

        $projectActionBuilder = ActionBuilder::of()->project();
        if (!in_array('en', $project->getLanguages()->toArray())) {
            $projectActionBuilder->changeLanguages(function (ProjectChangeLanguagesAction $action) use ($project) {
                $languages = $project->getLanguages()->toArray();
                $languages[] = 'en';
                $action->setLanguages($languages);
                return $action;
            });
            $projectUpdateRequest->setActions($projectActionBuilder->getActions());

            $response = $client->execute($projectUpdateRequest);
            $this->assertFalse($response->isError());
        }

        $catGetRequest = CategoryQueryRequest::of()->where('name(en = "Sale")')->limit(1);
        $response = $client->execute($catGetRequest);
        $categories = $catGetRequest->mapFromResponse($response);

        if ($categories->count() == 0) {
            $categoryCreateRequest = RequestBuilder::of()->categories()->create(
                CategoryDraft::ofNameAndSlug(
                    LocalizedString::ofLangAndText('en', 'Sale'),
                    LocalizedString::ofLangAndText('en', 'sale')
                )
            );
            $response = $client->execute($categoryCreateRequest);
            $this->assertFalse($response->isError());
            $category = $categoryCreateRequest->mapFromResponse($response);
        } else {
            $category = $categories->current();
        }

        $cartDiscountGetRequest = CartDiscountQueryRequest::of()->where('name(en = "TESTCODE")')->limit(1);
        $response = $client->execute($cartDiscountGetRequest);
        $cartDiscounts = $catGetRequest->mapFromResponse($response);

        if ($cartDiscounts->count() == 0) {
            $cdCreateRequest = RequestBuilder::of()->cartDiscounts()->create(
                CartDiscountDraft::ofNameValuePredicateTargetOrderActiveAndDiscountCode(
                    LocalizedString::ofLangAndText('en', 'TESTCODE'),
                    AbsoluteCartDiscountValue::of()->setMoney(
                        MoneyCollection::of()->add(Money::ofCurrencyAndAmount('EUR', 100))
                    ),
                    '1=1',
                    LineItemsTarget::of()->setPredicate('1=1'),
                    '0.94323423423',
                    true,
                    true
                )
            );
            $response = $client->execute($cdCreateRequest);

            $this->assertFalse($response->isError());
            $cartDiscount = $cdCreateRequest->mapFromResponse($response);
        } else {
            $cartDiscount = $cartDiscounts->current();
        }

        $discountGetRequest = DiscountCodeQueryRequest::of()->where('code = "TESTCODE"');
        $response = $client->execute($discountGetRequest);
        $discountCodes = $catGetRequest->mapFromResponse($response);

        if ($discountCodes->count() == 0) {
            $discountCodeCreateRequest = RequestBuilder::of()->discountCodes()->create(
                DiscountCodeDraft::ofCodeDiscountsAndActive(
                        "TESTCODE",
                        CartDiscountReferenceCollection::of()->add($cartDiscount->getReference()),
                        true
                    )
                    ->setName(LocalizedString::ofLangAndText('en', 'TESTCODE'))
            );
            $response = $client->execute($discountCodeCreateRequest);
            $this->assertFalse($response->isError());
        }
        $this->assertFalse($response->isError());

        $productTypeRequest = ProductTypeByKeyGetRequest::ofKey('ctp-training');
        $response = $client->execute($productTypeRequest);
        $productType = $productTypeRequest->mapFromResponse($response);

        if (is_null($productType)) {
            $ptCreateRequest = RequestBuilder::of()->productTypes()->create(
                ProductTypeDraft::ofNameAndDescription("CTP-Training",'training-product-type')
                    ->setKey('ctp-training')
                    ->setAttributes(
                        AttributeDefinitionCollection::of()
                            ->add(
                                AttributeDefinition::of()->setName("ctp-color")
                                    ->setLabel(LocalizedString::ofLangAndText('en', 'ctp-color'))
                                    ->setType(StringType::of())
                                    ->setIsRequired(false)
                                    ->setIsSearchable(true)
                            )
                    )
            );
            $response = $client->execute($ptCreateRequest);
            $this->assertFalse($response->isError());
            $productType = $ptCreateRequest->mapFromResponse($response);
        }

        $productQueryRequest = ProductQueryRequest::of()->where('masterData(current(name(en = "Cantarelli Training")))');
        $response = $client->execute($productQueryRequest);
        $products = $productQueryRequest->mapFromResponse($response);

        if ($products->count() == 0) {
            $productCreateRequest = RequestBuilder::of()->products()->create(
                ProductDraft::ofTypeNameAndSlug(
                    $productType->getReference(),
                    LocalizedString::ofLangAndText('en', 'Cantarelli Training'),
                    LocalizedString::ofLangAndText('en', 'cantarelli-training')
                )
                    ->setCategories(CategoryReferenceCollection::of()->add($category->getReference()))
                    ->setPublish(true)
                    ->setMasterVariant(
                        ProductVariantDraft::of()
                            ->setSku('ctp-cantarelli-training-123')
                            ->setAttributes(
                                AttributeCollection::of()
                                    ->add(
                                        Attribute::of()->setName('ctp-color')
                                            ->setValue('red')
                                    )
                            )
                    )
            );
            $response = $client->execute($productCreateRequest);
            $this->assertFalse($response->isError());
            $product = $productCreateRequest->mapFromResponse($response);
        } else {
            $product = $products->current();
        }

        if (is_null($product->getMasterData()->getCurrent()->getCategories()->getById($category->getReference()->getId()))) {
            $productUpdateRequest = RequestBuilder::of()->products()->update($product);
            $productUpdateRequest->setActions(
                ActionBuilder::of()->products()
                    ->addToCategory(
                        function (ProductAddToCategoryAction $action) use ($category) {
                            $action->setCategory($category->getReference());
                            return $action;
                        }
                    )
                    ->publish(function ($action) { return $action;})
                    ->getActions()
            );
            $response = $client->execute($productUpdateRequest);
            $this->assertFalse($response->isError());
            $product = $productUpdateRequest->mapFromResponse($response);
        }
        $this->assertTrue(true);
    }
}
