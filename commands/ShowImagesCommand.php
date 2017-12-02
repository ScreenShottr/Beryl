<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShowImagesCommand extends BerylAbstract {

    private $out; // output
    private $defaultImageTypes = '{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF}';

    public function __construct() {
        parent::__construct();
        $this->setVars(
            'images:show',
            'Show all images within a directory',
            [[
                'argName'  => 'directory',
                'argInput' => InputArgument::OPTIONAL,
                'argDesc'  => 'Directory to show images within'
            ]],
            [[
                'optName'    => 'just',
                'optDefault' => null,
                'optInput'   => InputOption::VALUE_OPTIONAL,
                'optDesc'    => 'Specify extensions to limit the images returned'
            ],
            [
                'optName'    => 'fullpath',
                'optDefault' => null,
                'optInput'   => InputOption::VALUE_NONE,
                'optDesc'    => 'Display images with their full paths',
            ]]
        );

        $this->configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $directory = $input->getArgument('directory');

        if (!$input->getArgument('directory') || $input->getArgument('directory') == '') {
            $directory = getcwd();
        } else {
            $directory = $input->getArgument('directory');
        }

        if (!$input->getOption('just') || $input->getOption('just') == '') {

            $images = glob($directory . DIRECTORY_SEPARATOR . $this->defaultImageTypes, GLOB_BRACE);

        } else {

            $images = glob($directory . DIRECTORY_SEPARATOR . '{*.' . implode(',*.', explode(',', $input->getOption('just'))) . '}', GLOB_BRACE);
        }

        $output->writeln(PHP_EOL);
        if (empty($images)) {
            $output->writeln('Ooops, there aren\'t any images in ' . strtoupper($directory) . ' directory');
        } else {

            if ($input->getOption('just') && $input->getOption('just') != '') {
                $output->writeln('Showing ' . $input->getOption('just') . ' images in ' . strtoupper($directory) . PHP_EOL);
            } else {
                $output->writeln('Showing all images in: ' . strtoupper($directory) . PHP_EOL);
            }
            foreach ($images as $image) {
                if ($input->getOption('fullpath')) {
                    $output->writeln($image . PHP_EOL);
                } else {
                    $output->writeln(basename($image) . PHP_EOL);
                }
            }
        }

    }

}