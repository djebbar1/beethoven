<?php

namespace App\Controller\Admin;

use App\Entity\Music;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
//use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MusicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Music::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('singer'),
            
            ImageField::new('image')->setBasePath('uploads/image/')->setUploadDir('public/uploads/image/')->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
            
            ImageField::new('song')->setBasePath('uploads/song/')->setUploadDir('public/uploads/song/')
            ->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
            AssociationField::new('categorie')
            

        ];
    }
    
}
