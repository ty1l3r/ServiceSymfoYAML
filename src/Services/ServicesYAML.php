<?php

namespace App\Services;

use App\Entity\Organizations;
use Symfony\Component\Yaml\Yaml;

class ServicesYAML
{

    /////////////////////////////////////////////////////////////// READ
    public function ReadOrganizationsYAML()
    {
        $getFile = Yaml::parseFile('asserts/organizations.yaml');
        return $getFile['organizations'];
    }

    /////////////////////////////////////////////////////////////// CREATE
    public function CreateOrganization($formAddOrganizations)
    {
        //Récupération des données du formulaire
        $description = $formAddOrganizations->getData()->getDescription();
        $nameResult = $formAddOrganizations->getData()->getName();
        $userName = $formAddOrganizations->getData()->getUserName();
        $userRoles = $formAddOrganizations->getData()->getUserRole();
        //crée l'entité
        $organizations = $this->ArrayToEntity($description, $nameResult, $userName, $userRoles);
        //DUMP Entity->YAML
        dump($organizations);
        $this->WriteNewOrganizations($organizations);
    }

    /////////////////////////////////////////////////////////////// UPDATE
    public function UpdateForm($organizations, $dataForm)
    {

        //récupère le YAML
        $data = $this->ReadOrganizationsYAML();
        //réécrit le fichier YAML sans l'organisazion selectioné par l'update
        foreach ($data as $k => $v) {
            $result = $v;
            if ($result['name'] != $dataForm) {
                $updateData[] = $result;
            };
        }
        /** @var $updateData */
        $this->WriteOrganizations($updateData);
        //Récupérer les donnée du FORM
        $nameResult = $organizations->getName();
        $description = $organizations->getDescription();
        $userName = $organizations->getUserName();
        $userRoles = $organizations->getUserRole();
        //make Entity
        $organizationClass = new Organizations();
        $organizationClass  ->setName($nameResult)
            ->setDescription($description)
            ->setUserName($userName)
            ->setUserRole($userRoles);

        //Création de la STDClass
        $organizations = new \stdClass();
        $organizations->name = "$nameResult";
        $organizations->description = "$description";
        foreach ($userName as $k => $nameValue) {
            dump($nameValue);
            $resultNames = $nameValue;
            $organizations->users[] =
                ['name' => $resultNames, 'role' => $userRoles[$k], 'password' => 'password'];
        }
        //Dump du YAML
        $this->WriteUsers($organizations);
    }

    /////////////////////////////////////////////////////////////// DELETE
    public function DeleteOrganizations($dataForm)
    {
        $data = $this->ReadOrganizationsYAML();
        foreach ($data as $v) {
            $result = $v;
            if ($result['name'] != $dataForm) {
                $updateData[] = $result;
            };
        }
        /** @var  $updateData */
        $this->WriteOrganizations($updateData);
    }

    /////////////////////////////////////////////////////////////// UTILITAIRES

    //OBJECT DUMP TO YAML
    public function ArrayToEntity($description, $nameResult, $userName, $userRoles)
    {
        $organizations = new \stdClass();
        $organizations->name = $nameResult;
        $organizations->description = $description;
        $password = "password";
        $organizations->users[] = ['name' => $userName, 'role' => [$userRoles], 'password' => $password];
        return $organizations;
    }

    public function MakeEntityYAMLForm($dataForm)
    {
        //SYMFONY SERVICE
        $data = $this->ReadOrganizationsYAML();
        foreach ($data as $k => $v) {
            $result = $v;
            //On se place dans l'organization selectionée
            if ($result['name'] === $dataForm) {
                //Création d'un tableau des noms $namesTab
                $resultName = $result['users'];
                foreach ($resultName as $keyName => $valueName) {
                    $names = $valueName;
                    $namesTab[] = $names['name'];
                    //récupérer le tableau role de l'organization selectionnée
                    $roleTab[] = $names['role'];
                }
                //création de la class ENTITY Organization
                $resultClass = new \stdClass();
                $resultClass->name = $result['name'];
                $resultClass->description = $result['description'];
                $resultClass->userName = $namesTab;
                $resultClass->userRole = $roleTab;
                //Récupération pour inscription en Formulaire TEXT
                $organizations = new Organizations();
                $organizations->setName($result['name'])
                    ->setDescription($result['description'])
                    ->setUserName($namesTab)
                    ->setUserRole($roleTab);
                return $organizations;
            }
        }
    }

    /////////////////////////////////////////////////////////////// YAML WRITE

    public function WriteOrganizations($updateData)
    {
        //Réécriture du fichier sans l'Update
        $yaml = Yaml::dump(['organizations' => $updateData], 5, 2, Yaml::DUMP_OBJECT_AS_MAP);
        file_put_contents('asserts/organizations.yaml', $yaml);
    }

    public function WriteUsers($organizations)
    {
        $yaml = Yaml::dump([$organizations], 4, 3, Yaml::DUMP_OBJECT_AS_MAP);
        file_put_contents('asserts/organizations.yaml', "  " . $yaml, FILE_APPEND);
    }

    public function WriteNewOrganizations($organizations)
    {
        $yaml = Yaml::dump([$organizations], 4, 3, Yaml::DUMP_OBJECT_AS_MAP);
        file_put_contents
        ('asserts/organizations.yaml', "\n" . "  " . $yaml, FILE_APPEND);
    }

}
