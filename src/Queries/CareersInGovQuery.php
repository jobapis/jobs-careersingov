<?php namespace JobApis\Jobs\Client\Queries;

class CareersInGovQuery extends AbstractQuery
{
    /**
     * Careers in Government provides no search parameters, just
     * a feed of all their latest jobs via RSS.
     */

    /**
     * Get baseUrl
     *
     * @return  string Value of the base url to this api
     */
    public function getBaseUrl()
    {
        return 'https://www.careersingovernment.com/rss';
    }

    /**
     * Get keyword
     *
     * @return  string Attribute being used as the search keyword
     */
    public function getKeyword()
    {
        return null;
    }
}
