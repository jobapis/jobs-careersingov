<?php namespace JobApis\Jobs\Client\Providers\Test;

use JobApis\Jobs\Client\Collection;
use JobApis\Jobs\Client\Job;
use JobApis\Jobs\Client\Providers\CareersInGovProvider;
use JobApis\Jobs\Client\Queries\CareersInGovQuery;
use Mockery as m;

class CareersInGovProviderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->query = m::mock(CareersInGovQuery::class);

        $this->client = new CareersInGovProvider($this->query);
    }

    public function testItCanGetDefaultResponseFields()
    {
        $fields = [
            'description',
            'link',
            'pubDate',
            'title',
        ];
        $this->assertEquals($fields, $this->client->getDefaultResponseFields());
    }

    public function testItCanGetListingsPath()
    {
        $this->assertEquals('channel.item', $this->client->getListingsPath());
    }

    public function testItCanGetFormat()
    {
        $this->assertEquals('xml', $this->client->getFormat());
    }

    public function testItCanCreateJobObject()
    {
        $payload = $this->createJobArray();

        $results = $this->client->createJobObject($payload);

        $this->assertInstanceOf(Job::class, $results);
        $this->assertEquals($payload['title'], $results->getTitle());
        $this->assertEquals($payload['title'], $results->getName());
        $this->assertEquals($payload['description'], $results->getDescription());
        $this->assertEquals($payload['link'], $results->getUrl());
    }

    /**
     * Integration test for the client's getJobs() method.
     */
    public function testItCanGetJobs()
    {
        $guzzle = m::mock('GuzzleHttp\Client');

        $query = new CareersInGovQuery;

        $client = new CareersInGovProvider($query);

        $client->setClient($guzzle);

        $response = m::mock('GuzzleHttp\Message\Response');

        $jobs = $this->createXmlResponse();

        $guzzle->shouldReceive('get')
            ->with($query->getUrl(), $query->getHttpMethodOptions())
            ->once()
            ->andReturn($response);
        $response->shouldReceive('getBody')
            ->once()
            ->andReturn($jobs);

        $results = $client->getJobs();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertCount(2, $results);
    }

    /**
     * Integration test with actual API call to the provider.
     */
    public function testItCanGetJobsFromApi()
    {
        if (!getenv('REAL_CALL')) {
            $this->markTestSkipped('REAL_CALL not set. Real API call will not be made.');
        }

        $client = new CareersInGovProvider(new CareersInGovQuery);

        $results = $client->getJobs();

        $this->assertInstanceOf('JobApis\Jobs\Client\Collection', $results);
    }

    private function createJobArray()
    {
        return [
            'title' => uniqid(),
            'link' => uniqid(),
            'description' => uniqid(),
            'pubDate' => 'Fri, '.rand(1,30).' Nov '.rand(2015, 2016).' 18:36:18 Z',
        ];
    }

    private function createXmlResponse()
    {
        return "<?xml version=\"1.0\"?><rss version=\"2.0\"><channel><title>Rss</title><link><![CDATA[https://careersingovernment.com]]></link><description><![CDATA[test description]]></description><language>en-us</language><pubDate>Fri, 27 Jan 2017 07:01:20 GMT</pubDate><lastBuildDate>Fri, 27 Jan 2017 07:01:20 GMT</lastBuildDate><docs><![CDATA[https://careersingovernment.com/rss/]]></docs><generator></generator><managingEditor>editor@example.com</managingEditor><webMaster>webmaster@example.com</webMaster><item><title><![CDATA[Office Assistant III - Bilingual]]></title><link><![CDATA[https://careersingovernment.com/display-job/111753/Office-Assistant-III---Bilingual.html]]></link><description><![CDATA[Riverside, California County of Riverside, California<br/>The mission of the Economic Development Agency (EDA) is to enhance the economic position of Riverside County and its residents, maintain the environment, improve the quality of life, encourage business growth, build a positive business climate, develop a trained workforce, improve existing communities, offer a variety of housing opportunities, and provide cultural and entertainment activities.<br /><br /><strong>JOB DESCRIPTION</strong><br />The County Service Areas Administration Division of the EDA (located in Riverside) is looking for a bilingual Office Assistant III to perform complex clerical duties such as: database management, tax roll collection, budget preparation assistance and customer service for taxpayer inquiries.<br /><br /><strong>ESSENTIAL DUTIES</strong><br />&bull; &nbsp;Perform complex clerical work requiring the application of laws, policies, procedures, and specialized terminology; prepare and process materials which require the review of complex source material and a thorough familiarity with policies, procedures, terminology and various applicable laws in order to obtain the necessary data.<br />&bull; &nbsp;Give information to the public or interdepartmental representatives in situations where judgment and interpretation of departmental policies and regulations are required.<br />&bull; &nbsp;Review a variety of reports, forms, and records for accuracy, completeness, and compliance with applicable ordinances; answer questions involving searching for and summarizing technical data, laws, policies, or procedures.<br />&bull; &nbsp;Compile a variety of narrative and statistical reports, which requires locating sources of information, devising forms to secure the data, and determining proper format for finished reports.<br />&bull; &nbsp;May provide technical guidance and/or training to clerical staff; may assign and review the work of clerical staff; prepare and revise written procedures.<br />&bull; &nbsp;Type a wide variety of complex material such as difficult statistical and budgetary tabulations, highly confidential reports and letters, priority manuscripts or contracts, and other specialized documents from rough, plain, corrected copy, or dictated material utilizing information processing equipment.<br />&bull; &nbsp;Develop automated files and maintain the storage of tapes and disks; develop and revise standardized formats for documents for the department; operate peripheral equipment.<br />&bull; &nbsp;Isolate and resolve equipment and procedural problems; perform backup of systems and maintain archived record library and reference logs; serve as technical expert on the operation of information processing equipment.<br /><br />*Review the full job posting (Job ID 5616) in Job Gateway for more information.*<br /><br /><strong>***Applications must be submitted through Job Gateway***</strong><br /><br />http://www.rc-hr.com/Careers/HowtoApply.aspx<br /><br />The preliminary closing date for this posting is February 2, 2017 at 11:59 pm PST, however, postings may close at any time.<br /><br /><strong>Please, visit our Frequently Asked Questions page if you have any questions or concerns regarding the recruitment process:</strong> http://www.rc-hr.com/Careers/HowtoApply/HelpFAQs.aspx<br /><br />Please, include relevant work experience details on resume or application. Applicants who fail to provide information demonstrating they possess the position requirements listed under RECRUITING GUIDELINES will not be considered further in the application process.<br /><br />If you have questions regarding this posting, please contact Amanda Pettey at arpettey@rivco.org or at 951-955-3510.]]></description><pubDate>Fri, 27 Jan 2017 04:33:45 GMT</pubDate><guid><![CDATA[https://careersingovernment.com/display-job/111753/Office-Assistant-III---Bilingual.html]]></guid></item><item><title><![CDATA[SEASONAL FIREFIGHTER 1]]></title><link><![CDATA[https://careersingovernment.com/display-job/111752/SEASONAL-FIREFIGHTER-1.html]]></link><description><![CDATA[, Nevada STATE OF NEVADA<br/>Announcement Number: 30597 <br><br><div>Seasonal Firefighters assist in wildland and structural fire suppression, fire prevention and education, medical and hazardous materials emergencies, presuppression, equipment and facility maintenance, and forestry and fire law enforcement activities. </div> <div>Incumbents are required to pass a work capacity test which consists of a three (3) mile walk, carrying forty-five (45) pounds in less than forty-five minutes. Seasonal Firefighter positions are located in Carson City, Elko, Las Vegas and Winnemucca. When applying for this recruitment you will be asked to answer a \"Pre-Screening\" question that indicates your willingness to accept employment for any or all of these areas above. Also, on the \"Availability Tab\" of your application for this recruitment, you must indicate the geographical area you are willing to accept employment. You must choose either \"Carson, Minden, Gardnerville, Genoa\"; \"Elko\"; \"Las Vegas, Boulder City, Indian Springs, Jean, Henderson\"; Winnemucca\" or all of the above. Only applicants willing to accept employment in one or more of these geographical locations will be considered for this recruitment. </div>]]></description><pubDate>Fri, 27 Jan 2017 03:04:32 GMT</pubDate><guid><![CDATA[https://careersingovernment.com/display-job/111752/SEASONAL-FIREFIGHTER-1.html]]></guid></item></channel></rss>";
    }
}
