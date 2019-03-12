<?php

namespace test\diamond\collection;

use diamond\collection\HashTable;

/**
 * HashTable test case.
 */
class HashTableTest extends DiamondCollectionTest
{
	/**
	 * @var int
	 */
	public const HASH_TABLE_LENGTH = 100;

	/**
	 *
	 * @var HashTable
	 */
	private $hashTable;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->hashTable = new HashTable();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown()
	{
		$this->hashTable = null;
		parent::tearDown();
	}

	/**
	 * Tests HashTable->clear()
	 */
	public function testClear()
	{
		$this->hashTable->clear();
		$this->assertTrue($this->hashTable->isEmpty());
	}

	/**
	 * Tests HashTable->size()
	 */
	public function testSize()
	{
		$this->hashTable->clear();
		$this->assertEquals(($size = 0), $this->hashTable->size());

		foreach ($this->newElements() as $key => $element)
		{
			$this->assertTrue($this->hashTable->put($key, $element));
			$this->assertEquals(++$size, $this->hashTable->size());
		}
	}

	/**
	 * Tests HashTable->isEmpty()
	 */
	public function testIsEmpty()
	{
		$this->hashTable->clear();
		$this->assertTrue($this->hashTable->isEmpty());
		$this->assertTrue($this->hashTable->put(rand(), rand()));
		$this->assertFalse($this->hashTable->isEmpty());
	}

	/**
	 * Tests HashTable->containsKey()
	 */
	public function testContainsKey()
	{
		$this->hashTable->clear();

		foreach ($this->newElements() as $key => $element)
		{
			$this->assertFalse($this->hashTable->containsKey($key));
			$this->assertTrue($this->hashTable->put($key, $element));
			$this->assertTrue($this->hashTable->containsKey($key));
		}
	}

	/**
	 * Tests HashTable->containsValue()
	 */
	public function testContainsValue()
	{
		$this->hashTable->clear();

		foreach ($this->newElements(false) as $key => $element)
		{
			$this->assertFalse($this->hashTable->containsValue($element));
			$this->assertTrue($this->hashTable->put($key, $element));
			$this->assertTrue($this->hashTable->containsValue($element));
		}
	}

	/**
	 * Tests HashTable->put()
	 */
	public function testPut()
	{
		$this->hashTable->clear();

		foreach (($elements = $this->newElements()) as $key => $element)
			$this->assertTrue($this->hashTable->put($key, $element));

		$this->assertEquals(count($elements), $this->hashTable->size());
	}

	/**
	 * Tests HashTable->putAll()
	 */
	public function testPutAll()
	{
		$this->hashTable->clear();
		$map = new HashTable();

		foreach (($elements = $this->newElements()) as $key => $element)
			$this->assertTrue($map->put($key, $element));

		$this->assertTrue($this->hashTable->putAll($map));
		$this->assertEquals($map->toArray(), $this->hashTable->toArray());
		$this->assertEquals(count($elements), $this->hashTable->size());
	}

	/**
	 * Tests HashTable->remove()
	 */
	public function testRemove()
	{
		$this->hashTable->clear();

		foreach (($elements = $this->newElements()) as $key => $element)
			$this->assertTrue($this->hashTable->put($key, $element));

		uksort($elements, function() { return rand() > rand(); });

		foreach ($elements as $element)
			$this->assertTrue($this->hashTable->remove($element));

		$this->assertTrue($this->hashTable->isEmpty());
	}

	/**
	 * Tests HashTable->removeKey()
	 */
	public function testRemoveKey()
	{
		$this->hashTable->clear();

		foreach (($elements = $this->newElements()) as $key => $element)
			$this->assertTrue($this->hashTable->put($key, $element));

		uksort($elements, function() { return rand() > rand(); });

		foreach ($elements as $key => $element)
			$this->assertTrue($this->hashTable->removeKey($key));

		$this->assertTrue($this->hashTable->isEmpty());
	}

	/**
	 * Tests HashTable->get()
	 */
	public function testGet()
	{
		$this->hashTable->clear();

		foreach ($this->newElements() as $key => $element)
		{
			$this->assertEquals(null, $this->hashTable->get($key));
			$this->assertTrue($this->hashTable->put($key, $element));
			$this->assertEquals($element, $this->hashTable->get($key));
		}
	}

	/**
	 * Tests HashTable->values()
	 */
	public function testValues()
	{
		$this->hashTable->clear();

		foreach (($elements = $this->newElements()) as $key => $element)
			$this->assertTrue($this->hashTable->put($key, $element));

		$elements = array_values($elements);
		$this->assertEquals($elements, $this->hashTable->values());
	}

	/**
	 *
	 * @return array
	 */
	private function newElements($repeatValues = true): array
	{
		$elements = [];

		for ($i = 0; $i < self::HASH_TABLE_LENGTH; $i++)
		{
			do { $key = md5(rand()); } while (isset($elements[$key]));
			do { $value = rand(0, 255); } while (!$repeatValues && in_array($value, $elements));

			$elements[$key] = $value;
		}

		return $elements;
	}
}

