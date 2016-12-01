<?php

/**
 * RSS control
 *
 * @author Jan Marek
 * @license MIT
 * @copyright (c) Jan Marek 2009
 *
 * @property string $title
 * @property string $description
 * @property string $link
 * @property array $items
 * @property-read array $properties
 */

namespace JiriNapravnik\Components\Rss;

use Nette\Application\UI\Control;
use Nette\DateTime;
use Nette\InvalidStateException;
use Nette\Utils\Html;

class Rss extends Control
{

	/** @var array */
	private $properties;

	/** @var array */
	private $items;

	/**
	 * Render control
	 */
	public function render()
	{
		// properties
		$properties = $this->getProperties();
		$properties = $this->prepareProperties($properties);
		// check
		if (empty($properties['title']) || empty($properties['description']) || empty($properties['link'])) {
			throw new InvalidStateException('At least one of mandatory properties title, description or link was not set.');
		}

		// items
		$items = $this->getItems();
		foreach ($items as &$item) {
			$item = $this->prepareItem($item);
			
			// check
			if (empty($item['title']) && empty($item['description'])) {
				throw new InvalidStateException('One of title or description has to be set.');
			}
		}

		// render template
		$template = $this->getTemplate();
		$template->setFile(dirname(__FILE__) . '/rss.latte');

		$template->channelProperties = $properties;
		$template->items = $items;

		$template->render();
	}

	/**
	 * Convert date to RFC822
	 * @param string|date $date
	 * @return string
	 */
	public static function prepareDate($date)
	{
		return gmdate('D, d M Y H:i:s', DateTime::from($date)->getTimestamp()) . ' GMT';
	}

	/**
	 * Prepare channel properties
	 * @return array
	 */
	public function prepareProperties($properties)
	{
		if (isset($properties['pubDate'])) {
			$properties['pubDate'] = self::prepareDate($properties['pubDate']);
		}

		if (isset($properties['lastBuildDate'])) {
			$properties['lastBuildDate'] = self::prepareDate($properties['lastBuildDate']);
		}
		
		return $properties;
	}

	/**
	 * Prepare item
	 * @return array
	 */
	public function prepareItem($item)
	{
		// guid & link
		if (empty($item['guid']) && isset($item['link'])) {
			$item['guid'] = $item['link'];
		}

		if (empty($item['link']) && isset($item['guid'])) {
			$item['link'] = $item['guid'];
		}

		// pubDate
		if (isset($item['pubDate'])) {
			$item['pubDate'] = self::prepareDate($item['pubDate']);
		}
		
		if (isset($item['image'])) {
			if (strpos($item['image'], 'http://') === FALSE) {
				$item['image'] = trim($this->getChannelProperty('link'), '/') . '/' . $item['image'];
			}
			$imagePath = trim(parse_url($item['image'], PHP_URL_PATH), '/');
			$imgSize = getimagesize($imagePath);
			$item['enclosure']['attrs'] = [
				'url' => $item['image'],
				'type'=> $imgSize['mime'],
				'length' => filesize($imagePath)
			];
			unset($item['image']);
		}
		
		return $item;
	}

	// getters & setters

	/**
	 * Set channel property
	 * @param string $name
	 * @param mixed $value
	 */
	public function setChannelProperty($name, $value)
	{
		$this->properties[$name] = $value;
	}

	/**
	 * Get channel property
	 * @param string $name
	 * @return mixed
	 */
	public function getChannelProperty($name)
	{
		return $this->properties[$name];
	}

	/**
	 * Get properties
	 * @return array
	 */
	public function getProperties()
	{
		return $this->properties;
	}

	/**
	 * Set title
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->setChannelProperty('title', $title);
	}

	/**
	 * Get title
	 * @return string
	 */
	public function getTitle()
	{
		return $this->getChannelProperty('title');
	}

	/**
	 * Set description
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->setChannelProperty('description', $description);
	}

	/**
	 * Get description
	 * @return string
	 */
	public function getDescription()
	{
		return $this->getChannelProperty('description');
	}

	/**
	 * Set link
	 * @param string $link
	 */
	public function setLink($link)
	{
		$this->setChannelProperty('link', $link);
	}

	/**
	 * Get link
	 * @return string
	 */
	public function getLink()
	{
		return $this->getChannelProperty('link');
	}

	/**
	 * Set items
	 * @param array $items
	 */
	public function setItems($items)
	{
		$this->items = $items;
	}

	/**
	 * Get items
	 * @return array
	 */
	public function getItems()
	{
		return $this->items;
	}

}
