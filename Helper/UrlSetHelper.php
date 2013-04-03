<?php 
namespace RC\PHPCRAutoSiteMapBundle\Helper;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class UrlSetHelper{
	
	public static function loadCurrentUrlSets($filename)
	{
	
		
		if (!file_exists($filename)) {
			return array();
		}
	
		$urlsets = array();
		$index = simplexml_load_file($filename);
		foreach ($index->children() as $child) {
				
			if ($child->getName() == 'url') {
				if (!isset($child->loc)) {
					throw new \InvalidArgumentException(
							"One of referenced sitemaps in $filename doesn't contain 'loc' attribute"
					);
				}
	
	
				if (!isset($child->lastmod)) {
					throw new \InvalidArgumentException(
							"One of referenced sitemaps in $filename doesn't contain 'lastmod' attribute"
					);
				}
				$lastmod = new \DateTime($child->lastmod);
	
				$urlsets[$child->loc->__toString()] = new UrlConcrete(
						$child->loc->__toString(),
						$lastmod,
						current($child->changefreq),
						current($child->priority)
				);
			}
		}
		return $urlsets;
	}
	
	
	public static  function addUrlTo($collection, $newurl){
		if(array_key_exists($newurl->getLoc(), $collection)) {
			foreach($collection as $c){
				if($c->getLoc() == $newurl->getLoc()){
					$collection[$c->getLoc()] = $newurl;
				}
			}
			return $collection;
		}
		$collection[$newurl->getLoc()] = $newurl;
		return $collection;
	}
}