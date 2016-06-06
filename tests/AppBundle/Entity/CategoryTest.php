<?php
use AppBundle\Entity\Category;
use AppBundle\Entity\Company;
use AppBundle\Entity\Product;

/**
 * Created by PhpStorm.
 * User: Milutin Djukanovic
 * E-mail: milutin.djukanovic@gmail.com
 * Date: 7/6/2016
 * Time: 0:57
 */
class CategoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Category
     */
    private $category;

    public function setUp()
    {
        $this->category = new Category();
    }

    public function testGetName()
    {
        $this->category->setName('test name');
        $this->assertEquals('test name', $this->category->getName());
    }

    public function testGetProducts()
    {
        $this->assertCount(0, $this->category->getProducts());

        $this->category->addProduct(new Product());
        $this->assertCount(1, $this->category->getProducts());

        $product = new Product();
        $this->category->addProduct($product);
        $this->assertCount(2, $this->category->getProducts());

        $this->category->addProduct($product);
        $this->assertCount(2, $this->category->getProducts());
    }

    public function testAddProduct()
    {
        $product = new Product();
        $this->category->addProduct($product);
        $this->assertCount(1, $this->category->getProducts());

        $this->category->addProduct($product);
        $this->assertCount(1, $this->category->getProducts());
    }

    public function testHasProduct()
    {
        $product = new Product();
        $this->assertFalse($this->category->hasProduct($product));

        $this->category->addProduct($product);
        $this->assertTrue($this->category->hasProduct($product));
    }

    public function testMutualConnectivity()
    {
        $category = $this->category;

        $product = new Product();

        $this->assertNotEquals($category, $product->getCategory());

        $category->addProduct($product);
        $this->assertEquals($category, $product->getCategory());
    }

    public function testGetUniqueCompanies()
    {
        $audi = new Company();
        $mercedes = new Company();

        $r8 = new Product($audi);
        $a3 = new Product($audi);

        $this->assertTrue($audi->hasProduct($r8));
        $this->assertTrue($audi->hasProduct($a3));

        $cls = new Product($mercedes);
        $sClass = new Product($mercedes);

        $this->assertTrue($mercedes->hasProduct($cls));
        $this->assertTrue($mercedes->hasProduct($sClass));

        $category = new Category();
        $category->addProduct($r8);
        $category->addProduct($a3);
        $category->addProduct($cls);
        $category->addProduct($sClass);
        $category->addProduct($sClass);

        $this->assertCount(4, $category->getProducts());
        $this->assertCount(2, $category->getUniqueCompanies());
    }

}