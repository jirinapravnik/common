<?php

/**
 * Nette Framework Extras
 *
 * This source file is subject to the New BSD License.
 *
 * For more information please see http://addons.nette.org
 *
 * @copyright  Copyright (c) 2009 David Grudl
 * @license    New BSD License
 * @link       http://addons.nette.org
 * @package    Nette Extras
 */

namespace JiriNapravnik\Components\VisualPaginator;

use Nette\Utils\Paginator;

/**
 * Visual paginator control.
 *
 * @author     David Grudl
 * @copyright  Copyright (c) 2009 David Grudl
 * @package    Nette Extras
 */
class VisualPaginator extends \Nette\Application\UI\Control
{

    /** @var Nette\Utils\Paginator */
    private $paginator;

	private $templateFile;
	
    /** @persistent */
    public $page = 1;
	
	public $onShowPage = array();
	
	private $steps = 2;

	public function __construct()
	{
		$this->templateFile = __DIR__ . '/visualPaginator.latte';
	}
	
	public function setTemplateFile($templateFile)
	{
		$this->templateFile = $templateFile;
	}
	
    /**
     * @return \Nette\Utils\Paginator
     */
    public function getPaginator()
    {
        if (!$this->paginator) {
            $this->paginator = new Paginator;
        }

        return $this->paginator;
    }

	public function handleShowPage($page){
		$this->onShowPage($this, $page);
	}
	
	public function setSteps($steps){
		$this->steps = $steps;
	}
	
    /**
     * Renders paginator.
     * @param array $options
     * @return void
     */
    public function render($options = NULL)
    {
        $paginator = $this->getPaginator();
		
        if (NULL !== $options) {
            $paginator->setItemCount($options['count']);
            $paginator->setItemsPerPage($options['pageSize']);
        }

        $page = $paginator->page;

        if ($paginator->pageCount < 2) {
            $steps = array($page);
        } else {
            $arr = range(max($paginator->firstPage, $page - 3), min($paginator->lastPage, $page + 3));
			
            $count = 4;
            $quotient = ($paginator->pageCount - 1) / $count;
            for ($i = ($count - $this->steps); $i <= $count; $i++) {
                $arr[] = round($quotient * $i) + $paginator->firstPage;
            }
            sort($arr);
            $steps = array_values(array_unique($arr));
        }

        $this->template->steps = $steps;
        $this->template->paginator = $paginator;
		$this->template->isThereEvents = (count($this->onShowPage) > 0) ? TRUE : FALSE;

        $this->template->setFile($this->templateFile);
        $this->template->render();
    }

    /**
     * Loads state informations.
     * @param  array
     * @return void
     */
    public function loadState(array $params): void
    {
        parent::loadState($params);
        $this->getPaginator()->page = $this->page;
    }

}
