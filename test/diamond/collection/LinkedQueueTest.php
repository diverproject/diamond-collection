<?php

namespace test\diamond\collection;

/**
 * LinkedQueue test case.
 */
use PHPUnit\Framework\TestCase;
use diamond\collection\LinkedQueue;

/**
 * @see TestCase
 * @see LinkedQueue
 * @author Andrew
 */
class LinkedQueueTest extends TestCase
{
	/**
	 * @var int
	 */
	public const PRIORITY_QUEUE_LENGTH = 10;

	/**
	 *
	 * @var LinkedQueue
	 */
	private $linkedQueue;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->linkedQueue = new LinkedQueue();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		// TODO Auto-generated LinkedQueueTest::tearDown()
		$this->linkedQueue = null;
		parent::tearDown();
	}

	/**
	 * Tests LinkedQueue->clear()
	 */
	public function testClear()
	{
		$this->linkedQueue->clear();
		$this->assertEquals(0, $this->linkedQueue->size());
	}

	/**
	 * Tests LinkedQueue->size() as
	 * Tests LinkedQueue->count()
	 */
	public function testSize()
	{
		$this->linkedQueue->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $index => $element)
		{
			$this->assertTrue($this->linkedQueue->add($element));
			$this->assertEquals($index + 1, $this->linkedQueue->size());
			$this->assertEquals($index + 1, $this->linkedQueue->count());
		}
	}

	/**
	 * Tests LinkedQueue->isEmpty()
	 */
	public function testIsEmpty()
	{
		$this->linkedQueue->clear();
		$this->assertTrue($this->linkedQueue->isEmpty());

		$this->assertTrue($this->linkedQueue->add(rand(0, 255)));
		$this->assertFalse($this->linkedQueue->isEmpty());
	}

	/**
	 * Tests LinkedQueue->contains()
	 */
	public function testContains()
	{
		$this->linkedQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedQueue->add($element));

		$this->assertEquals($elements, $this->linkedQueue->toArray());
		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->linkedQueue->contains($element));
	}

	/**
	 * Tests LinkedQueue->containsAll()
	 */
	public function testContainsAll()
	{
		$this->linkedQueue->clear();
		$collection = new LinkedQueue();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->linkedQueue->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->linkedQueue->containsAll($collection));
		$this->assertEquals($collection->toArray(), $this->linkedQueue->toArray());
	}

	/**
	 * Tests LinkedQueue->add()
	 */
	public function testAdd()
	{
		$this->linkedQueue->clear();

		foreach ($this->newRandomElements() as $element)
			$this->assertTrue($this->linkedQueue->add($element));

		$this->assertEquals(self::PRIORITY_QUEUE_LENGTH, $this->linkedQueue->size());
		$this->assertEquals(self::PRIORITY_QUEUE_LENGTH, $this->linkedQueue->count());
	}

	/**
	 * Tests LinkedQueue->offer()
	 */
	public function testOffer()
	{
		$this->linkedQueue->clear();

		foreach ($this->newRandomElements() as $element)
			$this->assertTrue($this->linkedQueue->offer($element));

		$this->assertEquals(self::PRIORITY_QUEUE_LENGTH, $this->linkedQueue->size());
		$this->assertEquals(self::PRIORITY_QUEUE_LENGTH, $this->linkedQueue->count());
	}

	/**
	 * Tests LinkedQueue->addAll()
	 */
	public function testAddAll()
	{
		$this->linkedQueue->clear();
		$collection = new LinkedQueue();

		foreach ($this->newRandomElements() as $element)
			$collection->add($element);

		$this->assertTrue($this->linkedQueue->addAll($collection));
		$this->assertEquals($this->linkedQueue->toArray(), $collection->toArray());
	}

	/**
	 * Tests LinkedQueue->remove()
	 */
	public function testRemove()
	{
		$this->linkedQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedQueue->add($element));

		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->linkedQueue->remove($element));

		$this->assertTrue($this->linkedQueue->isEmpty());
	}

	/**
	 * Tests LinkedQueue->removeAll()
	 */
	public function testRemoveAll()
	{
		$this->linkedQueue->clear();
		$collection = new LinkedQueue();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($collection->add($element));
			$this->assertTrue($this->linkedQueue->add($element));
		}

		$this->assertTrue($this->linkedQueue->removeAll($collection));
		$this->assertTrue($this->linkedQueue->isEmpty());
	}

	/**
	 * Tests LinkedQueue->retainAll()
	 */
	public function testRetainAll()
	{
		$this->linkedQueue->clear();
		$collection = new LinkedQueue();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($collection->add($element));
			$this->assertTrue($this->linkedQueue->add($element));
		}

		$this->assertTrue(!$this->linkedQueue->retainAll($collection));
		$this->assertTrue($this->linkedQueue->isEmpty());
	}

	/**
	 * Tests LinkedQueue->poll()
	 */
	public function testPoll()
	{
		$this->linkedQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->linkedQueue->add($element);

		foreach ($elements as $element)
			$this->assertEquals($element, $this->linkedQueue->poll());

		$this->assertTrue($this->linkedQueue->isEmpty());
	}

	/**
	 * Tests LinkedQueue->peek()
	 */
	public function testPeek()
	{
		$this->linkedQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedQueue->offer($element));

		$this->assertEquals($elements, $this->linkedQueue->toArray());
		$this->assertEquals(self::PRIORITY_QUEUE_LENGTH, $this->linkedQueue->size());
		$this->assertEquals(self::PRIORITY_QUEUE_LENGTH, $this->linkedQueue->count());

		foreach ($elements as $element)
		{
			$this->assertEquals($element, $this->linkedQueue->peek());
			$this->linkedQueue->poll();
		}
	}

	/**
	 * Tests LinkedQueue->search()
	 */
	public function testSearch()
	{
		$this->linkedQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedQueue->offer($element));

		foreach ($elements as $element)
		{
			$index = $this->linkedQueue->search($element);
			$this->assertEquals($elements[$index], $element);
		}
	}

	/**
	 * Tests LinkedQueue->toArray()
	 */
	public function testToArray()
	{
		$this->linkedQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedQueue->offer($element));

		$this->assertEquals($elements, $this->linkedQueue->toArray());
	}

	/**
	 *
	 * @return array
	 */
	private function newRandomElements(): array
	{
		$array = [];

		for ($i = 0; $i < self::PRIORITY_QUEUE_LENGTH; $i++)
			$array[] = rand(0, 255);

		return $array;
	}
}

