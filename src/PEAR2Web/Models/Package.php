<?php

namespace PEAR2Web\Models;

class Package extends \PEAR2\SimpleChannelFrontend\Package
{
    const GIT_HUB_API = 'http://github.com/api/v2/json/issues/list/pear2/';

    protected $cache = null;

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->cache = new \PEAR2\Cache\Lite\Main();
        $this->cache->setLifeTime(15 * 60);
    }

    public function getGitHubNewIssueLink()
    {
        return 'https://github.com/pear2/' . $this->name . '/issues/new';
    }

    public function getGitHubOpenIssuesLink()
    {
        return 'https://github.com/pear2/' . $this->name . '/issues';
    }

    public function getGitHubClosedIssuesLink()
    {
        return 'https://github.com/pear2/' . $this->name . '/issues?state=closed';
    }

    public function getGitHubClosedIssueCount()
    {
        $count = 0;

        $key  = $this->name.'-closed-issues';
        $json = $this->cache->get($key);

        if ($json === false) {
            $uri  = self::GIT_HUB_API . $this->name . '/closed';
            $json = file_get_contents($uri);
            if ($json === false) {
                $json = $this->cache->get($key, 'default', false);
            } else {
                $this->cache->save($json, $key);
            }
        }

        if ($json !== false) {
            $result = json_decode($json);
            $count  = count($result->issues);
        }

        return $count;
    }

    public function getGitHubOpenIssueCount()
    {
        $count = 0;

        $key  = $this->name.'-open-issues';
        $json = $this->cache->get($key);

        if ($json === false) {
            $uri  = self::GIT_HUB_API . $this->name . '/open';
            $json = file_get_contents($uri);
            if ($json === false) {
                $json = $this->cache->get($key, 'default', false);
            } else {
                $this->cache->save($json, $key);
            }
        }

        if ($json !== false) {
            $result = json_decode($json);
            $count  = count($result->issues);
        }

        return $count;
    }
}
