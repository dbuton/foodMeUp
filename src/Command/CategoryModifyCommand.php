<?php

namespace App\Command;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CategoryAddCommand extends Command
{
    protected static $defaultName = 'app:category-crud';

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryCrudCommand constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param null                   $name
     */
    public function __construct(EntityManagerInterface $entityManager, $name = null)
    {
        parent::__construct($name);
        $this->categoryRepository = $entityManager->getRepository(Category::class);
    }

    /**
     */
    protected function configure()
    {
        $this
            ->setDescription('Add or modify category')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of category to add or modify')
            ->addArgument('method', InputArgument::REQUIRED, 'POST or PUT')
            ->addOption('new-name', null, InputOption::VALUE_REQUIRED, 'New name for POST method')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name   = $input->getArgument('name');
        $method = $this->getMethod($input->getArgument('method'));
        $newName = $input->getOption('new-name');

        if ($method === self::METHOD_PUT && $newName === null) {
            throw new \Exception('You must specified a new name.');
        }

        if ($method === self::METHOD_POST) {
            $category = new Category($name);
            $this->categoryRepository->save($category);
        } else {
            $category = $this->categoryRepository->findOneBy(
                ['name' => $name]
            );

            $category->setName($newName);
        }

    }

    /**
     * @param $method
     *
     * @return string
     */
    public function getMethod($method) : string
    {

        if (false === in_array($method, [self::METHOD_POST, self::METHOD_PUT])) {
            throw new Exception('Method must be POST or PUT');
        }

        return $method;
    }
}
