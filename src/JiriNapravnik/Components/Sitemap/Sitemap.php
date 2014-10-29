<?php

namespace JiriNapravnik\Components\Sitemap;

use DateTime;
use Nette\Application\UI\Control;
use Nette\Latte\Engine;
use Nette\Templating\FileTemplate;

class Sitemap extends Control
{

	const MAX_URL = 10000;

	private $urlToSitemap;
	private $sitemapDir;
	private $subdomain;
	private $urlsToSitemap = [];
	private $sitemapForSitemapIndex = [];

	public function __construct($urlToSitemap, $sitemapDir, $subdomain = NULL)
	{
		$this->urlToSitemap = $urlToSitemap;
		$this->sitemapDir = $sitemapDir;
		$this->subdomain = $subdomain;
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

	private function saveSitemap($sitemapId)
	{
		$sitemapTemplate = new FileTemplate(__DIR__ . '/sitemap.latte');
		$sitemapTemplate->registerFilter(new Engine);
		$sitemapTemplate->registerHelperLoader('\Nette\Templating\Helpers::loader');
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
		$this->sitemapForSitemapIndex[] = [
			'loc' => $this->urlToSitemap . $filename,
			'lastmod' => $this->getCorrectDate(filemtime($fullFilename)),
		];
	}

	private function saveSitemapIndex()
	{
		$sitemapIndexTemplate = new FileTemplate(__DIR__ . '/sitemapIndex.latte');
		$sitemapIndexTemplate->registerFilter(new Engine);
		$sitemapIndexTemplate->registerHelperLoader('\Nette\Templating\Helpers::loader');
		$sitemapIndexTemplate->sitemapForSitemapIndex = $this->sitemapForSitemapIndex;
		$xmlToSave = $sitemapIndexTemplate->__toString();

		if($this->subdomain !== NULL){
			$filename = 'sitemapIndex-' . $this->subdomain . '.xml';
		} else {
			$filename = 'sitemapIndex.xml';
		}
		
		if (file_exists($filename)) {
			unlink($filename);
		}

		file_put_contents($this->sitemapDir . $filename, $xmlToSave);
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

	private function getCorrectDate($datetime)
	{
		if(is_string($datetime)){
			$datetime = strtotime($datetime);
		}
		if (!$datetime instanceof DateTime) {
			$timestamp = $datetime;
			$datetime = new DateTime;
			$datetime->setTimestamp($timestamp);
		}
		return $datetime->format('Y-m-d');
	}

}
