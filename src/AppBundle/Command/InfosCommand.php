<?php
// src/AppBundle/Command/CreateUserCommand.php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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
        $io = new SymfonyStyle($input, $output);
        
        $placesNumb = $infoProvider->getPlaces();

        $mealsNumb = $infoProvider->getMeals();
        $mealsAverage = $mealsNumb/$placesNumb;

        $menusNumb = $infoProvider->getMenus();

        $usersNumb = $infoProvider->getUsers();

        $latestCreatedPlace = $infoProvider->getLatestCreatedPlace()->getName();

        $latestModifiedPlace = $infoProvider->getLatestModifiedPlace()->getName();

        $ordersFromLastWeek = $infoProvider->getOrdersFromLastWeek();

        $io->section('App statistics');

        $io->table(
            array('Nbr de restaurants', 'Nbr moyen de plats / restaurant', 'Nbr d\'utilisateurs'),
            array(
                array($placesNumb, $mealsAverage, $usersNumb),
            )
        );

        $io->table(
            array('Nbr de menus', 'Dernier restaurant créé', 'Dernier restaurant modifié'),
            array(
                array($menusNumb, $latestCreatedPlace, $latestModifiedPlace),
            )
        );

        $io->title('Nombre de commandes par jour : ');

        for ($i = 6; $i >= 0; $i--) {
            
            $date = $ordersFromLastWeek[0]['data'][$i]['date']->format('d F y');
            $orders = $ordersFromLastWeek[0]['data'][$i]['orders'];

            $io->write($date .' : '. $orders);
            $io->newLine();
        }
    }
}
?>