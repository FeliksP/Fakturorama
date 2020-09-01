<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\System;

class SystemFixtures extends Fixture {

    public function load(ObjectManager $manager) {
        $settingsArr = $this->getSystemFixtures();

        foreach ($settingsArr as [$companyName, $companyAddress, $companyTaxID, $defaultCurrency, $companyAccount, $defaultVat]) {
            $systemObj = new System;

            $systemObj->setCompanyName($companyName);
            $systemObj->setCompanyAddress($companyAddress);
            $systemObj->setCompanyTaxID($companyTaxID);
            $systemObj->setDefaultCurrency($defaultCurrency);
            $systemObj->setCompanyAccount($companyAccount);
            $systemObj->setDefaultVat($defaultVat);
            $manager->persist($systemObj);
        }
        $manager->flush();
    }

    private function getSystemFixtures() {
        yield ['Fakturorama Sp. z o. o.', 'Woronicza 1, 00-491 Warszawa', '851-21-22-11', 'PLN', 'PL 12 1234 5678 9012 3456 7890 1234', 23];
    }

}
