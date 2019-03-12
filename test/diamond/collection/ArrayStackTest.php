<?php

namespace test\diamond\collection;

use diamond\collection\ArrayStack;

/**
 * ArrayStack test case with dynamic size.
 */
class ArrayStackDynamicTest extends DiamondCollectionTest
{
	/**
	 * @var int
	 */
	public const ARRAY_STACK_LENGTH = 10;

	/**
	 *
	 * @var ArrayStack
	 */
	private $arrayStack;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->arrayStack = new ArrayStack(self::ARRAY_STACK_LENGTH);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->arrayStack = null;
		parent::tearDown();
	}

	/**
	 * Tests ArrayStack->clear()
	 */
	public function testClear()
	{
		$this->arrayStack->clear();
		$this->assertEquals(0, $this->arrayStack->size());
	}

	/**
	 * Tests ArrayStack->size() as
	 * Tests ArrayStack->count()
	 */
	public function testSize()
	{
		$this->arrayStack->clear();

		foreach ($this->newRandomElements() as $index => $element)
		{
			$this->assertTrue($this->arrayStack->add($element));
			$this->assertEquals($index + 1, $this->arrayStack->size());
			$this->assertEquals($index + 1, $this->arrayStack->count());
		}
	}

	/**
	 * Tests ArrayStack->isEmpty()
	 */
	public function testIsEmpty()
	{
		$this->arrayStack->clear();
		$this->assertTrue($this->arrayStack->isEmpty());

		$this->assertTrue($this->arrayStack->add(rand(0, 255)));
		$this->assertFalse($this->arrayStack->isEmpty());
	}

	/**
	 * Tests ArrayStack->contains()
	 */
	public function testContains()
	{
		$this->arrayStack->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayStack->add($element));

		$this->assertEquals($elements, $this->arrayStack->toArray());
		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->arrayStack->contains($element));
	}

	/**
	 * Tests ArrayStack->containsAll()
	 */
	public function testContainsAll()
	{
		$this->arrayStack->clear();
		$collection = new ArrayStack(self::ARRAY_STACK_LENGTH);

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->arrayStack->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->arrayStack->containsAll($collection));
		$this->assertEquals($collection->toArray(), $this->arrayStack->toArray());
	}

	/**
	 * Tests ArrayStack->add()
	 */
	public function testAdd()
	{
		$this->arrayStack->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayStack->add($element));

		$this->assertEquals($elements, $this->arrayStack->toArray());
	}

	/**
	 * Tests ArrayStack->push()
	 */
	public function testPush()
	{
		$this->arrayStack->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayStack->push($element));

		$this->assertEquals($elements, $this->arrayStack->toArray());
	}

	/**
	 * Tests ArrayStack->addAll()
	 */
	public function testAddAll()
	{
		$this->arrayStack->clear();
		$collection = new ArrayStack(self::ARRAY_STACK_LENGTH);

		foreach ($this->newRandomElements() as $element)
			$collection->add($element);

		$this->assertTrue($this->arrayStack->addAll($collection));
	}

	/**
	 * Tests ArrayStack->remove()
	 */
	public function testRemove()
	{
		$this->arrayStack->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayStack->add($element));

		foreach ($elements as $element)
			$this->assertTrue($this->arrayStack->remove($element));

		$this->assertTrue($this->arrayStack->isEmpty());
	}

	/**
	 * Tests ArrayStack->pop()
	 */
	public function testPop()
	{
		$this->arrayStack->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayStack->add($element));

		while (!$this->arrayStack->isEmpty())
			$this->assertEquals(array_pop($elements), $this->arrayStack->pop());

		$this->assertTrue($this->arrayStack->isEmpty());
	}

	/**
	 * Tests ArrayStack->peek()
	 */
	public function testPeek()
	{
		$this->arrayStack->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
		{
			$this->assertTrue($this->arrayStack->add($element));
			$this->assertEquals($element, $this->arrayStack->peek());
		}

		$this->assertEquals($elements, $this->arrayStack->toArray());
	}

	/**
	 * Tests ArrayStack->removeAll()
	 */
	public function testRemoveAll()
	{
		$this->arrayStack->clear();
		$collection = new ArrayStack(self::ARRAY_STACK_LENGTH);

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->arrayStack->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->arrayStack->removeAll($collection));
		$this->assertTrue($this->arrayStack->isEmpty());
	}

	/**
	 * Tests ArrayStack->retainAll()
	 */
	public function testRetainAll()
	{
		$this->arrayStack->clear();
		$collection = new ArrayStack(self::ARRAY_STACK_LENGTH);

		foreach ($this->newRandomElements() as $index => $element)
		{
			$this->assertTrue($this->arrayStack->add($element));
			$this->assertTrue($collection->add($index % 2 === 0 ? $element : $element + 255));
		}

		$this->assertTrue($this->arrayStack->retainAll($collection));
		$this->assertEquals(5, $this->arrayStack->size());
	}

	/**
	 *
	 * @return array
	 */
	private function newRandomElements(): array
	{
		$array = [];

		for ($i = 0; $i < self::ARRAY_STACK_LENGTH; $i++)
			$array[] = rand(0, 255);

		return $array;
	}
}

