<?php namespace JobApis\Jobs\Client\Providers;

use JobApis\Jobs\Client\Exceptions\MissingParameterException;
use JobApis\Jobs\Client\Job;

class CareersInGovProvider extends AbstractProvider
{
    /**
     * Returns the standardized job object
     *
     * @param array $payload
     *
     * @return \JobApis\Jobs\Client\Job
     */
    public function createJobObject($payload)
    {
        $job = new Job([
            'description' => trim($payload['description']),
            'name' => $payload['title'],
            'title' => $payload['title'],
            'url' => $payload['link'],
        ]);

        // Set date posted
        $job->setDatePostedAsString($payload['pubDate']);

        return $job;
    }

    /**
     * Job response object default keys that should be set
     *
     * @return  array
     */
    public function getDefaultResponseFields()
    {
        return [
            'description',
            'link',
            'pubDate',
            'title',
        ];
    }

    /**
     * Get format
     *
     * @return  string Currently only 'json' and 'xml' supported
     */
    public function getFormat()
    {
        return 'xml';
    }

    /**
     * Makes the api call and returns a collection of job objects
     * NOTE: This method overwrites the AbstractProvider in order to trim whitespace from the body
     *
     * @return  \JobApis\Jobs\Client\Collection
     * @throws MissingParameterException
     */
    public function getJobs()
    {
        // Verify that all required query vars are set
        if ($this->query->isValid()) {
            // Get the response from the client using the query
            $response = $this->getClientResponse();
            // Get the response body as a string
            $body = trim((string) $response->getBody());
            // Parse the string
            $payload = $this->parseAsFormat($body, $this->getFormat());
            // Gets listings if they're nested
            $listings = is_array($payload) ? $this->getRawListings($payload) : [];
            // Return a job collection
            return $this->getJobsCollectionFromListings($listings);
        } else {
            throw new MissingParameterException("All Required parameters for this provider must be set");
        }
    }

    /**
     * Get listings path
     *
     * @return  string
     */
    public function getListingsPath()
    {
        return 'channel.item';
    }
}
