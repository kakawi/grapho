<?php


namespace CatalogBundle;
use CatalogBundle\DependencyInjection\CatalogBundleExtension;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CatalogBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new CatalogBundleExtension();
    }

}