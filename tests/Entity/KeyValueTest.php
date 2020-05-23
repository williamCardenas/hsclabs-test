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

    
}