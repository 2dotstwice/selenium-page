<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Element\ElementAccessorException.
 */

namespace TwoDotsTwice\Selenium\Element;

/**
 * Class ElementAccessorException
 * @package TwoDotsTwice\Selenium\Element
 */
class ElementAccessorException extends \Exception
{
    /**
     * Constructs a new ElementAccessorException object.
     *
     * @param int $argumentNumber
     *   Number of the argument that should be an accepted element accessor class.
     * @param string $methodName
     *   Name of the class and method called.
     * @param object $object
     *   Object passed that was of an incorrect type.
     */
    public function __construct($argumentNumber, $methodName, $object)
    {
        $acceptableTypes = Element::getValidAccessorClassNames();
        $typeGiven = get_class($object);

        $message = "Argument " . $argumentNumber . " passed to " . $methodName . " must be an instance of " .
            implode(" or ", $acceptableTypes) . ', ' . $typeGiven . " given.";

        parent::__construct($message);
    }
}
