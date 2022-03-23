<?php

namespace App\Tests;

use App\Entity\Formation;
use PHPUnit\Framework\TestCase;

class FormationTest extends TestCase
{
    public function testGetDatecreationString()
    {
        $formation = new Formation;
        $formation->setPublishedAt(new \DateTime("2021-06-26"));
        $this->assertEquals("26/06/2021", $formation->getPublishedAtString());
    }
}
