<?php

namespace test\diamond\collection;

use diamond\collection\LinkedStack;

/**
 * LinkedStack test case with dynamic size.
 */
class LinkedStackTest extends DiamondCollectionTest
{
	/**
	 * @var int
	 */
	public const LINKED_STACK_LENGTH = 10;

	/**
	 *
	 * @var LinkedStack
	 */
	private $linkedStack;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->linkedStack = new LinkedStack();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->linkedStack = null;
		parent::tearDown();
	}

	/**
	 * Tests LinkedStack->clear()
	 */
	public function testClear()
	{
		$this->linkedStack->clear();
		$this->assertEquals(0, $this->linkedStack->size());
	}

	/**
	 * Tests LinkedStack->size() as
	 * Tests LinkedStack->count()
	 */
	public function testSize()
	{
		$this->linkedStack->clear();

		foreach ($this->newRandomElements() as $index => $element)
		{
			$this->assertTrue($this->linkedStack->add($element));
			$this->assertEquals($index + 1, $this->linkedStack->size());
			$this->assertEquals($index + 1, $this->linkedStack->count());
		}
	}

	/**
	 * Tests LinkedStack->isEmpty()
	 */
	public function testIsEmpty()
	{
		$this->linkedStack->clear();
		$this->assertTrue($this->linkedStack->isEmpty());

		$this->assertTrue($this->linkedStack->add(rand(0, 255)));
		$this->assertFalse($this->linkedStack->isEmpty());
	}

	/**
	 * Tests LinkedStack->contains()
	 */
	public function testContains()
	{
		$this->linkedStack->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedStack->add($element));

		$this->assertEquals($elements, $this->linkedStack->toArray());
		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->linkedStack->contains($element));
	}

	/**
	 * Tests LinkedStack->containsAll()
	 */
	public function testContainsAll()
	{
		$this->linkedStack->clear();
		$collection = new LinkedStack();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->linkedStack->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->linkedStack->containsAll($collection));
		$this->assertEquals($collection->toArray(), $this->linkedStack->toArray());
	}

	/**
	 * Tests LinkedStack->add()
	 */
	public function testAdd()
	{
		$this->linkedStack->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedStack->add($element));

		$this->assertEquals($elements, $this->linkedStack->toArray());
	}

	/**
	 * Tests LinkedStack->push()
	 */
	public function testPush()
	{
		$this->linkedStack->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedStack->push($element));

		$this->assertEquals($elements, $this->linkedStack->toArray());
	}

	/**
	 * Tests LinkedStack->addAll()
	 */
	public function testAddAll()
	{
		$this->linkedStack->clear();
		$collection = new LinkedStack();

		foreach ($this->newRandomElements() as $element)
			$collection->add($element);

		$this->assertTrue($this->linkedStack->addAll($collection));
	}

	/**
	 * Tests LinkedStack->remove()
	 */
	public function testRemove()
	{
		$this->linkedStack->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedStack->add($element));

		foreach ($elements as $element)
			$this->assertTrue($this->linkedStack->remove($element));

		$this->assertTrue($this->linkedStack->isEmpty());
	}

	/**
	 * Tests LinkedStack->pop()
	 */
	public function testPop()
	{
		$this->linkedStack->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedStack->add($element));

		while (!$this->linkedStack->isEmpty())
			$this->assertEquals(array_pop($elements), $this->linkedStack->pop());

		$this->assertTrue($this->linkedStack->isEmpty());
	}

	/**
	 * Tests LinkedStack->peek()
	 */
	public function testPeek()
	{
		$this->linkedStack->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
		{
			$this->assertTrue($this->linkedStack->add($element));
			$this->assertEquals($element, $this->linkedStack->peek());
		}

		$this->assertEquals($elements, $this->linkedStack->toArray());
	}

	/**
	 * Tests LinkedStack->removeAll()
	 */
	public function testRemoveAll()
	{
		$this->linkedStack->clear();
		$collection = new LinkedStack();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->linkedStack->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->linkedStack->removeAll($collection));
		$this->assertTrue($this->linkedStack->isEmpty());
	}

	/**
	 * Tests LinkedStack->retainAll()
	 */
	public function testRetainAll()
	{
		$this->linkedStack->clear();
		$collection = new LinkedStack();

		foreach ($this->newRandomElements() as $index => $element)
		{
			$this->assertTrue($this->linkedStack->add($element));
			$this->assertTrue($collection->add($index % 2 === 0 ? $element : $element + 255));
		}

		$this->assertTrue($this->linkedStack->retainAll($collection));
		$this->assertEquals(5, $this->linkedStack->size());
	}

	/**
	 *
	 * @return array
	 */
	private function newRandomElements(): array
	{
		$array = [];

		for ($i = 0; $i < self::LINKED_STACK_LENGTH; $i++)
			$array[] = rand(0, 255);

		return $array;
	}
}

