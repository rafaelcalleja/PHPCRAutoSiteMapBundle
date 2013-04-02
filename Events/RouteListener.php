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

class RouteListener  {

	protected $dispatcher, $prefix, $generator, $dumper;

	protected $label, $url, $targetdir, $method_action;
	protected static $oids = array();
	
	
	
	public function __construct($dispatcher, $prefix, $generator, $dumper) {
		
		$this->dispatcher = $dispatcher;
		$this->prefix = $prefix;
		$this->generator = $generator;
		$this->dumper = $dumper;
		$this->targetdir = __DIR__.'/../../../../../../web/';
		$this->loadListernerClosure();
		
		
	}
	
	private function loadListernerClosure(){
		$generator = $this->generator;
		$this->dispatcher->addListener(SitemapPopulateEvent::onSitemapPopulate,
		function(SitemapPopulateEvent $event) use ($generator){

			$newurl = self::$oids[$event->getSection()]['url'];
			$newlabel = self::$oids[$event->getSection()]['label'];
			$newUrlset = new UrlConcrete($newurl, new \DateTime(), UrlConcrete::CHANGEFREQ_HOURLY, 1 );

			$registered = UrlSetHelper::loadCurrentUrlSets($this->targetdir.$newlabel.'.xml');
			$registered = UrlSetHelper::{$this->method_action}($registered, $newUrlset);
			foreach($registered as $urlsets){
				$event->getGenerator()->addUrl($urlsets, $newlabel);
			}


		});
	}

	public function onRouteAdded(RouteDataEvent $event) {
		$this->method_action = 'addUrlTo';
		$sections = explode('/', $event->getPath());
		$this->label  =  ( isset($sections[1]) && !empty($sections[1])) ? $sections[1] : 'default';
		$this->url = $this->prefix . substr($event->getPath(), 1);
		$id = $event->getPath();
		self::$oids[$id] = array('url' => $this->url, 'label' => $this->label);
		$filenames = $this->dumper->dump($this->targetdir, $id );
	}

	public function onRouteMoved(RouteMoveEventsData $event) {

	}

	public function onRouteRemoved(RouteFlushDataEvent $event) {

	}

}
