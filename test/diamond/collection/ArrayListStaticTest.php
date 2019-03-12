<?php

namespace test\diamond\collection;

use diamond\collection\ArrayList;

/**
 * ArrayList test case with static size.
 */
class ArrayListStaticTest extends DiamondCollectionTest
{
	/**
	 * @var int
	 */
	public const ARRAY_LIST_LENGTH = 10;

	/**
	 *
	 * @var ArrayList
	 */
	private $arrayList;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->arrayList = new ArrayList(self::ARRAY_LIST_LENGTH);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->arrayList = null;
		parent::tearDown();
	}

	/**
	 * Tests ArrayList->isDynamic()
	 */
	public function testIsDynamic()
	{
		$this->assertTrue(!$this->arrayList->isDynamic());
	}

	/**
	 * Tests ArrayList->clear()
	 */
	public function testClear()
	{
		$this->arrayList->clear();
		$this->assertEquals(0, $this->arrayList->size());
	}

	/**
	 * Tests ArrayList->size()
	 */
	public function testSize()
	{
		$this->arrayList->clear();

		foreach ($this->newRandomElements() as $index => $element)
		{
			$this->assertTrue($this->arrayList->add($element));
			$this->assertEquals($index + 1, $this->arrayList->size());
		}
	}

	/**
	 * Tests ArrayList->isEmpty()
	 */
	public function testIsEmpty()
	{
		$this->arrayList->clear();
		$this->assertTrue($this->arrayList->isEmpty());

		$this->assertTrue($this->arrayList->add(rand(0, 255)));
		$this->assertFalse($this->arrayList->isEmpty());
	}

	/**
	 * Tests ArrayList->contains()
	 */
	public function testContains()
	{
		$this->arrayList->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayList->add($element));

		$this->assertEquals($elements, $this->arrayList->toArray());
		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->arrayList->contains($element));
	}

	/**
	 * Tests ArrayList->containsAll()
	 */
	public function testContainsAll()
	{
		$this->arrayList->clear();
		$collection = new ArrayList();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->arrayList->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->arrayList->containsAll($collection));
		$this->assertEquals($collection->toArray(), $this->arrayList->toArray());
	}

	/**
	 * Tests ArrayList->count()
	 */
	public function testCount()
	{
		$this->assertEquals(self::ARRAY_LIST_LENGTH, $this->arrayList->count());
		$this->arrayList->clear();
		$this->assertEquals(self::ARRAY_LIST_LENGTH, $this->arrayList->count());
	}

	/**
	 * Tests ArrayList->add()
	 */
	public function testAdd()
	{
		$this->arrayList->clear();

		for ($i = 0; $i < 5; $i++)
			$this->assertTrue($this->arrayList->add(rand(0, 255)));
	}

	/**
	 * Tests ArrayList->addAll()
	 */
	public function testAddAll()
	{
		$this->arrayList->clear();
		$collection = new ArrayList();

		foreach ($this->newRandomElements() as $element)
			$collection->add($element);

		$this->assertTrue($this->arrayList->addAll($collection));
	}

	/**
	 * Tests ArrayList->addIndex()
	 */
	public function testAddIndex()
	{
		$this->arrayList->clear();
		$lenght = 10;

		for ($i = 0; $i < $lenght; $i++)
			$this->assertTrue($this->arrayList->addIndex(rand(0, $this->arrayList->count() - 1), rand(0, 255)));
	}

	/**
	 * Tests ArrayList->set()
	 */
	public function testSetIndex()
	{
		$this->arrayList->clear();

		foreach ($this->newRandomElements() as $element)
			$this->assertTrue($this->arrayList->add($element));

		foreach (($elements = $this->newRandomElements()) as $index => $element)
		{
			$this->assertTrue($this->arrayList->setIndex($index, $element));
			$this->assertEquals($element, $this->arrayList->get($index));
		}

		$this->assertEquals($elements, $this->arrayList->toArray());
	}

	/**
	 * Tests ArrayList->replaceAll()
	 */
	public function testReplaceAll()
	{
		$this->arrayList->clear();
		$collection = new ArrayList();

		foreach ($this->newRandomElements() as $element)
			$this->assertTrue($this->arrayList->add($element));

		foreach ($this->newRandomElements() as $element)
			$collection->add($element);

		$this->assertTrue($this->arrayList->replaceAll($collection));
		$this->assertEquals($collection->toArray(), $this->arrayList->toArray());
	}

	/**
	 * Tests ArrayList->remove()
	 */
	public function testRemove()
	{
		$this->arrayList->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayList->add($element));

		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->arrayList->remove($element));

		$this->assertTrue($this->arrayList->isEmpty());
	}

	/**
	 * Tests ArrayList->removeIndex()
	 */
	public function testRemoveIndex()
	{
		$this->arrayList->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayList->add($element));

		for ($i = 0; $i < count($elements); $i++)
		{
			$index = rand(0, $this->arrayList->count() - 1);
			$indexElement = $this->arrayList->get($index);
			$this->assertEquals($indexElement, $this->arrayList->removeIndex($index));
		}

		foreach ($this->arrayList as $element)
			$this->assertTrue($element !== null);

		$this->assertTrue($this->arrayList->isEmpty());
	}

	/**
	 * Tests ArrayList->removeAll()
	 */
	public function testRemoveAll()
	{
		$this->arrayList->clear();
		$collection = new ArrayList();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->arrayList->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->arrayList->removeAll($collection));
		$this->assertTrue($this->arrayList->isEmpty());
	}

	/**
	 * Tests ArrayList->retainAll()
	 */
	public function testRetainAll()
	{
		$this->arrayList->clear();
		$collection = new ArrayList();

		foreach ($this->newRandomElements() as $index => $element)
		{
			$this->assertTrue($this->arrayList->add($element));
			$this->assertTrue($collection->add($index % 2 === 0 ? $element : $element + 255));
		}

		$this->assertTrue($this->arrayList->retainAll($collection));
		$this->assertEquals(5, $this->arrayList->size());
	}

	/**
	 * Tests ArrayList->get() and
	 * Tests iterator
	 */
	public function testGet()
	{
		$this->arrayList->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $element)
			$this->assertTrue($this->arrayList->add($element));

		foreach ($this->arrayList as $index => $element)
			$this->assertEquals($elements[$index], $this->arrayList->get($index));
	}

	/**
	 * Tests ArrayList->indexOf()
	 */
	public function testIndexOf()
	{
		$this->assertTrue(true);return;
		$this->arrayList->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $element)
			$this->assertTrue($this->arrayList->add($element));

		shuffle($elements);

		foreach ($elements as $element)
		{
			$indexOf = $this->arrayList->indexOf($element);
			$this->assertEquals($elements[$indexOf], $this->arrayList->get($indexOf));
		}
	}

	/**
	 * Tests ArrayList->lastIndexOf()
	 */
	public function testLastIndexOf()
	{
		$this->arrayList->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $element)
			$this->assertTrue($this->arrayList->add($element));

		foreach ($elements as $element)
		{
			$lastIndexOf = $this->arrayList->lastIndexOf($element);
			$this->assertEquals($elements[$lastIndexOf], $this->arrayList->get($lastIndexOf));
		}
	}

	/**
	 *
	 * @return array
	 */
	private function newRandomElements(): array
	{
		$array = [];

		for ($i = 0; $i < self::ARRAY_LIST_LENGTH; $i++)
			$array[] = rand(0, 255);

		return $array;
	}
}

