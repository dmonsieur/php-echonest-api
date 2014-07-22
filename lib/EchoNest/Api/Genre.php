<?php

/**
 * Api calls for getting data about artists.
 *
 * @link      http://developer.echonest.com/docs/v4/genre.html
 * @author    Denis Monsieur <dmonsieur at gmail dot com>
 * @license   MIT License
 */
class EchoNest_Api_Genre extends EchoNest_Api
{
    /**
     * Set the genre name.  The genre name is required for some of the methods in this API
     *
     * @param   string  $name         the genre name
     * @return  EchoNest_Api_Genre     the current object instance
     */
    public function setName($name)
    {
        return $this->setOption('name', $name);
    }

    /**
     * Return the top artists for the given genre.
     * http://developer.echonest.com/docs/v4/genre.html#artists
     *
     * @return  array                 list of artists found
     */
    public function getArtists()
    {
        $response = $this->getForGenre('genre/artists');

        return $this->returnResponse($response, 'artists');
    }

    /**
     * Get a list of genres.
     * http://developer.echonest.com/docs/v4/genre.html#list
     *
     * @return  array                   list of genres found
     */
    public function getList()
    {
        $response = $this->get('genre/list');

        return $this->returnResponse($response, 'genres');
    }

  /**
   * Get basic information about a genre.
   * http://developer.echonest.com/docs/v4/genre.html#profile
   *
   * @param   string|array $bucket    indicates what data should be returned with each genre. possible values include:
   *  - description               returns a description of the genre
   *  - urls                      returns URL links related to the genre
   * @return  array                   array of information
   */
  public function getProfile($bucket = null)
  {
    $response = $this->getForGenre('genre/profile', array(
      'bucket'         => $bucket,
    ));

    return $this->returnResponse($response, 'genres');
  }

  /**
   * Search genres.
   * http://developer.echonest.com/docs/v4/genre.html#search
   * @param   array   $options          visit the documentation above to see all available options.  Some options include:
   * -  $bucket           description, urls
   * -  $limit            if true, limit the results to the given idspace or catalog
   * -  $name             the name of the artist to search for
   * @return  array                     array of search results
   */
  public function search($options = array())
  {
    $response = $this->get('genre/search', $options);

    return $this->returnResponse($response, 'genres');
  }

  /**
   * Return similar genres to a given genre.
   * http://developer.echonest.com/docs/v4/genre.html#similar
   *
   * @param   integer $results            the number of results desired (0 < $results < 100)
   * @param   integer $start              the desired index of the first result returned
   * @param   string|array $bucket        indicates what data should be returned with each genre
   * @return  array                       array of similar artists found
   * @see     getProfile
   */
  public function getSimilar($results = 15, $start = 0, $bucket = null)
  {
    $response = $this->getForGenre('genre/similar', array(
      'results' => $results,
      'start' => $start,
      'bucket' => $bucket,
    ));

    return $this->returnResponse($response, 'genres');
  }

  /**
   * Send a GET request for a genre.
   * This is for when a name attribute is required
   */
  protected function getForGenre($path, array $parameters = array(), array $options = array())
  {
    if (!isset($parameters['name'])) {
      if ($name = $this->getOption('name')) {
        $parameters = array_merge(array('name' => $name), $parameters);
      }
      else {
        throw new Exception('This method requires a genre name.  Please set this using the setName() method on the Genre API');
      }
    }

    return $this->get($path, $parameters, $options);
  }
}
