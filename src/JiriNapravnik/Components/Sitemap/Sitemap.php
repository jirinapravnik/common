<?php

namespace JiriNapravnik\Components\Sitemap;

use DateTime;
use Nette\Application\UI\Control;
use Nette\Latte\Engine;
use Nette\Templating\FileTemplate;

class Sitemap extends Control
{

	const MAX_URL = 10000;

	protected $urlToSitemap;
	protected $sitemapDir;
	protected $subdomain;
	protected $urlsToSitemap = [];

	public function __construct($urlToSitemap, $sitemapDir, $subdomain = NULL)
	{
		$this->urlToSitemap = $urlToSitemap;
		$this->sitemapDir = $sitemapDir;
		$this->subdomain = $subdomain;
		
		if(!is_dir($sitemapDir)){
			mkdir($sitemapDir, 0777, TRUE);
		}
	}

	public function generateSitemap($items)
	{
		$i = 0;
		$sitemapId = 1;
		foreach ($items as $item) {
			$lastmod = $changefreq = $priority = NULL;
			if(isset($item['lastmod'])){
				$lastmod = $item['lastmod'];
			}
			if(isset($item['changefreq'])){
				$changefreq = $item['changefreq'];
			}
			if(isset($item['priority'])){
				$priority = $item['priority'];
			}
			$this->addUrlToSitemap($item['loc'], $lastmod, $changefreq, $priority);
			$i++;
			if ($i == self::MAX_URL) {
				$this->saveSitemap($sitemapId);
				$i = 0;
				$sitemapId++;
			}
		}
		if (count($this->urlsToSitemap) > 0) {
			$this->saveSitemap($sitemapId);
		}

		$this->saveSitemapIndex();
	}

	protected function saveSitemap($sitemapId)
	{
		$latte = new \Latte\Engine;
		$sitemapTemplate = new \Nette\Bridges\ApplicationLatte\Template($latte);
		$sitemapTemplate->setFile(__DIR__ . '/sitemap.latte');
		$sitemapTemplate->urlsToSitemap = $this->urlsToSitemap;
		$xmlToSave = $sitemapTemplate->__toString();

		if($this->subdomain !== NULL){
			$filename = 'sitemap-' . $this->subdomain . '-' . $sitemapId . '.xml';
		} else {
			$filename = 'sitemap-' . $sitemapId . '.xml';
		}


		$fullFilename = $this->sitemapDir . $filename;
		if (file_exists($fullFilename)) {
			unlink($fullFilename);
		}
		
		file_put_contents($fullFilename, $xmlToSave);
		$this->urlsToSitemap = [];
	}

	protected function saveSitemapIndex()
	{		
		if($this->subdomain !== NULL){
			$filenameSitemapIndex = 'sitemapIndex-' . $this->subdomain . '.xml';
		} else {
			$filenameSitemapIndex = 'sitemapIndex.xml';
		}
		if(file_exists($this->sitemapDir . $filenameSitemapIndex)){
			unlink($this->sitemapDir . $filenameSitemapIndex);
		}
		
		$sitemapIndexTemplate = new FileTemplate(__DIR__ . '/sitemapIndex.latte');
		$sitemapIndexTemplate->registerFilter(new Engine);
		$sitemapIndexTemplate->registerHelperLoader('\Nette\Templating\Helpers::loader');
		
		$files = glob($this->sitemapDir . '/*');
		
		usort($files, function($a, $b){ 
			return filemtime($b) - filemtime($a);
		});
		
		$files = array_map(function($item){
			return [
				'loc' => $this->urlToSitemap . basename($item),
				'lastmod' => $this->getCorrectDate(filemtime($item)),
			];
		}, $files);
		
		$sitemapIndexTemplate->sitemapForSitemapIndex = $files;
		$xmlToSave = $sitemapIndexTemplate->__toString();

		file_put_contents($this->sitemapDir . $filenameSitemapIndex, $xmlToSave);
	}

	private function addUrlToSitemap($loc, $lastmod, $changefreq, $priority)
	{
		$url = [];
		$url['loc'] = $loc;
		
		if($lastmod !== NULL){
			$url['lastmod'] = $this->getCorrectDate($lastmod);
		}
		if($changefreq !== NULL){
			$url['changeFreq'] = $changefreq;
		}
		if($priority !== NULL){
			$url['priority'] = $priority;
		}
		
		$this->urlsToSitemap[] = $url;
	}

	protected function getCorrectDate($datetime)
	{
		if(is_string($datetime)){
			$datetime = strtotime($datetime);
		}
		if (!$datetime instanceof DateTime) {
			$timestamp = $datetime;
			$datetime = new DateTime;
			$datetime->setTimestamp($timestamp);
		}
		return $datetime->format(DateTime::ISO8601);
	}

}
