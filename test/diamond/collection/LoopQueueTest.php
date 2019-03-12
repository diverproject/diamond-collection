<?php

namespace test\diamond\collection;

/**
 * LoopQueue test case.
 */
use PHPUnit\Framework\TestCase;
use diamond\collection\LoopQueue;

/**
 * @see TestCase
 * @see LoopQueue
 * @author Andrew
 */
class LoopQueueTest extends TestCase
{
	/**
	 * @var int
	 */
	public const LOOP_QUEUE_LENGTH = 10;

	/**
	 *
	 * @var LoopQueue
	 */
	private $loopQueue;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->loopQueue = new LoopQueue(self::LOOP_QUEUE_LENGTH);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		// TODO Auto-generated LoopQueueTest::tearDown()
		$this->loopQueue = null;
		parent::tearDown();
	}

	/**
	 * Tests LoopQueue->clear()
	 */
	public function testClear()
	{
		$this->loopQueue->clear();
		$this->assertEquals(0, $this->loopQueue->size());
	}

	/**
	 * Tests LoopQueue->size() as
	 * Tests LoopQueue->count()
	 */
	public function testSize()
	{
		$this->loopQueue->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $index => $element)
		{
			$this->assertTrue($this->loopQueue->add($element));
			$this->assertEquals($index + 1, $this->loopQueue->size());
			$this->assertEquals($index + 1, $this->loopQueue->count());
		}

		$this->assertFalse($this->loopQueue->add(rand()));
	}

	/**
	 * Tests LoopQueue->isEmpty()
	 */
	public function testIsEmpty()
	{
		$this->loopQueue->clear();
		$this->assertTrue($this->loopQueue->isEmpty());

		$this->assertTrue($this->loopQueue->add(rand(0, 255)));
		$this->assertFalse($this->loopQueue->isEmpty());
	}

	/**
	 * Tests LoopQueue->contains()
	 */
	public function testContains()
	{
		$this->loopQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->loopQueue->add($element));

		$this->assertEquals($elements, $this->loopQueue->toArray());
		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->loopQueue->contains($element));
	}

	/**
	 * Tests LoopQueue->containsAll()
	 */
	public function testContainsAll()
	{
		$this->loopQueue->clear();
		$collection = new LoopQueue(self::LOOP_QUEUE_LENGTH);

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->loopQueue->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->loopQueue->containsAll($collection));
		$this->assertEquals($collection->toArray(), $this->loopQueue->toArray());
	}

	/**
	 * Tests LoopQueue->add()
	 */
	public function testAdd()
	{
		$this->loopQueue->clear();

		foreach ($this->newRandomElements() as $element)
			$this->assertTrue($this->loopQueue->add($element));

		$this->assertEquals(self::LOOP_QUEUE_LENGTH, $this->loopQueue->size());
		$this->assertEquals(self::LOOP_QUEUE_LENGTH, $this->loopQueue->count());
	}

	/**
	 * Tests LoopQueue->offer()
	 */
	public function testOffer()
	{
		$this->loopQueue->clear();

		foreach ($this->newRandomElements() as $element)
			$this->assertTrue($this->loopQueue->offer($element));

		$this->assertEquals(self::LOOP_QUEUE_LENGTH, $this->loopQueue->size());
		$this->assertEquals(self::LOOP_QUEUE_LENGTH, $this->loopQueue->count());
	}

	/**
	 * Tests LoopQueue->addAll()
	 */
	public function testAddAll()
	{
		$this->loopQueue->clear();
		$collection = new LoopQueue(self::LOOP_QUEUE_LENGTH);

		foreach ($this->newRandomElements() as $element)
			$collection->add($element);

		$this->assertTrue($this->loopQueue->addAll($collection));
		$this->assertEquals($this->loopQueue->toArray(), $collection->toArray());
	}

	/**
	 * Tests LoopQueue->remove()
	 */
	public function testRemove()
	{
		$this->loopQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->loopQueue->add($element));

		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->loopQueue->remove($element));

		$this->assertTrue($this->loopQueue->isEmpty());
	}

	/**
	 * Tests LoopQueue->removeAll()
	 */
	public function testRemoveAll()
	{
		$this->loopQueue->clear();
		$collection = new LoopQueue(self::LOOP_QUEUE_LENGTH);

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($collection->add($element));
			$this->assertTrue($this->loopQueue->add($element));
		}

		$this->assertTrue($this->loopQueue->removeAll($collection));
		$this->assertTrue($this->loopQueue->isEmpty());
	}

	/**
	 * Tests LoopQueue->retainAll()
	 */
	public function testRetainAll()
	{
		$this->loopQueue->clear();
		$collection = new LoopQueue(self::LOOP_QUEUE_LENGTH);

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($collection->add($element));
			$this->assertTrue($this->loopQueue->add($element));
		}

		$this->assertTrue(!$this->loopQueue->retainAll($collection));
		$this->assertTrue($this->loopQueue->isEmpty());
	}

	/**
	 * Tests LoopQueue->poll()
	 */
	public function testPoll()
	{
		$this->loopQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->loopQueue->add($element);

		foreach ($elements as $element)
			$this->assertEquals($element, $this->loopQueue->poll());

		$this->assertTrue($this->loopQueue->isEmpty());
	}

	/**
	 * Tests LoopQueue->peek()
	 */
	public function testPeek()
	{
		$this->loopQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->loopQueue->offer($element));

		$this->assertEquals(self::LOOP_QUEUE_LENGTH, $this->loopQueue->size());
		$this->assertEquals(self::LOOP_QUEUE_LENGTH, $this->loopQueue->count());
		$this->assertEquals($elements, $this->loopQueue->toArray());

		foreach ($elements as $element)
		{
			$this->assertEquals($element, $this->loopQueue->peek());
			$this->loopQueue->poll();
		}
	}

	/**
	 * Tests LoopQueue->search()
	 */
	public function testSearch()
	{
		$this->loopQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->loopQueue->offer($element));

		foreach ($elements as $element)
		{
			$index = $this->loopQueue->search($element);
			$this->assertEquals($elements[$index], $element);
		}
	}

	/**
	 * Tests LoopQueue->toArray()
	 */
	public function testToArray()
	{
		$this->loopQueue->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->loopQueue->offer($element));

		$this->assertEquals($elements, $this->loopQueue->toArray());
	}

	/**
	 *
	 * @return array
	 */
	private function newRandomElements(): array
	{
		$array = [];

		for ($i = 0; $i < self::LOOP_QUEUE_LENGTH; $i++)
			$array[] = rand(0, 255);

		return $array;
	}
}

