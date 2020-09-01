<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\InvoiceItems;
use App\Entity\Invoices;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InvoiceItemsFixtures extends Fixture implements DependentFixtureInterface {

    public function getDependencies() {
        return array(
            InvoicesFixtures::class //wait until Invoices are loaded
        );
    }

    public function load(ObjectManager $manager) {
        $itemsArray = $this->getInvoiceItemsFixtureData();

        foreach ($itemsArray as [$invoiceId, $product, $quantity, $price]) {
            $invoiceItemObj = new InvoiceItems();

            $invoiceObj = $manager->getRepository(Invoices::class)->find($invoiceId);

            $invoiceItemObj->setInvoiceId($invoiceObj);

            $invoiceItemObj->setProduct($product);
            $invoiceItemObj->setQuantity($quantity);
            $invoiceItemObj->setPrice($price);
            $invoiceItemObj->setTotal($price * $quantity);

            $manager->persist($invoiceItemObj);
        }

        $manager->flush();
    }

    private function getInvoiceItemsFixtureData() {
        yield [1, 'Pakiet MS Office', 20, 35000];
        yield [1, 'Windows 10', 20, 65000];
        yield [2, 'Drukarka', 1, 79200];
        yield [2, 'Klawiatura', 2, 4300];
        yield [2, 'Mysz', 2, 3900];
        yield [3, 'Mysz', 6, 3900];
        yield [4, 'Drukarka', 2, 79200];
        yield [4, 'Windows 10', 1, 65000];
        yield [5, 'Klawiatura', 2, 4300];
        yield [6, 'Mysz', 2, 3900];
        yield [7, 'Mysz', 6, 3900];
        yield [8, 'Drukarka', 2, 79200];
        yield [9, 'Mysz', 6, 3900];
        yield [9, 'Klawiatura', 6, 4300];
        yield [10, 'Pakiet MS Office', 20, 35000];
        yield [11, 'Windows 10', 20, 65000];
    }

}
