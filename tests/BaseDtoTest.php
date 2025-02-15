<?php

use PHPUnit\Framework\TestCase;
use SimpleDto\BaseDto;

class BaseDtoTest extends TestCase
{

    public function testBaseDto()
    {

        $data = [
            "name" => "John Doe",
            "email" => "john@doe.com",
            "age" => 20,
            "skills" => [
                "Communication",
                "Time Management",
                "Problem-Solving",
                "Teamwork and Collaboration",
                "Adaptability"
            ]
        ];

        $class = new class ($data) extends BaseDto {
            public string $name;
            public string $email;
            public int $age;
            public array $skills;
        };

        $this->assertEquals("John Doe", $class->name);
        $this->assertEquals("john@doe.com", $class->email);
        $this->assertEquals(20, $class->age);
        $this->assertIsArray($class->skills);
    }

}