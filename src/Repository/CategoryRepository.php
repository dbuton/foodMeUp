<?php

namespace App\Repository;

use App\Entity\Category;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class CategoryRepository extends NestedTreeRepository
{
    /**
     * @param Category $category
     */
    public function save(Category $category) {

        $this->_em->persist($category);
        $this->_em->flush();
    }
}
