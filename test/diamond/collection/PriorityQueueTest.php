<?php

namespace test\diamond\collection;

/**
 * PriorityQueue test case.
 */
use PHPUnit\Framework\TestCase;
use diamond\collection\PriorityQueue;

/**
 * @see TestCase
 * @see PriorityQueue
 * @author Andrew
 */
class PriorityQueueTest extends TestCase
{
	/**
	 * @var int
	 */
	public const PRIORITY_QUEUE_LENGTH = 10;

	/**
	 *
	 * @var PriorityQueue
	 */
	private $priorityQueue;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->priorityQueue = new PriorityQueue();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		// TODO Auto-generated PriorityQueueTest::tearDown()
		$this->priorityQueue = null;
		parent::tearDown();
	}

	/**
	 * Tests PriorityQueue->clear()
	 */
	public function testClear()
	{
		$this->priorityQueue->clear();
		$this->assertEquals(0, $this->priorityQueue->size());
	}

	/**
	 * Tests PriorityQueue->size() as
	 * Tests PriorityQueue->count()
	 */
	public function testSize()
	{
		$this->priorityQueue->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $index => $element)
		{
			$this->assertTrue($this->priorityQueue->add($element));
			$this->assertEquals($index + 1, $this->priorityQueue->size());
			$this->assertEquals($index + 1, $this->priorityQueue->count());
		}
	}

	/**
	 * Tests PriorityQueue->isEmpty()
	 */
	public function testIsEmpty()
	{
		$this->priorityQueue->clear();
		$this->assertTrue($this->priorityQueue->isEmpty());

		$this->assertTrue($this->priorityQueue->add(rand(0, 255)));
		$this->assertFalse($this->priorityQueue->isEmpty());
	}

	/**
	 * Tests PriorityQueue->contains()
	 */
	public function testContains()
	{
		$this->priorityQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->priorityQueue->add($element));

		sort($elements);
		$this->assertEquals($elements, $this->priorityQueue->toArray());
		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->priorityQueue->contains($element));
	}

	/**
	 * Tests PriorityQueue->containsAll()
	 */
	public function testContainsAll()
	{
		$this->priorityQueue->clear();
		$collection = new PriorityQueue();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->priorityQueue->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->priorityQueue->containsAll($collection));
		$this->assertEquals($collection->toArray(), $this->priorityQueue->toArray());
	}

	/**
	 * Tests PriorityQueue->add()
	 */
	public function testAdd()
	{
		$this->priorityQueue->clear();

		foreach ($this->newRandomElements() as $element)
			$this->assertTrue($this->priorityQueue->add($element));

		$this->assertEquals(self::PRIORITY_QUEUE_LENGTH, $this->priorityQueue->size());
		$this->assertEquals(self::PRIORITY_QUEUE_LENGTH, $this->priorityQueue->count());
	}

	/**
	 * Tests PriorityQueue->offer()
	 */
	public function testOffer()
	{
		$this->priorityQueue->clear();

		foreach ($this->newRandomElements() as $element)
			$this->assertTrue($this->priorityQueue->offer($element));

		$this->assertEquals(self::PRIORITY_QUEUE_LENGTH, $this->priorityQueue->size());
		$this->assertEquals(self::PRIORITY_QUEUE_LENGTH, $this->priorityQueue->count());
	}

	/**
	 * Tests PriorityQueue->addAll()
	 */
	public function testAddAll()
	{
		$this->priorityQueue->clear();
		$collection = new PriorityQueue();

		foreach ($this->newRandomElements() as $element)
			$collection->add($element);

		$this->assertTrue($this->priorityQueue->addAll($collection));
		$this->assertEquals($this->priorityQueue->toArray(), $collection->toArray());
	}

	/**
	 * Tests PriorityQueue->remove()
	 */
	public function testRemove()
	{
		$this->priorityQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->priorityQueue->add($element));

		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->priorityQueue->remove($element));

		$this->assertTrue($this->priorityQueue->isEmpty());
	}

	/**
	 * Tests PriorityQueue->removeAll()
	 */
	public function testRemoveAll()
	{
		$this->priorityQueue->clear();
		$collection = new PriorityQueue();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($collection->add($element));
			$this->assertTrue($this->priorityQueue->add($element));
		}

		$this->assertTrue($this->priorityQueue->removeAll($collection));
		$this->assertTrue($this->priorityQueue->isEmpty());
	}

	/**
	 * Tests PriorityQueue->retainAll()
	 */
	public function testRetainAll()
	{
		$this->priorityQueue->clear();
		$collection = new PriorityQueue();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($collection->add($element));
			$this->assertTrue($this->priorityQueue->add($element));
		}

		$this->assertTrue(!$this->priorityQueue->retainAll($collection));
		$this->assertTrue($this->priorityQueue->isEmpty());
	}

	/**
	 * Tests PriorityQueue->poll()
	 */
	public function testPoll()
	{
		$this->priorityQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->priorityQueue->add($element);

		asort($elements);

		foreach ($elements as $element)
			$this->assertEquals($element, $this->priorityQueue->poll());

		$this->assertTrue($this->priorityQueue->isEmpty());
	}

	/**
	 * Tests PriorityQueue->peek()
	 */
	public function testPeek()
	{
		$this->priorityQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->priorityQueue->offer($element));

		sort($elements);
		$this->assertEquals($elements, $this->priorityQueue->toArray());
		$this->assertEquals(self::PRIORITY_QUEUE_LENGTH, $this->priorityQueue->size());
		$this->assertEquals(self::PRIORITY_QUEUE_LENGTH, $this->priorityQueue->count());

		foreach ($elements as $element)
		{
			$this->assertEquals($element, $this->priorityQueue->peek());
			$this->priorityQueue->poll();
		}
	}

	/**
	 * Tests PriorityQueue->search()
	 */
	public function testSearch()
	{
		$this->priorityQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->priorityQueue->offer($element));

		sort($elements);

		foreach ($elements as $element)
		{
			$index = $this->priorityQueue->search($element);
			$this->assertEquals($elements[$index], $element);
		}
	}

	/**
	 * Tests PriorityQueue->toArray()
	 */
	public function testToArray()
	{
		$this->priorityQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->priorityQueue->offer($element));

		sort($elements);

		$this->assertEquals($elements, $this->priorityQueue->toArray());
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

