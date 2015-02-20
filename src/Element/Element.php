<?php

/**
 * @file
 * Contains \TwoDotsTwice\Selenium\Element\Element.
 */

namespace TwoDotsTwice\Selenium\Element;

/**
 * Class Element
 * @package TwoDotsTwice\Selenium\Element
 */
class Element extends \PHPUnit_Extensions_Selenium2TestCase_Element
{
    /**
     * Converts a \PHPUnit_Extensions_Selenium2TestCase_Element object to the
     * same type as the current class.
     *
     * Inspired by http://stackoverflow.com/a/9812059.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase_Element $source
     *   Existing \PHPUnit_Extensions_Selenium2TestCase_Element object.
     *
     * @return Element
     *   Element object.
     */
    public static function from(\PHPUnit_Extensions_Selenium2TestCase_Element $source)
    {
        // Get info about the source object.
        $sourceReflection = new \ReflectionObject($source);

        // Get the driver property.
        $driverProperty = $sourceReflection->getProperty('driver');
        $driverProperty->setAccessible(true);
        $driver = $driverProperty->getValue($source);

        // Get the url property.
        $urlProperty = $sourceReflection->getProperty('url');
        $urlProperty->setAccessible(true);
        $url = $urlProperty->getValue($source);

        // Determine the full class name (including namespace) for our new
        // Element object. This may not necessarily be Element if the method
        // is called from a class extending Element.
        $elementClassName = get_called_class();

        // Instantiate a new object of the class without calling its
        // constructor.
        $elementClass = new \ReflectionClass($elementClassName);
        return $elementClass->newInstance(array($driver, $url));
    }

    /**
     * Executes the post command to get the first element meeting the criteria
     * inside the current element.
     *
     * Overwritten so the returned object is always of the type Element, which
     * can then later be converted to a type that extends Element using the
     * from() method.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria
     *   Criteria the element should meet.
     *
     * @return Element
     */
    public function element(\PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria)
    {
        $value = $this->postCommand('element', $criteria);
        $parentFolder = $this->getSessionUrl()->descend('element');
        return Element::fromResponseValue($value, $parentFolder, $this->driver);
    }

    /**
     * Executes the post command to get all elements meeting the criteria inside
     * the current element.
     *
     * Overwritten so the returned objects are always of the type Element, which
     * can then later be converted to a type that extends Element using the
     * from() method.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria
     *   Criteria the elements should meet.
     *
     * @return Element[]
     */
    public function elements(\PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria)
    {
        $values = $this->postCommand('elements', $criteria);
        $parentFolder = $this->getSessionUrl()->descend('element');
        $elements = array();
        foreach ($values as $value) {
            $elements[] = Element::fromResponseValue($value, $parentFolder, $this->driver);
        }
        return $elements;
    }

    /**
     * Finds the first element matching the criteria inside the accessor.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase_Element_Accessor $accessor
     *   Element accessor.
     * @param \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria
     *   Element access criteria.
     *
     * @return Element|null
     *   Either an Element object, or null if the element was not found.
     */
    public static function find(
        \PHPUnit_Extensions_Selenium2TestCase_Element_Accessor $accessor,
        \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria
    ) {
        $elements = self::findAll($accessor, $criteria);
        if (!empty($elements)) {
            return $elements[0];
        } else {
            return null;
        }
    }

    /**
     * Finds all elements matching the criteria inside the accessor.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase_Element_Accessor $accessor
     *   Element accessor.
     * @param \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria
     *   Element access criteria.
     *
     * @return Element[]
     *   All elements matching the criteria inside the accessor.
     */
    public static function findAll(
        \PHPUnit_Extensions_Selenium2TestCase_Element_Accessor $accessor,
        \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria
    ) {
        // If the accessor is not an instance of the Element class, the
        // resulting elements will not be either. However we can't convert the
        // accessor to an Element before retrieving the elements as it may not
        // be of the type \PHPUnit_Extensions_Selenium2TestCase_Element, so we
        // need to convert the retrieved elements instead.
        $elements = $accessor->elements($criteria);
        if (!($accessor instanceof Element)) {
            foreach ($elements as &$element) {
                $element = Element::from($element);
            }
        }
        return $elements;
    }

    /**
     * Waits until a specific (new) element is found and returns it.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase_Element_Accessor $accessor
     *   Element accessor.
     * @param \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria
     *   Element access criteria.
     * @param int $timeout
     *   Maximum time to wait, in milliseconds.
     *
     * @return Element|null
     *   The element if it was found, null otherwise.
     */
    public static function waitUntilFound(
        \PHPUnit_Extensions_Selenium2TestCase_Element_Accessor $accessor,
        \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria,
        $timeout
    ) {
        $waitUntil = new \PHPUnit_Extensions_Selenium2TestCase_WaitUntil();
        return $waitUntil->run(function () use ($accessor, $criteria) {
            return self::find($accessor, $criteria);
        }, $timeout);
    }
}
