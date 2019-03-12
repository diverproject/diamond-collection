<?php

namespace test\diamond\collection;

use diamond\collection\LinkedList;

/**
 * LinkedList test case with dynamic size.
 */
class LinkedListTest extends DiamondCollectionTest
{
	/**
	 * @var int
	 */
	public const LINKED_LIST_LENGTH = 10;

	/**
	 *
	 * @var LinkedList
	 */
	private $linkedList;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->linkedList = new LinkedList();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->linkedList = null;
		parent::tearDown();
	}

	/**
	 * Tests LinkedList->clear()
	 */
	public function testClear()
	{
		$this->linkedList->clear();
		$this->assertEquals(0, $this->linkedList->size());
	}

	/**
	 * Tests LinkedList->size() as
	 * Tests LinkedList->count()
	 */
	public function testSize()
	{
		$this->linkedList->clear();

		foreach ($this->newRandomElements() as $index => $element)
		{
			$this->assertTrue($this->linkedList->add($element));
			$this->assertEquals($index + 1, $this->linkedList->size());
			$this->assertEquals($index + 1, $this->linkedList->count());
		}
	}

	/**
	 * Tests LinkedList->isEmpty()
	 */
	public function testIsEmpty()
	{
		$this->linkedList->clear();
		$this->assertTrue($this->linkedList->isEmpty());

		$this->assertTrue($this->linkedList->add(rand(0, 255)));
		$this->assertFalse($this->linkedList->isEmpty());
	}

	/**
	 * Tests LinkedList->contains()
	 */
	public function testContains()
	{
		$this->linkedList->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedList->add($element));

		$this->assertEquals($elements, $this->linkedList->toArray());
		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->linkedList->contains($element));
	}

	/**
	 * Tests LinkedList->containsAll()
	 */
	public function testContainsAll()
	{
		$this->linkedList->clear();
		$collection = new LinkedList();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->linkedList->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->linkedList->containsAll($collection));
		$this->assertEquals($collection->toArray(), $this->linkedList->toArray());
	}

	/**
	 * Tests LinkedList->add()
	 */
	public function testAdd()
	{
		$this->linkedList->clear();

		for ($i = 0; $i < 5; $i++)
			$this->assertTrue($this->linkedList->add(rand(0, 255)));
	}

	/**
	 * Tests LinkedList->addAll()
	 */
	public function testAddAll()
	{
		$this->linkedList->clear();
		$collection = new LinkedList();

		foreach ($this->newRandomElements() as $element)
			$collection->add($element);

		$this->assertTrue($this->linkedList->addAll($collection));
	}

	/**
	 * Tests LinkedList->addIndex()
	 */
	public function testAddIndex()
	{
		$this->linkedList->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $element)
			$this->assertTrue($this->linkedList->addIndex(rand(0, $this->linkedList->count()), $element));
	}

	/**
	 * Tests LinkedList->set()
	 */
	public function testSetIndex()
	{
		$this->linkedList->clear();

		foreach ($this->newRandomElements() as $element)
			$this->assertTrue($this->linkedList->add($element));

		foreach (($elements = $this->newRandomElements()) as $index => $element)
		{
			$this->assertTrue($this->linkedList->setIndex($index, $element));
			$this->assertEquals($element, $this->linkedList->get($index));
		}

		$this->assertEquals($elements, $this->linkedList->toArray());
	}

	/**
	 * Tests LinkedList->replaceAll()
	 */
	public function testReplaceAll()
	{
		$this->linkedList->clear();
		$collection = new LinkedList();

		foreach ($this->newRandomElements() as $element)
			$this->assertTrue($this->linkedList->add($element));

		foreach ($this->newRandomElements() as $element)
			$collection->add($element);

		$this->assertTrue($this->linkedList->replaceAll($collection));
		$this->assertEquals($collection->toArray(), $this->linkedList->toArray());
	}

	/**
	 * Tests LinkedList->remove()
	 */
	public function testRemove()
	{
		$this->linkedList->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedList->add($element));

		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->linkedList->remove($element));

		$this->assertTrue($this->linkedList->isEmpty());
	}

	/**
	 * Tests LinkedList->removeIndex()
	 */
	public function testRemoveIndex()
	{
		$this->linkedList->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedList->add($element));

		for ($i = 0; $i < count($elements); $i++)
		{
			$index = rand(0, $this->linkedList->count() - 1);
			$indexElement = $this->linkedList->get($index);
			$this->assertEquals($indexElement, $this->linkedList->removeIndex($index));
		}

		foreach ($this->linkedList as $element)
			$this->assertTrue($element !== null);

		$this->assertTrue($this->linkedList->isEmpty());
	}

	/**
	 * Tests LinkedList->removeAll()
	 */
	public function testRemoveAll()
	{
		$this->linkedList->clear();
		$collection = new LinkedList();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->linkedList->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->linkedList->removeAll($collection));
		$this->assertTrue($this->linkedList->isEmpty());
	}

	/**
	 * Tests LinkedList->retainAll()
	 */
	public function testRetainAll()
	{
		$this->linkedList->clear();
		$collection = new LinkedList();

		foreach ($this->newRandomElements() as $index => $element)
		{
			$this->assertTrue($this->linkedList->add($element));
			$this->assertTrue($collection->add($index % 2 === 0 ? $element : $element + 255));
		}

		$this->assertTrue($this->linkedList->retainAll($collection));
		$this->assertEquals(5, $this->linkedList->size());
	}

	/**
	 * Tests LinkedList->get() and
	 * Tests iterator
	 */
	public function testGet()
	{
		$this->linkedList->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $element)
			$this->assertTrue($this->linkedList->add($element));

		foreach ($this->linkedList as $index => $element)
			$this->assertEquals($elements[$index], $this->linkedList->get($index));
	}

	/**
	 * Tests LinkedList->indexOf()
	 */
	public function testIndexOf()
	{
		$this->linkedList->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $element)
			$this->assertTrue($this->linkedList->add($element));

		foreach ($elements as $element)
		{
			$indexOf = $this->linkedList->indexOf($element);
			$this->assertEquals($elements[$indexOf], $this->linkedList->get($indexOf));
		}
	}

	/**
	 * Tests LinkedList->lastIndexOf()
	 */
	public function testLastIndexOf()
	{
		$this->linkedList->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $element)
			$this->assertTrue($this->linkedList->add($element));

		foreach ($elements as $element)
		{
			$lastIndexOf = $this->linkedList->lastIndexOf($element);
			$this->assertEquals($elements[$lastIndexOf], $this->linkedList->get($lastIndexOf));
		}
	}

	/**
	 * Tests LinkedList->poll()
	 */
	public function testPoll()
	{
		$this->linkedList->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $element)
			$this->assertTrue($this->linkedList->offer($element));

		foreach ($elements as $element)
			$this->assertEquals($element, $this->linkedList->poll());
	}

	/**
	 * Tests LinkedList->offer()
	 */
	public function testOffer()
	{
		$this->linkedList->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $element)
			$this->assertTrue($this->linkedList->offer($element));
	}

	/**
	 * Tests LinkedList->search()
	 */
	public function testSearch()
	{
		$this->linkedList->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $element)
			$this->assertTrue($this->linkedList->add($element));

		foreach ($elements as $element)
		{
			$index = $this->linkedList->search($element);
			$this->assertEquals($elements[$index], $this->linkedList->get($index));
		}
	}

	/**
	 *
	 * @return array
	 */
	private function newRandomElements(): array
	{
		$array = [];

		for ($i = 0; $i < self::LINKED_LIST_LENGTH; $i++)
			$array[] = rand(0, 255);

		return $array;
	}
}

