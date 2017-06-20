<?php
// src/AppBundle/Command/CreateUserCommand.php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InfosCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('app:stats')

        // the short description shown while running "php bin/console list"
        ->setDescription('Returns app stats and infos')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command returns infos and stats about the app')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $infoProvider = $this->getContainer()->get('infoProvider');
        
        $placesNumb = $infoProvider->getPlaces();

        $mealsNumb = $infoProvider->getMeals();
        $mealsAverage = $mealsNumb/$placesNumb;

        $menusNumb = $infoProvider->getMenus();

        $usersNumb = $infoProvider->getUsers();

        $latestCreatedPlace = $infoProvider->getLatestCreatedPlace()->getName();

        $latestModifiedPlace = $infoProvider->getLatestModifiedPlace()->getName();

        $ordersByDay = $infoProvider->getOrdersByDay();


        $output->writeln('Le nombre de restaurant est de : ' . $placesNumb);
        $output->write('Le nombre moyen de plat par restaurant est de : '. $mealsAverage);
        $output->write('Le nombre d\'utilisateurs est : '. $usersNumb . '   ');
        $output->write('Le nombre de menus est : '. $menusNumb . '   ');
        $output->write('Le dernier restaurant créé est : '. $latestCreatedPlace . '   ');
        $output->write('Le dernier restaurant modifié est : '. $latestModifiedPlace . '   ');
        $output->write('Commandes cette semaine : '. $latestModifiedPlace . '   ');
        $output->write('Nombre de commandes par jour : ');

        for ($i = 6; $i >= 0; $i--) {
            $output->write($ordersByDay[0]['data'][$i]['date']->format('d F y') .' : '. $ordersByDay[0]['data'][$i]['orders'] .'    ');
        }
    }
}
?>