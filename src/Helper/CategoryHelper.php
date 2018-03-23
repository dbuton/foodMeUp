<?php

namespace App\Helper;

use App\Entity\Category;

class CategoryHelper
{
    /**
     * @param Category $category
     */
    public function processChildrenTree(Category $category)
    {
        $this->updatePath($category);


        if ($category->getChildren() !== null) {
            foreach ($category->getChildren() as $child) {
                $this->processChildrenTree($child);
            }
        }
    }

    /**
     * @param Category $category
     */
    public function updatePath(Category $category)
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
