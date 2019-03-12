<?php

namespace test\diamond\collection;

use PHPUnit\Framework\TestSuite;

/**
 * Static test suite.
 */
class CollectionSuite extends TestSuite
{
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct()
	{
		$this->setName('CollectionSuite');
		$this->addTest(ArrayDequeTest::class);
		$this->addTest(ArrayListDynamicTest::class);
		$this->addTest(ArrayListStaticTest::class);
		$this->addTest(HashTableTest::class);
		$this->addTest(LinkedDequeTest::class);
		$this->addTest(LinkedListTest::class);
		$this->addTest(LinkedQueueTest::class);
		$this->addTest(LinkedStackTest::class);
		$this->addTest(LoopQueueTest::class);
		$this->addTest(PriorityQueueTest::class);
	}

	/**
	 * Creates the suite.
	 */
	public static function suite()
	{
		return new self();
	}
}

