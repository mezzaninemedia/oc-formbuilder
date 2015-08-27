<?php namespace Mezzanine\FormBuilder\Classes;

use ApplicationException;
use Validator;
use Lang;
use Event;

/**
 * Represents a menu item.
 * This class is used in the back-end for managing the menu items.
 * On the front-end items are represented with the
 * \Mezzanine\FormBuilder\Classes\FormFieldReference objects.
 *
 * @package rainlab\pages
 * @author Alexey Bobkov, Samuel Georges
 */
class FormField
{
    /**
     * @var string Specifies the menu title
     */
    public $title;

    /**
     * @var array Specifies the item subitems
     */
    public $items = [];

    /**
     * @var string Specifies the parent menu item.
     * An object of the Mezzanine\FormBuilder\Classes\FormField class or null.
     */
    public $parent;

    /**
     * @var boolean Determines whether the auto-generated menu items could have subitems.
     */
    public $nesting;

    /**
     * @var string Specifies the menu item type - URL, static page, etc.
     */
    public $type;

    /**
     * @var string Specifies the URL for URL-type items.
     */
    public $url;

    /**
     * @var string Specifies the menu item code.
     */
    public $code;

    /**
     * @var string Specifies the object identifier the item refers to.
     * The identifier could be the database identifier or an object code.
     */
    public $reference;

    /**
     * @var boolean Indicates that generated items should replace this item.
     */
    public $replace;

    /**
     * @var string Specifies the CMS page path to resolve dynamic menu items to.
     */
    public $cmsPage;

    /**
     * @var boolean Used by the system internally.
     */
    public $exists = false;

    public $fillable = [
        'title',
        'nesting',
        'type',
        'url',
        'code',
        'reference',
        'cmsPage',
        'replace'
    ];

    /**
     * Initializes a menu item from a data array.
     * @param array $items Specifies the menu item data.
     * @return Returns an array of the FormField objects.
     */
    public static function initFromArray($items)
    {
        $result = [];

        foreach ($items as $itemData) {
            $obj = new self;

            foreach ($itemData as $name => $value) {
                if ($name != 'items') {
                    if (property_exists($obj, $name)) {
                        $obj->$name = $value;
                    }
                }
                else {
                    $obj->items = self::initFromArray($value);
                }
            }

            $result[] = $obj;
        }

        return $result;
    }

    /**
     * Returns a list of registered menu item types
     * @return array Returns an array of registered item types
     */
    public function getTypeOptions($keyValue = null)
    {
        $result = ['url' => 'URL'];

        $apiResult = Event::fire('pages.menuitem.listTypes');
        if (is_array($apiResult)) {
            foreach ($apiResult as $typeList) {
                if (!is_array($typeList)) {
                    continue;
                }

                foreach ($typeList as $typeCode => $typeName) {
                    $result[$typeCode] = $typeName;
                }
            }
        }

        return $result;
    }

    public function getCmsPageOptions($keyValue = null)
    {
        return []; // CMS FormBuilder are loaded client-side
    }

    public function getReferenceOptions($keyValue = null)
    {
        return []; // References are loaded client-side
    }

    public static function getTypeInfo($type)
    {
        $result = [];
        $apiResult = Event::fire('pages.menuitem.getTypeInfo', [$type]);
        if (is_array($apiResult)) {
            foreach ($apiResult as $typeInfo) {
                if (!is_array($typeInfo)) {
                    continue;
                }

                foreach ($typeInfo as $name => $value) {
                    if ($name == 'cmsFormBuilder') {
                        $cmsFormBuilder = [];

                        foreach ($value as $page) {
                            $baseName = $page->getBaseFileName();
                            $pos = strrpos($baseName, '/');

                            $dir = $pos !== false ? substr($baseName, 0, $pos).' / ' : null;
                            $cmsFormBuilder[$baseName] = strlen($page->title)
                                ? $dir.$page->title
                                : $baseName;
                        }

                        $value = $cmsFormBuilder;
                    }

                    $result[$name] = $value;
                }
            }
        }

        return $result;
    }

    /**
     * Converts the menu item data to an array
     * @return array Returns the menu item data as array
     */
    public function toArray()
    {
        $result = [];
        foreach ($this->fillable as $property) {
            $result[$property] = $this->$property;
        }

        return $result;
    }
}
