<?php 
namespace RC\PHPCRAutoSiteMapBundle\Events;

use RC\PHPCRRouteEventsBundle\Events\RouteDataEvent;
use RC\PHPCRRouteEventsBundle\Events\RouteMoveEventsData;
use RC\PHPCRRouteEventsBundle\Events\RouteFlushDataEvent;
use Doctrine\ODM\PHPCR\Event\LifecycleEventArgs;

use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Presta\SitemapBundle\Service\SitemapListenerInterface;


class RouteListener implements SitemapListenerInterface {
	
	protected $dispatcher, $prefix, $router;
	
	public function __construct($dispatcher, $prefix, $router){
		$this->dispatcher = $dispatcher;
		$this->prefix = $prefix;
		$this->router = $router;
	}
	
	public function onRouteAdded(RouteDataEvent $event){
		
		/*$basename = $event->getId();
		$name = $event->getName();
		$label = $event->getLabel();*/
		//$this->populate(new SitemapPopulateEvent($generator, $sec))
		$generator = new \RC\PHPCRAutoSiteMapBundle\Service\PhpcrGenerator($this->dispatcher, $this->router);
		$sec = $event->getPath();
		
		$e = new SitemapPopulateEvent($generator, $sec);
		
		$this->dispatcher->addListener(
				SitemapPopulateEvent::onSitemapPopulate, function(SitemapPopulateEvent $event) use ($e){
                $url = $this->prefix.$event->getSection();
				$section = (dirname($url) != '/') ? dirname($url) : 'default';
				
				$event->getGenerator()->addUrl(
						new UrlConcrete(
								$url,
								new \DateTime(),
								UrlConcrete::CHANGEFREQ_HOURLY,
								1
						),
						$section
				);
        });
                
		//$this->dispatcher->dispatch(SitemapPopulateEvent::onSitemapPopulate, new SitemapPopulateEvent($generator, $event->getPath()) );
		
	}
	
	public function populateSitemap(SitemapPopulateEvent $event)
	{
		$section = $event->getSection();
		var_dump($section);
	}

	
	public function onRouteMoved(RouteMoveEventsData $event){
		
	}
	
	
	public function onRouteRemoved(RouteFlushDataEvent $event){
		
	}
	
	

}