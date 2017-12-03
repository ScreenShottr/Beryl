<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BerylAbstract extends Command {
    protected $cmdName;
    protected $cmdDesc;
    protected $cmdArgs;
    protected $cmdOpts;

    public function __construct($cmdName, $cmdDesc, $cmdArgs, $cmdOpts, $cmdHelp) {
        $this->setVars($cmdName, $cmdDesc, $cmdArgs, $cmdOpts, $cmdHelp);
        parent::__construct();
    }

    protected function setVars($cmdName, $cmdDesc, $cmdArgs, $cmdOpts, $cmdHelp) {
        $this->cmdName = $cmdName;
        $this->cmdDesc = $cmdDesc;
        $this->cmdArgs = $cmdArgs;
        $this->cmdOpts = $cmdOpts;
        $this->cmdHelp = $cmdHelp;
    }

    protected function configure() {
        $this->setName($this->cmdName)->setDescription($this->cmdDesc)->setHelp($this->cmdHelp);


        if (is_array($this->cmdArgs)) {
            foreach ($this->cmdArgs as $args) {
                $this->addArgument($args['argName'], $args['argInput'], $args['argDesc']);
            }
    }
        if (is_array($this->cmdOpts)) {
            foreach ($this->cmdOpts as $opts) {
                $this->addOption(
                    $opts['optName'],
                    $opts['optDefault'],
                    $opts['optInput'],
                    $opts['optDesc'],
                    isset($opts['optExt']) ? $opts['optExt'] : null
                );
            }
        }
    }
}