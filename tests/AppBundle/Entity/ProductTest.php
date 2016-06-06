<?php
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;

/**
 * Created by PhpStorm.
 * User: Milutin Djukanovic
 * E-mail: milutin.djukanovic@gmail.com
 * Date: 7/6/2016
 * Time: 1:04
 */
class ProductTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Product
     */
    private $product;

    public function setUp()
    {
        $this->product = new Product();
    }

    public function testMutualConnectivity()
    {
        $product = $this->product;

        $category = new Category();

        $this->assertFalse($category->hasProduct($product));

        $product->setCategory($category);
        $this->assertTrue($category->hasProduct($product));

    }

    public function testCategoryAccessors()
    {
        $product = $this->product;

        $this->assertNull($product->getCategory());

        $category = new Category();
        $product->setCategory($category);

        $this->assertEquals($category, $product->getCategory());
        $this->assertTrue($category->hasProduct($product));
    }
}