<?php

namespace Commercetools\Training;

use Cache\Adapter\Filesystem\FilesystemCachePool;
use Commercetools\Core\Client;
use Commercetools\Core\Config;
use Commercetools\Core\Model\Common\Context;
use Commercetools\Core\Model\Product\ProductProjection;
use Commercetools\Core\Model\Product\ProductProjectionCollection;
use Commercetools\Core\Request\Products\ProductProjectionSearchRequest;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

require __DIR__ . '/vendor/autoload.php';

$appConfig = [];

$iniFile = __DIR__ . '/credentials.ini';

if (file_exists($iniFile)) {
    $appConfig = parse_ini_file($iniFile);
}

$context = Context::of()->setLanguages(['en'])->setGraceful(true);


// create the api client config object
$config = Config::fromArray($appConfig)->setContext($context);

$request = ProductProjectionSearchRequest::of();

$filesystemAdapter = new Local(__DIR__.'/');
$filesystem        = new Filesystem($filesystemAdapter);
$cache = new FilesystemCachePool($filesystem);

$client = Client::ofConfigAndCache($config, $cache);

$products = $client->execute($request)->toObject();

/**
 * @var ProductProjectionCollection $products
 */
?>
<html>
<head>
    <title>Commercetools PHP SDK example</title>
</head>
<body>
<?php
/**
 * @var ProductProjection $product
 */
foreach ($products as $product) : ?>
    <h1><?= $product->getName() ?></h1>
    <img src="<?= $product->getMasterVariant()->getImages()->current()->getUrl() ?>" width="100">
    <p><?= $product->getDescription() ?></p>
    <?php
endforeach;
?>
</body>
</html>
