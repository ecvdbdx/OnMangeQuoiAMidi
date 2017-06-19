<?php
// src/AppBundle/Command/CreateUserCommand.php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorldCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:helloworld')

        // the short description shown while running "php bin/console list"
        ->setDescription('Say "Hello world !!!"')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command say "Hellow world !!!"')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $getDataServices = $this->getContainer()->get('getData');
        
        $places = $getDataServices->getPlaces();
        $placeNumb = sizeof($places);

        $meals = $getDataServices->getMeals();
        $mealNumb = sizeof($meals)/sizeof($places);

        $output->writeln('Le nombre de restaurant est de : ' . $placeNumb);
        $output->write('Le nombre moyen de plat par restaurant est de : '. $mealNumb);
    }
}
?>