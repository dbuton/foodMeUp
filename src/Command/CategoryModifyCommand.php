<?php

namespace App\Command;

use App\Entity\Category;
use App\Helper\CategoryHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CategoryModifyCommand extends Command
{
    protected static $defaultName = 'app:category-modify';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var CategoryHelper
     */
    private $categoryHelper;

    /**
     * CategoryModifyCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param CategoryHelper         $categoryHelper
     * @param null                   $name
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        CategoryHelper $categoryHelper,
        $name = null
    )
    {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->categoryHelper = $categoryHelper;
    }

    /**
     */
    protected function configure()
    {
        $this
            ->setDescription('Modify category')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of category to add or modify')
            ->addArgument('new-name', null, InputArgument::REQUIRED, 'New name for POST method')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name   = $input->getArgument('name');
        $newName = $input->getArgument('new-name');


        $category = $this->entityManager->getRepository(Category::class)->findOneBy(
            ['name' => $name]
        );

        if ($category === null) {
            throw new \Exception(
                sprintf(
                    'Category %s not found',
                    $name
                )
            );
        }

        $category->setName($newName);
        $this->entityManager->persist($category);

        $this->categoryHelper->processChildrenTree($category);
        $this->entityManager->flush();
    }
}
