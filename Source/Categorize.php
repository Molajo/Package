<?php
/**
 * Source
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Reflection;

use Exception;
use stdClass;

/**
 * Categorize PHP Reflection documentation for Project Repositories
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @api
 */
class Categorize
{
    /**
     * Output Data Folder
     *
     * @api
     * @var    object
     * @since  1.0.0
     */
    protected $data_folder = null;

    /**
     * Primary Project
     *
     * @api
     * @var    string
     * @since  1.0.0
     */
    protected $primary_project = 'Molajo';

    /**
     * Classes Input Data
     *
     * @api
     * @var    array
     * @since  1.0.0
     */
    protected $class_input_data = array();

    /**
     * Classes
     *
     * @api
     * @var    array
     * @since  1.0.0
     */
    protected $classes = array();

    /**
     * Categories
     *
     * @api
     * @var    array
     * @since  1.0.0
     */
    protected $categories = array(
        'author',
        'interfaces',
        'namespace',
        'namespace_project',
        'namespace_package',
        'source_repository',
        'interface_names'
    );

    /**
     * Categories
     *
     * @api
     * @var    array
     * @since  1.0.0
     */
    protected $category_classes = array();

    /**
     * Constructor
     *
     * @param  string $data_folder
     *
     * @since  1.0.0
     */
    public function __construct(
        $data_folder = '',
        $categories = array()
    ) {
        if ($data_folder === '') {
            $this->data_folder = __DIR__ . '/Data';
        } else {
            $this->data_folder = $data_folder;
        }

        if (is_array($categories) && count($categories) > 0) {
            $this->categories = $categories;
        }
    }

    /**
     * Using PHP Reflection and for the associative array of classes and namespaces, extract
     *  Class, Interface, Property, Method, and Parameter information
     *
     * @param  string $base_path
     * @param  array  $classmap
     * @param  string $primary_project
     * @param  string $primary_repository
     *
     * ```php
     *
     * $source = new \Molajo\Reflection\Categorize();
     * $response = $source->process($field_name, $field_value, $constraint, $options);
     *
     * if ($response->getValidateResponse() === true) {
     *     // all is well
     * } else {
     *      foreach ($response->getValidateMessages as $code => $message) {
     *          echo $code . ': ' . $message . '/n';
     *      }
     * }
     *
     * ```
     * @api
     * @return  \CommonApi\Model\ValidateResponseInterface
     * @since   1.0.0
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    public function process()
    {
        if (is_dir($this->data_folder)) {
        } else {
            throw new UnexpectedValueException('Molajo Categorize Process: Must provide data_folder');
        }

        $this->classes = array();
        foreach (glob($this->data_folder . '/*.json') as $filename) {
            $classes = $this->readFile($filename);
            foreach ($classes as $class) {
                $this->processCategories($class);
                $this->classes[$class->class_namespace] = $class;
            }
        }

        ksort($this->classes);
        foreach ($this->categories as $category) {
            $this->saveFile($category, $this->category_classes[$category]);
        }

        $this->saveFile('Classes', $this->classes);

        return $this;
    }

    /**
     * Save data to file
     *
     * @return  $this
     * @since   1.0.0
     */
    public function readFile($filename)
    {
        $input = file_get_contents($filename);

        $data = json_decode($input);

        return $data;
    }

    /**
     * Establish categories for class
     *
     * @param   object $class
     *
     * @return  $this
     * @since   1.0.0
     */
    public function processCategories($class)
    {
        foreach ($this->categories as $category) {

            if (isset($class->$category)) {
                $this->addCategoryClass($category, $class->$category, $class->class_namespace);
            }
        }

        return $this;
    }

    /**
     * Add Class to Category
     *
     * @param   string $class_namespace
     *
     * @return  $this
     * @since   1.0.0
     */
    public function addCategoryClass($category, $category_class_value, $class_namespace)
    {
        /** Primary Category: ex. Author */
        if (isset($this->category_classes[$category])) {
        } else {
            $this->category_classes[$category] = array();
        }

        $category_array = $this->category_classes[$category];

        if (is_array($category_class_value)) {

        } else {
            $temp                   = $category_class_value;
            $category_class_value   = array();
            $category_class_value[] = $temp;
        }

        foreach ($category_class_value as $value) {

            /** Does the category already have an entry for this value? (ex. Author = AmySephen) */
            if (isset($category_array[$value])) {
            } else {
                $category_array[$value] = array();
            }

            $category_class_value_array = $category_array[$value];

            /** Associate the class namespace with this value for this category */
            if (isset($category_class_value_array[$class_namespace])) {
            } else {
                $category_class_value_array[$class_namespace] = $class_namespace;
            }

            /** Put it back into the class property */
            ksort($category_class_value_array);
            $category_array[$value] = $category_class_value_array;
            ksort($category_array);
            $this->category_classes[$category] = $category_array;
            ksort($this->category_classes);
        }

        return $this;
    }

    /**
     * Save data to file
     *
     * @return  $this
     * @since   1.0.0
     */
    public function saveFile($filename, $data)
    {
        file_put_contents(
            $this->data_folder. '/' . $filename . '.json',
            json_encode($data, JSON_PRETTY_PRINT)
        );

        return $this;
    }
}
