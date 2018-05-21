<?php

namespace repofor\NewsDumper;


use Sunra\PhpSimple\HtmlDomParser;

class Parser
{

    private $logger;

    /**
     * @param $config
     */
    public function __construct($config)
    {
        $this->logger = new Logger($config);
    }


    public function parseFeed($feed)
    {
        $feedLink = $this->normalizeUrl($feed['url'], $feed['scheme']);
        if (!$feedLink){
            return null;
        }

        $this->logger->log("LINK - sending request $feedLink");

        $articleLink = $this->getArticleLink($feedLink, $feed['articlesClass'], $feed['articleNo']);
        $articleLink = $this->normalizeUrl($articleLink, $feed['scheme']);

        $this->logger->log("CONTENT - sending request $articleLink");

        $removeTags = array_key_exists('removeTags', $feed) ? $feed['removeTags'] : [];

        return $this->getContent($articleLink, $feed['contentClass'], $removeTags);
    }


    /**
     * @param $url
     * @return \simplehtmldom_1_5\simple_html_dom
     * @throws \Exception
     */
    public function getDom($url)
    {
        $content = HtmlDomParser::file_get_html( $url );

        if (!$content){
            throw new \Exception("Invalid link");
        }
        return HtmlDomParser::file_get_html( $url );
    }
    
    public function getContent($url, $class, $removeTags = [])
    {
        $this->logger->log("CONTENT - parser started $url");

        $dom = $this->getDom($url);

        if (!$dom){
            $this->logger->log("CONTENT - Could not parse content in $url");
            return null;
        }

        $node = $dom->find($class, 0);
		
		if (!$node){
            $this->logger->log("CONTENT - Content with class $class not found in $url");
            return null;
        }
		
        foreach ($removeTags as $tag){
            $this->changeTags($node, $tag);
        }
        
//        foreach ($node->find('a') as $link){
//            $link->outertext = $link->text();
//        }

        $this->logger->log("CONTENT - parser ended $url");

        return (string) $node;
    }

    /**
     * @param $node \simplehtmldom_1_5\simple_html_dom_node
     * @param $tag
     * @param string $replaceWith
     */
    public function changeTags($node, $tag, $replaceWith = '')
    {
        foreach ($node->find($tag) as $subNode) {
            $subNode->outertext = $replaceWith;
        }
    }

    /**
     * @param $url
     * @param $class
     * @param int $linkNo
     * @return string
     */
    public function getArticleLink($url, $class, $linkNo = 1)
    {
        $this->logger->log("LINK - parser started $url");

        $dom = $this->getDom($url);
        if (!$dom){
            $this->logger->log("LINK - Could not parse content in $url");
            return null;
        }

        $classNode = $dom->find($class, 0);
        if (!$classNode){
            $this->logger->log("LINK - Content with links not found in $url");
            return null;
        }

        $linkNode = $classNode->find('a');
        if (!$linkNode or !array_key_exists($linkNo, $linkNode)){
            $this->logger->log("LINK - No link number $linkNo in $url");
            return null;
        }

        $link = $linkNode[$linkNo]->href;

        $path = parse_url($link, PHP_URL_PATH);
        $host = parse_url($url, PHP_URL_HOST);
        $linkHost = parse_url($link, PHP_URL_HOST);

        $host = $linkHost && $linkHost != $host ? $linkHost : $host;

        $this->logger->log("LINK - parser ended $url");
        return $host.$path;
    }

    public function normalizeUrl($url, $scheme = 'http')
    {
        $url = trim($url, '/');

        if (!preg_match('~^http(s)?://~', $url)) {
            $url = $scheme. '://' . $url;
        }

        return $url;
    }
}