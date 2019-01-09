<?php

namespace Commercetools\Training\Tests;

use Commercetools\Core\Builder\Request\RequestBuilder;
use Commercetools\Core\Builder\Update\ActionBuilder;
use Commercetools\Core\Model\CartDiscount\AbsoluteCartDiscountValue;
use Commercetools\Core\Model\CartDiscount\CartDiscountDraft;
use Commercetools\Core\Model\CartDiscount\CartDiscountReferenceCollection;
use Commercetools\Core\Model\Category\Category;
use Commercetools\Core\Model\Category\CategoryDraft;
use Commercetools\Core\Model\Common\LocalizedString;
use Commercetools\Core\Model\Common\Money;
use Commercetools\Core\Model\DiscountCode\DiscountCodeDraft;
use Commercetools\Core\Request\CartDiscounts\CartDiscountQueryRequest;
use Commercetools\Core\Request\Categories\CategoryQueryRequest;
use Commercetools\Core\Request\DiscountCodes\DiscountCodeQueryRequest;
use Commercetools\Core\Request\Products\ProductQueryRequest;
use Commercetools\Core\Request\Project\Command\ProjectChangeLanguagesAction;
use Commercetools\Core\Request\Project\ProjectGetRequest;
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
                CartDiscountDraft::ofNameValuePredicateOrderActiveAndDiscountCode(
                    LocalizedString::ofLangAndText('en', 'TESTCODE'),
                    AbsoluteCartDiscountValue::of()->setMoney(Money::ofCurrencyAndAmount('EUR', 100)),
                    '1=1',
                    0.94323423423,
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
    }
}
