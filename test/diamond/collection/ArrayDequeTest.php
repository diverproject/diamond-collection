<?php

namespace test\diamond\collection;

/**
 * ArrayDeque test case.
 */
use PHPUnit\Framework\TestCase;
use diamond\collection\ArrayDeque;

/**
 * @see TestCase
 * @see ArrayDeque
 * @author Andrew
 */
class ArrayDequeTest extends TestCase
{
	/**
	 * @var int
	 */
	public const ARRAY_DEQUE_LENGTH = 10;

	/**
	 *
	 * @var ArrayDeque
	 */
	private $arrayDeque;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->arrayDeque = new ArrayDeque(self::ARRAY_DEQUE_LENGTH);
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		// TODO Auto-generated ArrayDequeTest::tearDown()
		$this->arrayDeque = null;
		parent::tearDown();
	}

	/**
	 * Tests ArrayDeque->clear()
	 */
	public function testClear()
	{
		$this->arrayDeque->clear();
		$this->assertEquals(0, $this->arrayDeque->size());
	}

	/**
	 * Tests ArrayDeque->size() as
	 * Tests ArrayDeque->count()
	 */
	public function testSize()
	{
		$this->arrayDeque->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $index => $element)
		{
			$this->assertTrue($this->arrayDeque->add($element));
			$this->assertEquals($index + 1, $this->arrayDeque->size());
			$this->assertEquals($index + 1, $this->arrayDeque->count());
		}
	}

	/**
	 * Tests ArrayDeque->isEmpty()
	 */
	public function testIsEmpty()
	{
		$this->arrayDeque->clear();
		$this->assertTrue($this->arrayDeque->isEmpty());

		$this->assertTrue($this->arrayDeque->add(rand(0, 255)));
		$this->assertFalse($this->arrayDeque->isEmpty());
	}

	/**
	 * Tests ArrayDeque->contains()
	 */
	public function testContains()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->add($element));

		$this->assertEquals($elements, $this->arrayDeque->toArray());
		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->arrayDeque->contains($element));
	}

	/**
	 * Tests ArrayDeque->containsAll()
	 */
	public function testContainsAll()
	{
		$this->arrayDeque->clear();
		$collection = new ArrayDeque(self::ARRAY_DEQUE_LENGTH);

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->arrayDeque->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->arrayDeque->containsAll($collection));
		$this->assertEquals($collection->toArray(), $this->arrayDeque->toArray());
	}

	/**
	 * Tests ArrayDeque->add()
	 */
	public function testAdd()
	{
		$this->arrayDeque->clear();

		foreach ($this->newRandomElements() as $element)
			$this->assertTrue($this->arrayDeque->add($element));

		$this->assertEquals(self::ARRAY_DEQUE_LENGTH, $this->arrayDeque->size());
		$this->assertEquals(self::ARRAY_DEQUE_LENGTH, $this->arrayDeque->count());
	}

	/**
	 * Tests ArrayDeque->addFirst()
	 */
	public function testAddFirst()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->addFirst($element));

		$elements = array_reverse($elements);
		$this->assertEquals($elements, $this->arrayDeque->toArray());
		$this->assertEquals(self::ARRAY_DEQUE_LENGTH, $this->arrayDeque->size());
		$this->assertEquals(self::ARRAY_DEQUE_LENGTH, $this->arrayDeque->count());
	}

	/**
	 * Tests ArrayDeque->addLast()
	 */
	public function testAddLast()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->addLast($element));

		$this->assertEquals($elements, $this->arrayDeque->toArray());
		$this->assertEquals(self::ARRAY_DEQUE_LENGTH, $this->arrayDeque->size());
		$this->assertEquals(self::ARRAY_DEQUE_LENGTH, $this->arrayDeque->count());
	}

	/**
	 * Tests ArrayDeque->offer()
	 */
	public function testOffer()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->offer($element));

		$this->assertEquals($elements, $this->arrayDeque->toArray());
		$this->assertEquals(self::ARRAY_DEQUE_LENGTH, $this->arrayDeque->size());
		$this->assertEquals(self::ARRAY_DEQUE_LENGTH, $this->arrayDeque->count());
	}

	/**
	 * Tests ArrayDeque->offerFirst()
	 */
	public function testOfferFirst()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->offerFirst($element));

		$elements = array_reverse($elements);
		$this->assertEquals($elements, $this->arrayDeque->toArray());
		$this->assertEquals(self::ARRAY_DEQUE_LENGTH, $this->arrayDeque->size());
		$this->assertEquals(self::ARRAY_DEQUE_LENGTH, $this->arrayDeque->count());
	}

	/**
	 * Tests ArrayDeque->offerLast()
	 */
	public function testOfferLast()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->offerLast($element));

		$this->assertEquals($elements, $this->arrayDeque->toArray());
		$this->assertEquals(self::ARRAY_DEQUE_LENGTH, $this->arrayDeque->size());
		$this->assertEquals(self::ARRAY_DEQUE_LENGTH, $this->arrayDeque->count());
	}

	/**
	 * Tests ArrayDeque->addAll()
	 */
	public function testAddAll()
	{
		$this->arrayDeque->clear();
		$collection = new ArrayDeque(self::ARRAY_DEQUE_LENGTH);

		foreach ($this->newRandomElements() as $element)
			$collection->add($element);

		$this->assertTrue($this->arrayDeque->addAll($collection));
		$this->assertEquals($this->arrayDeque->toArray(), $collection->toArray());
	}

	/**
	 * Tests ArrayDeque->remove()
	 */
	public function testRemove()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->add($element));

		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->arrayDeque->remove($element));

		$this->assertTrue($this->arrayDeque->isEmpty());
	}

	/**
	 * Tests ArrayDeque->removeFirst()
	 */
	public function testRemoveFirst()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->add($element));

		while (!$this->arrayDeque->isEmpty())
			$this->assertEquals(array_shift($elements), $this->arrayDeque->removeFirst($element));
	}

	/**
	 * Tests ArrayDeque->removeLast()
	 */
	public function testRemoveLast()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->add($element));

		while (!$this->arrayDeque->isEmpty())
			$this->assertEquals(array_pop($elements), $this->arrayDeque->removeLast($element));
	}

	/**
	 * Tests ArrayDeque->poll()
	 */
	public function testPoll()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->add($element));

		while (!$this->arrayDeque->isEmpty())
			$this->assertEquals(array_shift($elements), $this->arrayDeque->poll());
	}

	/**
	 * Tests ArrayDeque->pollFirst()
	 */
	public function testPollFirst()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->add($element));

		while (!$this->arrayDeque->isEmpty())
			$this->assertEquals(array_shift($elements), $this->arrayDeque->pollFirst());
	}

	/**
	 * Tests ArrayDeque->pollLast()
	 */
	public function testPollLast()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->add($element));

		while (!$this->arrayDeque->isEmpty())
			$this->assertEquals(array_pop($elements), $this->arrayDeque->pollLast());
	}

	/**
	 * Tests ArrayDeque->removeAll()
	 */
	public function testRemoveAll()
	{
		$this->arrayDeque->clear();
		$collection = new ArrayDeque(self::ARRAY_DEQUE_LENGTH);

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($collection->add($element));
			$this->assertTrue($this->arrayDeque->add($element));
		}

		$this->assertTrue($this->arrayDeque->removeAll($collection));
		$this->assertTrue($this->arrayDeque->isEmpty());
	}

	/**
	 * Tests ArrayDeque->retainAll()
	 */
	public function testRetainAll()
	{
		$this->arrayDeque->clear();
		$collection = new ArrayDeque(self::ARRAY_DEQUE_LENGTH);

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($collection->add($element));
			$this->assertTrue($this->arrayDeque->add($element));
		}

		$this->assertTrue(!$this->arrayDeque->retainAll($collection));
		$this->assertTrue($this->arrayDeque->isEmpty());
	}

	/**
	 * Tests ArrayDeque->getFirst()
	 */
	public function testGetFirst()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->offer($element));

		$this->assertEquals($elements, $this->arrayDeque->toArray());

		while (!$this->arrayDeque->isEmpty())
		{
			$this->assertEquals(array_shift($elements), $this->arrayDeque->getFirst());
			$this->arrayDeque->pollFirst();
		}
	}

	/**
	 * Tests ArrayDeque->getLast()
	 */
	public function testGetLast()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
		{
			$this->assertTrue($this->arrayDeque->offer($element));
			$this->assertEquals($element, $this->arrayDeque->getLast());
		}

		$this->assertEquals($elements, $this->arrayDeque->toArray());

		while (!$this->arrayDeque->isEmpty())
		{
			$this->assertEquals(array_pop($elements), $this->arrayDeque->getLast());
			$this->arrayDeque->pollLast();
		}
	}

	/**
	 * Tests ArrayDeque->peek()
	 */
	public function testPeek()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->offer($element));

		$this->assertEquals($elements, $this->arrayDeque->toArray());

		while (!$this->arrayDeque->isEmpty())
		{
			$this->assertEquals(array_shift($elements), $this->arrayDeque->peek());
			$this->arrayDeque->pollFirst();
		}
	}

	/**
	 * Tests ArrayDeque->peekFirst()
	 */
	public function testPeekFirst()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->offer($element));

		$this->assertEquals($elements, $this->arrayDeque->toArray());

		while (!$this->arrayDeque->isEmpty())
		{
			$this->assertEquals(array_shift($elements), $this->arrayDeque->peekFirst());
			$this->arrayDeque->pollFirst();
		}
	}

	/**
	 * Tests ArrayDeque->peekLast()
	 */
	public function testPeekLast()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->offer($element));

		$this->assertEquals($elements, $this->arrayDeque->toArray());

		while (!$this->arrayDeque->isEmpty())
		{
			$this->assertEquals(array_pop($elements), $this->arrayDeque->peekLast());
			$this->arrayDeque->pollLast();
		}
	}

	/**
	 * Tests ArrayDeque->removeFirstOccurence()
	 */
	public function testRemoveFirstOccurrence()
	{
		$this->arrayDeque->clear();
		$elements = $this->newRandomElements();

		// Test first mode remove first occurrence (elements in middle of array)
		$this->assertTrue($this->arrayDeque->addLast($elements[0]));
		$this->assertTrue($this->arrayDeque->addLast($elements[1]));
		$this->assertTrue($this->arrayDeque->addLast($elements[2]));
		$this->assertTrue($this->arrayDeque->addLast($elements[3]));
		$this->assertTrue($this->arrayDeque->addLast($elements[4]));
		$this->assertTrue($this->arrayDeque->removeFirstOccurrence($elements[0]));
		$this->assertTrue($this->arrayDeque->removeFirstOccurrence($elements[4]));
		$this->assertTrue($this->arrayDeque->removeFirstOccurrence($elements[3]));

		// Test second condition of remove first occurrence (elements in final part of array)
		$this->assertTrue($this->arrayDeque->addFirst($elements[5]));
		$this->assertTrue($this->arrayDeque->addFirst($elements[6]));
		$this->assertTrue($this->arrayDeque->addFirst($elements[7]));
		$this->assertTrue($this->arrayDeque->addFirst($elements[8]));
		$this->assertTrue($this->arrayDeque->addFirst($elements[9]));
		$this->assertTrue($this->arrayDeque->removeFirstOccurrence($elements[5]));
		$this->assertTrue($this->arrayDeque->removeFirstOccurrence($elements[9]));
		$this->assertTrue($this->arrayDeque->removeFirstOccurrence($elements[8]));

		// Test thrid condition of remove first occurrence (elements in initial part of array)
		$this->assertTrue($this->arrayDeque->removeFirstOccurrence($elements[1]));
		$this->assertTrue($this->arrayDeque->removeFirstOccurrence($elements[2]));
		$this->assertTrue($this->arrayDeque->removeFirstOccurrence($elements[6]));
		$this->assertTrue($this->arrayDeque->removeFirstOccurrence($elements[7]));

		$this->assertTrue($this->arrayDeque->isEmpty());
	}

	/**
	 * Tests ArrayDeque->removeLastOccurence()
	 */
	public function testRemoveLastOccurrence()
	{
		$this->arrayDeque->clear();
		$elements = $this->newRandomElements();

		// Test first mode remove last occurrence (elements in middle of array)
		$this->assertTrue($this->arrayDeque->addLast($elements[0]));
		$this->assertTrue($this->arrayDeque->addLast($elements[1]));
		$this->assertTrue($this->arrayDeque->addLast($elements[2]));
		$this->assertTrue($this->arrayDeque->addLast($elements[3]));
		$this->assertTrue($this->arrayDeque->addLast($elements[4]));
		$this->assertTrue($this->arrayDeque->removeLastOccurrence($elements[0]));
		$this->assertTrue($this->arrayDeque->removeLastOccurrence($elements[4]));

		// Test second condition of remove last occurrence (elements in final part of array)
		$this->assertTrue($this->arrayDeque->addFirst($elements[5]));
		$this->assertTrue($this->arrayDeque->addFirst($elements[6]));
		$this->assertTrue($this->arrayDeque->addFirst($elements[7]));
		$this->assertTrue($this->arrayDeque->addFirst($elements[8]));
		$this->assertTrue($this->arrayDeque->addFirst($elements[9]));
		$this->assertTrue($this->arrayDeque->removeLastOccurrence($elements[1]));
		$this->assertTrue($this->arrayDeque->removeLastOccurrence($elements[2]));
		$this->assertTrue($this->arrayDeque->removeLastOccurrence($elements[3]));
		$this->assertTrue($this->arrayDeque->removeLastOccurrence($elements[5]));
		$this->assertTrue($this->arrayDeque->removeLastOccurrence($elements[6]));

		// Test thrid condition of remove last occurrence (elements in initial part of array)
		$this->assertTrue($this->arrayDeque->removeLastOccurrence($elements[7]));
		$this->assertTrue($this->arrayDeque->removeLastOccurrence($elements[8]));
		$this->assertTrue($this->arrayDeque->removeLastOccurrence($elements[9]));

		$this->assertTrue($this->arrayDeque->isEmpty());
	}

	/**
	 * Tests ArrayDeque->search()
	 */
	public function testSearch()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->offer($element));

		foreach ($elements as $element)
		{
			$index = $this->arrayDeque->search($element);
			$this->assertEquals($elements[$index], $element);
		}
	}

	/**
	 * Tests ArrayDeque->toArray()
	 */
	public function testToArray()
	{
		$this->arrayDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->arrayDeque->offer($element));

		$this->assertEquals($elements, $this->arrayDeque->toArray());
	}

	/**
	 *
	 * @return array
	 */
	private function newRandomElements(): array
	{
		$array = [];

		for ($i = 0; $i < self::ARRAY_DEQUE_LENGTH; $i++)
			$array[] = rand(0, 255);

		return $array;
	}
}

