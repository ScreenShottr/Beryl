<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UploadImagesCommand extends BerylAbstract {
    
    public function __construct() {
        parent::__construct(
            'images:upload',
            'Show all images within a directory',
            [[
                'argName'  => 'image',
                'argInput' => InputArgument::REQUIRED,
                'argDesc'  => 'Images to be uploaded to the ScreenShottr service'
            ]],
            [[
                'optName'    => 'json',
                'optDefault' => null,
                'optInput'   => InputOption::VALUE_NONE,
                'optDesc'    => 'Return JSON instead of single URL'
            ],
            [
                'optName'    => 'noclip',
                'optDefault' => null,
                'optInput'   => InputOption::VALUE_NONE,
                'optDesc'    => 'Do not automatically copy the shortened URL to clipboard',
            ]],
            'This command allows you to upload images to the ScreenShottr service.'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        if ($input->getArgument('image') == 'all') {
            $image = 'all';
        } else {
            $image = $input->getArgument('image');
        }

        if (!$image == 'all') {
            if (!file_exists($image)) {
                $output->writeln($image . ' does not exist, please specify a valid filename');
            }
        }

    }

}