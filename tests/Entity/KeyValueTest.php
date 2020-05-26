<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class KeyValueTest extends TestCase
{
    public function testCreateOneKeyValue(): void
    {
        $value = new Entity\KeyValue();
        
        $this->assertInstanceOf(
            Entity\KeyValue::class,
            $value
        );
    }

    public function testeGetInexistentKey(): void
    {
        $value = new Entity\KeyValue();
        
        $return = $value->get('PHPUnitKeyUnexist');
        $this->assertEquals("(nil)", $return);
    }

    public function testeCreateNewKeyValue(): void
    {
        $value = new Entity\KeyValue();
        $return = $value->set('PHPUnitKey',"testePHPUnit");

        $this->assertTrue($return);

        $return = $value->get('PHPUnitKey');
        $this->assertEquals("testePHPUnit", $return);
    }

    public function testeUpdateKeyValue(): void
    {
        $value = new Entity\KeyValue();
        $return = $value->set('PHPUnitKey',"value42");

        $this->assertTrue($return);

        $return = $value->get('PHPUnitKey');
        $this->assertEquals("value42", $return);
    }

    public function testeCreateNewKeyValueWithExpire(): void
    {
        $value = new Entity\KeyValue();
        $return = $value->set('PHPUnitExpire',"new-value",'EX',2);

        $this->assertTrue($return);
        sleep(8);
        $return = $value->get('PHPUnitExpire');
        $this->assertEquals("(nil)", $return);
    }

    public function testeDeleteKeyValue(): void
    {
        $value = new Entity\KeyValue();
        $return = $value->set('PHPUnitExpire',"value to dell",'EX', 100);

        $this->assertTrue($return);
        
        $return = $value->get('PHPUnitExpire');
        $this->assertEquals("value to dell", $return);

        $return = $value->del('PHPUnitExpire');
        $this->assertEquals("(integer) 1", $return);
        
        $return = $value->get('PHPUnitExpire');
        $this->assertEquals("(nil)", $return);

        $return = $value->del('PHPUnitKey');
        $this->assertEquals("(integer) 1", $return);

        $return = $value->del('PHPUnitKeyInexist');
        $this->assertEquals("(integer) 0", $return);
    }
    
}