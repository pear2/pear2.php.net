<?php

namespace PEAR2Web\Models;

class Package extends \PEAR2\SimpleChannelFrontend\Package
{
    const GIT_HUB_API = 'https://api.github.com/repos/pear2/';
    const GIT_HUB_LINK = 'https://github.com/pear2/';

    protected $cache;
    
    protected $shortName;

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->cache = new \PEAR2\Cache\Lite\Main();
        $this->cache->setLifeTime(15 * 60);
        
        $this->shortName = str_replace('PEAR2_', '', $this->name, 1);
    }
    
    public function getShortName()
    {
        return $this->shortName;
    }

    public function getGitHubNewIssueLink()
    {
        return self::GIT_HUB_LINK . $this->shortName . '/issues/new';
    }

    public function getGitHubOpenIssuesLink()
    {
        return self::GIT_HUB_LINK . $this->shortName . '/issues';
    }

    public function getGitHubClosedIssuesLink()
    {
        return self::GIT_HUB_LINK . $this->shortName . '/issues?state=closed';
    }

    public function getGitHubClosedIssueCount()
    {
        $count = 0;

        $key  = $this->name.'-closed-issues';
        $json = $this->cache->get($key);

        if ($json === false) {
            $uri  = self::GIT_HUB_API . $this->shortName . '/issues?state=closed';
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
            $uri  = self::GIT_HUB_API . $this->shortName . '/issues?state=open';
            $json = file_get_contents($uri);
            if ($json === false) {
                $json = $this->cache->get($key, 'default', false);
            } else {
                $this->cache->save($json, $key);
            }
        }

        if ($json !== false) {
            $count  = count(json_decode($json));
        }

        return $count;
    }
}
