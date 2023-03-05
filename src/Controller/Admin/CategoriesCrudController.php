<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categories::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            /*IdField::new('id'),*/
            TextField::new('title'),
           /* TextEditorField::new('description'),    ->setFormTypeOPtion(['Mapped' => false,'required' => false])*/
            TextField::new('singer'),
            
            ImageField::new('image')->setBasePath('public/uploads/image/')->setUploadDir('public/uploads/image/')->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
            
            ImageField::new('song')->setBasePath('public/uploads/song/')->setUploadDir('public/uploads/song/')
            ->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
            AssociationField::new('Categories')
            
        ];
    }
    
}
