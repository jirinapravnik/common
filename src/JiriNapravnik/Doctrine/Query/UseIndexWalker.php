<?php

/**
 * UseIndexWalker
 *
 * @author Jiří Nápravník (http://jirinapravnik.cz)
 * @copyright Copyright (c) 2014, Jiří Nápravník
 */
namespace JiriNapravnik\Doctrine\Query;

use Doctrine\ORM\Query\SqlWalker;

/**
 * Quick hack to allow adding a USE INDEX on the query
 */
class UseIndexWalker extends SqlWalker
{
    const HINT_USE_INDEX = 'UseIndexWalker.UseIndex';

    public function walkFromClause($fromClause)
    {
        $result = parent::walkFromClause($fromClause);
		
        if ($index = $this->getQuery()->getHint(self::HINT_USE_INDEX)) {
            $result = preg_replace('#(\bFROM\s*\w+\s*\w+)#', '\1 USE INDEX (' . $index . ')', $result);
        }

        return $result;
    }
}