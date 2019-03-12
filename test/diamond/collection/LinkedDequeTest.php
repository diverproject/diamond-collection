<?php

namespace test\diamond\collection;

/**
 * LinkedDeque test case.
 */
use PHPUnit\Framework\TestCase;
use diamond\collection\LinkedDeque;

/**
 * @see TestCase
 * @see LinkedDeque
 * @author Andrew
 */
class LinkedDequeTest extends TestCase
{
	/**
	 * @var int
	 */
	public const LINKED_DEQUE_LENGTH = 10;

	/**
	 *
	 * @var LinkedDeque
	 */
	private $linkedDeque;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->linkedDeque = new LinkedDeque();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		// TODO Auto-generated LinkedDequeTest::tearDown()
		$this->linkedDeque = null;
		parent::tearDown();
	}

	/**
	 * Tests LinkedDeque->clear()
	 */
	public function testClear()
	{
		$this->linkedDeque->clear();
		$this->assertEquals(0, $this->linkedDeque->size());
	}

	/**
	 * Tests LinkedDeque->size() as
	 * Tests LinkedDeque->count()
	 */
	public function testSize()
	{
		$this->linkedDeque->clear();
		$elements = $this->newRandomElements();

		foreach ($elements as $index => $element)
		{
			$this->assertTrue($this->linkedDeque->add($element));
			$this->assertEquals($index + 1, $this->linkedDeque->size());
			$this->assertEquals($index + 1, $this->linkedDeque->count());
		}
	}

	/**
	 * Tests LinkedDeque->isEmpty()
	 */
	public function testIsEmpty()
	{
		$this->linkedDeque->clear();
		$this->assertTrue($this->linkedDeque->isEmpty());

		$this->assertTrue($this->linkedDeque->add(rand(0, 255)));
		$this->assertFalse($this->linkedDeque->isEmpty());
	}

	/**
	 * Tests LinkedDeque->contains()
	 */
	public function testContains()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->add($element));

		$this->assertEquals($elements, $this->linkedDeque->toArray());
		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->linkedDeque->contains($element));
	}

	/**
	 * Tests LinkedDeque->containsAll()
	 */
	public function testContainsAll()
	{
		$this->linkedDeque->clear();
		$collection = new LinkedDeque();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($this->linkedDeque->add($element));
			$this->assertTrue($collection->add($element));
		}

		$this->assertTrue($this->linkedDeque->containsAll($collection));
		$this->assertEquals($collection->toArray(), $this->linkedDeque->toArray());
	}

	/**
	 * Tests LinkedDeque->add()
	 */
	public function testAdd()
	{
		$this->linkedDeque->clear();

		foreach ($this->newRandomElements() as $element)
			$this->assertTrue($this->linkedDeque->add($element));

		$this->assertEquals(self::LINKED_DEQUE_LENGTH, $this->linkedDeque->size());
		$this->assertEquals(self::LINKED_DEQUE_LENGTH, $this->linkedDeque->count());
	}

	/**
	 * Tests LinkedDeque->addFirst()
	 */
	public function testAddFirst()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->addFirst($element));

		$elements = array_reverse($elements);
		$this->assertEquals($elements, $this->linkedDeque->toArray());
		$this->assertEquals(self::LINKED_DEQUE_LENGTH, $this->linkedDeque->size());
		$this->assertEquals(self::LINKED_DEQUE_LENGTH, $this->linkedDeque->count());
	}

	/**
	 * Tests LinkedDeque->addLast()
	 */
	public function testAddLast()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->addLast($element));

		$this->assertEquals($elements, $this->linkedDeque->toArray());
		$this->assertEquals(self::LINKED_DEQUE_LENGTH, $this->linkedDeque->size());
		$this->assertEquals(self::LINKED_DEQUE_LENGTH, $this->linkedDeque->count());
	}

	/**
	 * Tests LinkedDeque->offer()
	 */
	public function testOffer()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->offer($element));

		$this->assertEquals($elements, $this->linkedDeque->toArray());
		$this->assertEquals(self::LINKED_DEQUE_LENGTH, $this->linkedDeque->size());
		$this->assertEquals(self::LINKED_DEQUE_LENGTH, $this->linkedDeque->count());
	}

	/**
	 * Tests LinkedDeque->offerFirst()
	 */
	public function testOfferFirst()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->offerFirst($element));

		$elements = array_reverse($elements);
		$this->assertEquals($elements, $this->linkedDeque->toArray());
		$this->assertEquals(self::LINKED_DEQUE_LENGTH, $this->linkedDeque->size());
		$this->assertEquals(self::LINKED_DEQUE_LENGTH, $this->linkedDeque->count());
	}

	/**
	 * Tests LinkedDeque->offerLast()
	 */
	public function testOfferLast()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->offerLast($element));

		$this->assertEquals($elements, $this->linkedDeque->toArray());
		$this->assertEquals(self::LINKED_DEQUE_LENGTH, $this->linkedDeque->size());
		$this->assertEquals(self::LINKED_DEQUE_LENGTH, $this->linkedDeque->count());
	}

	/**
	 * Tests LinkedDeque->addAll()
	 */
	public function testAddAll()
	{
		$this->linkedDeque->clear();
		$collection = new LinkedDeque();

		foreach ($this->newRandomElements() as $element)
			$collection->add($element);

		$this->assertTrue($this->linkedDeque->addAll($collection));
		$this->assertEquals($this->linkedDeque->toArray(), $collection->toArray());
	}

	/**
	 * Tests LinkedDeque->remove()
	 */
	public function testRemove()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->add($element));

		shuffle($elements);

		foreach ($elements as $element)
			$this->assertTrue($this->linkedDeque->remove($element));

		$this->assertTrue($this->linkedDeque->isEmpty());
	}

	/**
	 * Tests LinkedDeque->removeFirst()
	 */
	public function testRemoveFirst()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->add($element));

		while (!$this->linkedDeque->isEmpty())
			$this->assertEquals(array_shift($elements), $this->linkedDeque->removeFirst($element));
	}

	/**
	 * Tests LinkedDeque->removeLast()
	 */
	public function testRemoveLast()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->add($element));

		while (!$this->linkedDeque->isEmpty())
			$this->assertEquals(array_pop($elements), $this->linkedDeque->removeLast($element));
	}

	/**
	 * Tests LinkedDeque->poll()
	 */
	public function testPoll()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->add($element));

		while (!$this->linkedDeque->isEmpty())
			$this->assertEquals(array_shift($elements), $this->linkedDeque->poll());
	}

	/**
	 * Tests LinkedDeque->pollFirst()
	 */
	public function testPollFirst()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->add($element));

		while (!$this->linkedDeque->isEmpty())
			$this->assertEquals(array_shift($elements), $this->linkedDeque->pollFirst());
	}

	/**
	 * Tests LinkedDeque->pollLast()
	 */
	public function testPollLast()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->add($element));

		while (!$this->linkedDeque->isEmpty())
			$this->assertEquals(array_pop($elements), $this->linkedDeque->pollLast());
	}

	/**
	 * Tests LinkedDeque->removeAll()
	 */
	public function testRemoveAll()
	{
		$this->linkedDeque->clear();
		$collection = new LinkedDeque();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($collection->add($element));
			$this->assertTrue($this->linkedDeque->add($element));
		}

		$this->assertTrue($this->linkedDeque->removeAll($collection));
		$this->assertTrue($this->linkedDeque->isEmpty());
	}

	/**
	 * Tests LinkedDeque->retainAll()
	 */
	public function testRetainAll()
	{
		$this->linkedDeque->clear();
		$collection = new LinkedDeque();

		foreach ($this->newRandomElements() as $element)
		{
			$this->assertTrue($collection->add($element));
			$this->assertTrue($this->linkedDeque->add($element));
		}

		$this->assertTrue(!$this->linkedDeque->retainAll($collection));
		$this->assertTrue($this->linkedDeque->isEmpty());
	}

	/**
	 * Tests LinkedDeque->getFirst()
	 */
	public function testGetFirst()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->offer($element));

		$this->assertEquals($elements, $this->linkedDeque->toArray());

		while (!$this->linkedDeque->isEmpty())
		{
			$this->assertEquals(array_shift($elements), $this->linkedDeque->getFirst());
			$this->linkedDeque->pollFirst();
		}
	}

	/**
	 * Tests LinkedDeque->getLast()
	 */
	public function testGetLast()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->offer($element));

		$this->assertEquals($elements, $this->linkedDeque->toArray());

		while (!$this->linkedDeque->isEmpty())
		{
			$this->assertEquals(array_pop($elements), $this->linkedDeque->getLast());
			$this->linkedDeque->pollLast();
		}
	}

	/**
	 * Tests LinkedDeque->peek()
	 */
	public function testPeek()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->offer($element));

		$this->assertEquals($elements, $this->linkedDeque->toArray());

		while (!$this->linkedDeque->isEmpty())
		{
			$this->assertEquals(array_shift($elements), $this->linkedDeque->peek());
			$this->linkedDeque->pollFirst();
		}
	}

	/**
	 * Tests LinkedDeque->peekFirst()
	 */
	public function testPeekFirst()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->offer($element));

		$this->assertEquals($elements, $this->linkedDeque->toArray());

		while (!$this->linkedDeque->isEmpty())
		{
			$this->assertEquals(array_shift($elements), $this->linkedDeque->peekFirst());
			$this->linkedDeque->pollFirst();
		}
	}

	/**
	 * Tests LinkedDeque->peekLast()
	 */
	public function testPeekLast()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->offer($element));

		$this->assertEquals($elements, $this->linkedDeque->toArray());

		while (!$this->linkedDeque->isEmpty())
		{
			$this->assertEquals(array_pop($elements), $this->linkedDeque->peekLast());
			$this->linkedDeque->pollLast();
		}
	}

	/**
	 * Tests LinkedDeque->removeFirstOccurence()
	 */
	public function testRemoveFirstOccurrence()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->offer($element));

		$this->assertEquals($elements, $this->linkedDeque->toArray());

		foreach ($elements as $element)
			$this->assertTrue($this->linkedDeque->removeFirstOccurrence($element));

		$this->assertTrue($this->linkedDeque->isEmpty());
	}

	/**
	 * Tests LinkedDeque->removeLastOccurence()
	 */
	public function testRemoveLastOccurrence()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->offer($element));

		$this->assertEquals($elements, $this->linkedDeque->toArray());

		foreach ($elements as $element)
			$this->assertTrue($this->linkedDeque->removeLastoccurrence($element));

		$this->assertTrue($this->linkedDeque->isEmpty());
	}

	/**
	 * Tests LinkedDeque->search()
	 */
	public function testSearch()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->offer($element));

		foreach ($elements as $element)
		{
			$index = $this->linkedDeque->search($element);
			$this->assertEquals($elements[$index], $element);
		}
	}

	/**
	 * Tests LinkedDeque->toArray()
	 */
	public function testToArray()
	{
		$this->linkedDeque->clear();

		foreach (($elements = $this->newRandomElements()) as $element)
			$this->assertTrue($this->linkedDeque->offer($element));

		$this->assertEquals($elements, $this->linkedDeque->toArray());
	}

	/**
	 *
	 * @return array
	 */
	private function newRandomElements(): array
	{
		$array = [];

		for ($i = 0; $i < self::LINKED_DEQUE_LENGTH; $i++)
			$array[] = rand(0, 255);

		return $array;
	}
}

