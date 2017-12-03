<?php
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class ShowImagesCommand extends BerylAbstract {

    private $defaultImageTypes = '{*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF}';

    public function __construct() {
        parent::__construct(
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
            ],
            [
                'optName'    => 'show-outline',
                'optDefault' => null,
                'optInput'   => InputOption::VALUE_NONE,
                'optDesc'    => 'Show table with outline',
            ]
            ],
            'This command allows you to show all images within a directory, and optionally limit the display to
            specified file extensions'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $directory = $input->getArgument('directory');

        if (!$input->getArgument('directory') || $input->getArgument('directory') == '') {
            $directory = getcwd();
        } else {
            $directory = $input->getArgument('directory');
        }

        if (!$input->getOption('just') || $input->getOption('just') == '') {
            $ext = 'jpg,png,jpeg,gif';
            $images = glob($directory . DIRECTORY_SEPARATOR . $this->defaultImageTypes, GLOB_BRACE);

        } else {
            $ext = $input->getOption('just');
            $images = glob($directory . DIRECTORY_SEPARATOR . '{*.' . implode(',*.', explode(',', $input->getOption('just'))) . '}', GLOB_BRACE);
        }

        $totalFilesize = null;
        foreach ($images as $image) {
            $totalFilesize += filesize($image);
        }

        $output->writeln([
            '',
            'Beryl - Showing ' . $ext . ' in '  . basename($directory),
            '====================',
            '<comment>Total Images: ' . count($images) . '</>',
            '<comment>Total Size: ' . Helpers::get()->filesize($totalFilesize) . '</>',
            '====================',
            '',
        ]);

        $table = new Table($output);
        $table->setHeaders(array('#', 'Size', 'Filename'));
    

        if (empty($images)) {
            $output->writeln('<error>Ooops, there aren\'t any ' . $ext . ' files in ' . $directory . '</>');
        } else {
            $count = 0;
            $rows = array();
            foreach ($images as $image) {
                $count += 1;
                if ($input->getOption('fullpath')) {
                    $arr = [$count, '<fg=blue>' . Helpers::get()->filesize(filesize($image)) . '</>', $image];
                    $rows[] = $arr;
                } else {
                    $arr = [$count, '<fg=blue>' . Helpers::get()->filesize(filesize($image)) . '</>', basename($image)];
                    $rows[] = $arr;
                }
            }
            $table->setRows($rows);
            $table->setStyle($input->getOption('show-outline') ? 'default' : 'compact');
            $table->render();
        }

    }

}