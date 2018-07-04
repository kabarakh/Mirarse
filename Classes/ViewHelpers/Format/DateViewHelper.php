<?php
namespace Kabarakh\Mirarse\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class DateViewHelper extends AbstractViewHelper {
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('date', 'DateTime', '', true);
        $this->registerArgument('format', 'string', '', false, 'd.m.y');
    }

    public function render() {
        $date = $this->arguments['date'];
        $format = $this->arguments['format'];

        return $date->format($format);
    }
}