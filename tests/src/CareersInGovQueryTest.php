<?php namespace JobApis\Jobs\Client\Test;

use JobApis\Jobs\Client\Queries\CareersInGovQuery;
use Mockery as m;

class CareersInGovTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->query = new CareersInGovQuery();
    }

    public function testItCanGetBaseUrl()
    {
        $this->assertEquals(
            'https://www.careersingovernment.com/rss',
            $this->query->getBaseUrl()
        );
    }

    public function testItCanGetKeyword()
    {
        $this->assertNull($this->query->getKeyword());
    }
}
