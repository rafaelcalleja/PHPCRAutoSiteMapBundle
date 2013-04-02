<?php 
namespace RC\PHPCRAutoSiteMapBundle\Events;

use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Presta\SitemapBundle\Service\SitemapListenerInterface;


class SitemapListener implements SitemapListenerInterface {
	
	
	
	public function __construct(){
	}
	

	public function populateSitemap(SitemapPopulateEvent $event){
		var_dump('populating', $event->getSection());
	}

}