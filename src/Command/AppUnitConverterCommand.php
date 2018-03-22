<?php

namespace App\Command;

use App\Entity\Unit;
use App\Helper\UnitHelper;
use App\Repository\UnitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AppUnitConverterCommand
 */
class AppUnitConverterCommand extends Command
{
    protected static $defaultName = 'app:unit-converter';
    /**
     * @var UnitRepository
     */
    private $unitRepository;
    /**
     * @var UnitHelper
     */
    private $unitHelper;

    /**
     * AppUnitConverterCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param UnitHelper             $unitHelper
     * @param null                   $name
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UnitHelper $unitHelper,
        $name = null
    )
    {
        parent::__construct($name);
        $this->unitRepository = $entityManager->getRepository(Unit::class);
        $this->unitHelper = $unitHelper;
    }

    /**
     */
    protected function configure()
    {
        $this
            ->setDescription('Give the factor of conversion between 2 units')
            ->addArgument('unitId1', InputArgument::REQUIRED, 'First unit id')
            ->addArgument('unitId2', InputArgument::REQUIRED, '2nd unit id')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $unitId1 = $input->getArgument('unitId1');
        $unitId2 = $input->getArgument('unitId2');

        $unit1 = $this->unitRepository->find($unitId1);
        $unit2 = $this->unitRepository->find($unitId2);

        if ($unit1 === null) {
            throw new \Exception(
                sprintf(
                    'Unit1 %s not exist',
                    $unitId1
                )
            );
        }

        if ($unit2 === null) {
            throw new \Exception(
                sprintf(
                    'Unit1 %s not exist',
                    $unitId1
                )
            );
        }

        $commonUnitId = $this->unitHelper->getCommonUnit($unit1, $unit2);
        $unit1Factor = $this->unitHelper->getUnitsFactor($unit1, $commonUnitId);
        $unit2Factor = $this->unitHelper->getUnitsFactor($unit2, $commonUnitId);

        $output->writeln(
            sprintf(
                'Unit "%s" and unit "%s" have %f factor',
                $unit1->getName(),
                $unit2->getName(),
                round($unit1Factor/$unit2Factor, 2)
            )
        );
    }
}
