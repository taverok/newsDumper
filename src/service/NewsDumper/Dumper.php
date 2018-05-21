<?php

namespace repofor\NewsDumper;


class Dumper
{
    private $config;

    /** @var  Parser */
    private $parser;
    private $logger;
    private $dump = [];
    private $dumpSeparator = "<br> \n\n\n";

    public function __construct($config)
    {
        $this->config = $config;
        $this->parser = new Parser($config);
        $this->logger = new Logger($config);
    }

    public function dumpToFile()
    {
        $this->logger->log('PARSER started');

        foreach ($this->config['feeds'] as $feed){
            try{
                $this->dump[] = $this->parser->parseFeed($feed);
            }catch (\Exception $e){
                continue;
            }
        }

        $this->logger->log('PARSER ended');

        $dumpFile = $this->config['rootDir'].'/'.$this->config['dumpFile'];
        file_put_contents($dumpFile, implode($this->dumpSeparator, $this->dump));

        $this->logger->log("DUMPED to $dumpFile");
    }

}