<?php

/*
 * This file is part of the prestaSitemapPlugin package.
 * (c) David Epely <depely@prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RC\PHPCRAutoSiteMapBundle\Service;

use Doctrine\Common\Cache\Cache;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap;
use Presta\SitemapBundle\Service\Generator;
//use Symfony\Cmf\Bundle\RoutingExtraBundle\Document\Router;
//use Symfony\Cmf\Component\Routing\ChainRouter as Router;
use Symfony\Component\EventDispatcher\ContainerAwareEventDispatcher;
use Presta\SitemapBundle\Sitemap\Sitemapindex;
use Presta\SitemapBundle\Sitemap\Url\Url;

/**
 * Sitemap Manager service
 * 
 * @author David Epely <depely@prestaconcept.net>
 * @author Christophe Dolivet
 */
class PhpcrGenerator extends Generator
{
 

    /**
     * @param ContainerAwareEventDispatcher $dispatcher
     * @param Router $router
     * @param Cache $cache 
     */
    public function __construct(ContainerAwareEventDispatcher $dispatcher, $router, Cache $cache = null)
    {
        $this->dispatcher = $dispatcher;
        $this->router = $router;
        $this->cache = $cache;
    }

   
}
