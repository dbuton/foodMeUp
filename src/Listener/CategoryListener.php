<?php

namespace App\Listener;

use App\Entity\Category;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class CategoryListener
{

    /**
     * @param Category           $category
     * @param PreUpdateEventArgs $event
     */
    public function preUpdate(Category $category, PreUpdateEventArgs $event)
    {
        $this->processChildrenTree($category, $event);
    }


    /**
     * @param Category           $category
     * @param LifecycleEventArgs $event
     */
    public function prePersist(Category $category, LifecycleEventArgs $event)
    {
        $this->updatePath($category);
    }

    /**
     * @param Category $category
     */
    private function processChildrenTree(Category $category, PreUpdateEventArgs $event)
    {
        $this->updatePath($category);


        if ($category->getChildren() !== null) {
            foreach ($category->getChildren() as $child) {
                $this->processChildrenTree($child, $event);
            }
        }
    }

    /**
     * @param Category $category
     */
    private function updatePath(Category $category)
    {
        $path = [];

        $categoryTemp = clone($category);

        array_unshift($path, $categoryTemp->getName());

        while ($categoryTemp->getParent() !== null) {

            $categoryTemp = $categoryTemp->getParent();
            array_unshift($path, $categoryTemp->getName());
        }

        $category->setPath(implode('\\', $path));


    }
}
