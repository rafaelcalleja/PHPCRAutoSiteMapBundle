<?php
namespace RC\PHPCRAutoSiteMapBundle\Events;
use RC\PHPCRRouteEventsBundle\Events\RouteDataEvent;
use RC\PHPCRRouteEventsBundle\Events\RouteMoveEventsData;
use RC\PHPCRRouteEventsBundle\Events\RouteFlushDataEvent;
use RC\PHPCRAutoSiteMapBundle\Helper\UrlSetHelper;

use Doctrine\ODM\PHPCR\Event\LifecycleEventArgs;

use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use RC\PHPCRAutoSiteMapBundle\Listener\SitemapListener;

class RouteListener  {

	protected $dispatcher, $prefix, $generator, $dumper;

	protected $label, $url, $targetdir, $method_action, $listener;
		
	
	
	public function __construct($dispatcher, $prefix, $generator, $dumper) {
		
		$this->dispatcher = $dispatcher;
		$this->prefix = $prefix;
		$this->generator = $generator;
		$this->dumper = $dumper;
		$this->targetdir = __DIR__.'/../../../../../../web/';
		$this->listener = new SitemapListener($this->targetdir);
		$this->dispatcher->addListener(SitemapPopulateEvent::onSitemapPopulate, array($this->listener, 'populateSitemap'));
		
	}
	
	public function onRouteAdded(RouteDataEvent $event) {
		$this->listener->setMethod('addUrlTo');
		$this->method_action = 'addUrlTo';
		$sections = explode('/', $event->getPath());
		$this->label  =  ( isset($sections[1]) && !empty($sections[1])) ? $sections[1] : 'default';
		$this->url = $this->prefix . substr($event->getPath(), 1);
		$id = $event->getPath();
		$this->listener->setOids(array($id => array('url' => $this->url, 'label' => $this->label)));
		$filenames = $this->dumper->dump($this->targetdir, $id );
	}

	public function onRouteMoved(RouteMoveEventsData $event) {

	}

	public function onRouteRemoved(RouteFlushDataEvent $event) {

	}

}
