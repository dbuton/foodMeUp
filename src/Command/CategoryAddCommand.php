<?php

namespace App\Command;

use App\Entity\Category;
use App\Helper\CategoryHelper;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CategoryAddCommand extends Command
{
    protected static $defaultName = 'app:category-add';

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var CategoryHelper
     */
    private $categoryHelper;

    /**
     * CategoryAddCommand constructor.
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
        $this->categoryRepository = $entityManager->getRepository(Category::class);
        $this->categoryHelper = $categoryHelper;
    }

    /**
     */
    protected function configure()
    {
        $this
            ->setDescription('Add category')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of category to add or modify')
            ->addOption('parent-name', null, InputOption::VALUE_REQUIRED, 'Name of parent')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name   = $input->getArgument('name');
        $parentName = $input->getOption('parent-name');

        $category = new Category($name);

        if ($parentName !== null) {
            $parent = $this->categoryRepository->findOneBy(
                ['name' => $parentName]
            );

            if ($parent === null) {
                throw new \Exception(
                    sprintf(
                        'Parent Category %s not found',
                        $parentName
                    )
                );
            }
            $category->setParent($parent);
        }

        $this->categoryHelper->updatePath($category);
        $this->categoryRepository->save($category);

    }
}
