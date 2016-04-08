<?php
namespace JiriNapravnik\Form\DI;

use JiriNapravnik\Form\Controls\DateTimePicker;
use JiriNapravnik\Form\Controls\DatePicker;
use Nette\DI\CompilerExtension;
use Nette\Forms\Container;
use Nette\PhpGenerator\ClassType;

/**
 * inspired by nextras/forms
 */
class FormExtension extends CompilerExtension
{

	public function afterCompile(ClassType $class)
	{
		$init = $class->getMethods()['initialize'];
		$init->addBody(__CLASS__ . '::registerControls();');
	}


	public static function registerControls()
	{
		Container::extensionMethod('addDatePicker', function (Container $container, $name, $label = NULL) {
			return $container[$name] = new DatePicker($label);
		});
		Container::extensionMethod('addDateTimePicker', function (Container $container, $name, $label = NULL) {
			return $container[$name] = new DateTimePicker($label);
		});
	}

}
