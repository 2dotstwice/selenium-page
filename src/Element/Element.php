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
     * Converts a \PHPUnit_Extensions_Selenium2TestCase_Element object to the same type as the current class.
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
        // The driver and url properties that we need from the $source object are protected and inaccessible for us
        // here. To get around this we retrieve the property values using a ReflectionObject which can read any
        // properties.
        $sourceReflection = new \ReflectionObject($source);

        // Get the driver property.
        $driverProperty = $sourceReflection->getProperty('driver');
        $driverProperty->setAccessible(true);
        $driver = $driverProperty->getValue($source);

        // Get the url property.
        $urlProperty = $sourceReflection->getProperty('url');
        $urlProperty->setAccessible(true);
        $url = $urlProperty->getValue($source);

        // Instantiate a new object of the current class using the variables we got from the source object.
        return new self($driver, $url);
    }

    /**
     * Executes the post command to get the first element meeting the criteria inside the current element.
     *
     * Overwritten so the returned object is always of the type Element, which can then later be converted to a type
     * that extends Element using the from() method.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria
     *   Criteria the element should meet.
     *
     * @return Element
     */
    public function element(\PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria)
    {
        $element = parent::element($criteria);
        return Element::from($element);
    }

    /**
     * Executes the post command to get all elements meeting the criteria inside the current element.
     *
     * Overwritten so the returned objects are always of the type Element, which can then later be converted to a type
     * that extends Element using the from() method.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria
     *   Criteria the elements should meet.
     *
     * @return Element[]
     */
    public function elements(\PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria)
    {
        $elements = parent::elements($criteria);
        foreach ($elements as &$element) {
            $element = Element::from($element);
        }
        return $elements;
    }

    /**
     * Finds the first element matching the criteria inside the accessor.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase|\PHPUnit_Extensions_Selenium2TestCase_Element_Accessor $accessor
     *   Element accessor.
     * @param \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria
     *   Element access criteria.
     *
     * @return Element|null
     *   Either an Element object, or null if the element was not found.
     */
    public static function find($accessor, \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria)
    {
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
     * @param \PHPUnit_Extensions_Selenium2TestCase|\PHPUnit_Extensions_Selenium2TestCase_Element_Accessor $accessor
     *   Element accessor.
     * @param \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria
     *   Element access criteria.
     *
     * @return Element[]
     *   All elements matching the criteria inside the accessor.
     */
    public static function findAll($accessor, \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria)
    {
        // Make sure the accessor object is of a valid class. The two potential classes do not share a base class or
        // interface, so this is the only way to enforce a type hint for both.
        if (!self::validateAccessor($accessor)) {
            throw new ElementAccessorException(1, 'Element::findAll', $accessor);
        }

        // If the accessor is not an instance of the Element class, the resulting elements will not be either. However
        // we can't convert the accessor to an Element before retrieving the elements as it may not be of the type
        // \PHPUnit_Extensions_Selenium2TestCase_Element, so we need to convert the retrieved elements instead.
        $elements = $accessor->elements($criteria);
        if (!($accessor instanceof Element)) {
            foreach ($elements as &$element) {
                $element = Element::from($element);
            }
        }
        return $elements;
    }

    /**
     * Verifies that an object is a valid accessor.
     *
     * @param object $object
     *   Object to validate.
     *
     * @return bool
     *   True if the object is a valid accessor, false otherwise.
     */
    public static function validateAccessor($object)
    {
        foreach (self::getValidAccessorClassNames() as $className) {
            if (is_subclass_of($object, $className) || is_a($object, $className)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns a list of valid accessor class names.
     *
     * @return string[]
     *   List of valid accessor class names.
     */
    public static function getValidAccessorClassNames()
    {
        return array(
            "PHPUnit_Extensions_Selenium2TestCase",
            "PHPUnit_Extensions_Selenium2TestCase_Element_Accessor",
        );
    }

    /**
     * Waits until a specific (new) element is found and returns it.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase $testCase
     *   Test case that needs to wait.
     * @param \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria
     *   Element access criteria.
     * @param int $timeout
     *   Maximum time to wait, in milliseconds.
     *
     * @return Element|null
     *   The element if it was found, null otherwise.
     */
    public static function waitUntilFound(
        \PHPUnit_Extensions_Selenium2TestCase $testCase,
        \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria,
        $timeout
    ) {
        return $testCase->waitUntil(function () use ($testCase, $criteria) {
            return self::find($testCase, $criteria);
        }, $timeout);
    }

    /**
     * Waits until a specific (new) element is found inside an accessor and returns it.
     *
     * @param \PHPUnit_Extensions_Selenium2TestCase $testCase
     *   Test case that needs to wait.
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
    public static function waitUntilChildFound(
        \PHPUnit_Extensions_Selenium2TestCase $testCase,
        \PHPUnit_Extensions_Selenium2TestCase_Element_Accessor $accessor,
        \PHPUnit_Extensions_Selenium2TestCase_ElementCriteria $criteria,
        $timeout
    ) {
        return $testCase->waitUntil(function () use ($accessor, $criteria) {
            return self::find($accessor, $criteria);
        }, $timeout);
    }
}
