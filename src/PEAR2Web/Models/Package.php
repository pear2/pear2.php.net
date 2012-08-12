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
        
        $this->shortName = str_replace('PEAR2_', '', $this->name);
    }
    
    public function getShortName()
    {
        return $this->shortName;
    }
    
    public function hasGitHubWiki()
    {
        return $this->getGithubInfo()->has_wiki;
    }
    
    public function getGitHubWikiLink()
    {
        return self::GIT_HUB_LINK . $this->shortName . '/wiki';
    }
    
    public function hasGitHubIssues()
    {
        return $this->getGithubInfo()->has_issues;
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
    
    public function getGitHubIssueCount($state)
    {
        $count = 0;

        $key  = $this->name . "-{$state}-issues";
        $json = $this->cache->get($key);

        if ($json === false) {
            $uri  = self::GIT_HUB_API . $this->shortName . '/issues?state=' . $state;
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
    
    protected function getGithubInfo()
    {
        $key  = $this->name . "-wiki";
        $json = $this->cache->get($key);

        if ($json === false) {
            $uri  = self::GIT_HUB_API . $this->shortName;
            $json = is_file($uri) && file_get_contents($uri);
            if ($json === false) {
                $json = $this->cache->get($key, 'default', false);
            } else {
                $this->cache->save($json, $key);
            }
        }
        
        return $json === false
            ? (object) array('has_wiki' => false, 'has_issues' => false)
            : json_decode($json);
    }
}
