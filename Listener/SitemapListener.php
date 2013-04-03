<?php 
namespace RC\PHPCRAutoSiteMapBundle\Listener;

use RC\PHPCRAutoSiteMapBundle\Helper\UrlSetHelper;

use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Presta\SitemapBundle\Service\SitemapListenerInterface;



class SitemapListener implements SitemapListenerInterface {
	
	protected $oids = array();
	protected $method_action;
	protected $targetdir;
	
	public function __construct($target){
		$this->targetdir = $target;
	}
	
	public function setOids($value){
		$this->oids = $value;
	}
	
	public function setMethod($value){
		$this->method_action = $value;
	}
	

	public function populateSitemap(SitemapPopulateEvent $event){
			
			$newurl = $this->oids[$event->getSection()]['url'];
			$newlabel = $this->oids[$event->getSection()]['label'];
			$newUrlset = new UrlConcrete($newurl, new \DateTime(), UrlConcrete::CHANGEFREQ_HOURLY, 1 );

			$registered = UrlSetHelper::loadCurrentUrlSets($this->targetdir.$newlabel.'.xml');
			$registered = call_user_func('RC\PHPCRAutoSiteMapBundle\Helper\UrlSetHelper::'.$this->method_action, $registered, $newUrlset);
			foreach($registered as $urlsets){
				$event->getGenerator()->addUrl($urlsets, $newlabel);
			}
			
	}

}