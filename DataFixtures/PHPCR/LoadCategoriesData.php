<?php

namespace ServerGrove\KbBundle\DataFixtures\PHPCR;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use ServerGrove\KbBundle\Document\Category;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadCategoriesData
 *
 * @author Ismael Ambrosi<ismael@servergrove.com>
 */
class LoadCategoriesData implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $session = $manager->getPhpcrSession();
        $session->getRootNode()->addNode('categories');

        /** @var $parent \Doctrine\ODM\PHPCR\Document\Generic */
        $parent = $manager->find(null, '/categories');

        $cat1 = $this->addCategory($manager, 'Homepage', 'Category for homepage articles', $parent, true);
        $this->addTranslation($manager, $cat1, 'es', 'Inicio', 'Categoria inicio');
        $this->addTranslation($manager, $cat1, 'pt', 'Inicio', 'Categoria inicio');

        $cat2 = $this->addCategory($manager, 'Category A', 'Description', $parent);
        $this->addTranslation($manager, $cat2, 'es', 'Categoria A', 'Categoria A');
        $this->addTranslation($manager, $cat2, 'pt', 'Categoria A', 'Categoria A');

        $cat3 = $this->addCategory($manager, 'Category B', 'Description', $parent);
        $this->addTranslation($manager, $cat3, 'es', 'Categoria B', 'Categoria B');
        $this->addTranslation($manager, $cat3, 'pt', 'Categoria B', 'Categoria B');

        $cat4 = $this->addCategory($manager, 'Category C', 'Description', $parent);
        $this->addTranslation($manager, $cat4, 'es', 'Categoria C', 'Categoria AC');
        $this->addTranslation($manager, $cat4, 'pt', 'Categoria C', 'Categoria AC');

        $category = $this->addCategory($manager, 'Test', 'This is the description of the test category', $parent);
        $subcat1 = $this->addCategory($manager, 'Child', 'Description of child category', $category);
        $this->addTranslation($manager, $subcat1, 'es', 'Hija', 'Categoria Hija');
        $this->addTranslation($manager, $subcat1, 'pt', 'Hija', 'Categoria Hija');
        /*
              $category = $this->addCategory($manager, 'CategoryD', 'This is the description of the test category', $parent);
              $this->addCategory($manager, 'Child', 'Description of child category', $category);
        */      $manager->flush();

        $this->addTranslation($manager, $category, 'es', 'Prueba', 'Esta es la descripción de la categoría de prueba');
        $this->addTranslation($manager, $category, 'pt', 'Prueba', 'Esta es la descripción de la categoría de prueba');

        $manager->flush();
    }

    /**
     * @param  ObjectManager                                 $manager
     * @param  string                                        $name
     * @param  string                                        $description
     * @param  Category|\Doctrine\ODM\PHPCR\Document\Generic $parent
     * @param  bool                                          $private
     * @return Category
     */
    private function addCategory(ObjectManager $manager, $name, $description, $parent, $private = false)
    {

        $category = new Category();
        $category->setParent($parent);
        $category->setName($name);
        $category->setDescription($description);
        $category->setVisibility($private ? Category::VISIBILITY_PRIVATE : Category::VISIBILITY_PUBLIC);

        $manager->persist($category);
        $manager->bindTranslation($category, 'en');
        $manager->flush($category);

        return $category;
    }

    private function addTranslation(ObjectManager $manager, Category $category, $locale, $name, $description)
    {
        $category->setName($name);
        $category->setDescription($description);

        $manager->bindTranslation($category, $locale);
        //$manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }

}