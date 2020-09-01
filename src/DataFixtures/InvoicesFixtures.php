<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Invoices;

class InvoicesFixtures extends Fixture {

    public function load(ObjectManager $manager) {
        $invoiceArray = $this->getInvoiceFixtureData();

        foreach ($invoiceArray as [$invoiceNumber, $invoiceDate, $buyerName, $buyerTaxId, $buyerAddress]) {
            $invoiceObj = new Invoices();

            $invoiceObj->setNumber($invoiceNumber);
            $aDateObj = new \DateTime($invoiceDate);
            $invoiceObj->setIssueDate($aDateObj);

            $invoiceObj->setBuyerName($buyerName);
            $invoiceObj->setBuyerTaxId($buyerTaxId);
            $invoiceObj->setBuyerAddress($buyerAddress);

            $manager->persist($invoiceObj);
        }

        $manager->flush();
    }

    private function getInvoiceFixtureData() {
        yield ['2020/0001', '2020-08-12', 'Zakład usług kanalizacyjnych', '123-41-12-222', 'ul. Zawiślanska 12, 00-419 Warszawa'];
        yield ['2020/0002', '2020-08-13', 'Drutex Sp. z o.o.', '143-21-12-445', 'ul. Nadmorska 8, 71-120 Bezrzecze'];
        yield ['2020/0003', '2020-08-18', 'Mróz Sp. Jawna', '747-21-13-214', 'ul. Gostyńska 8, 41-124 Borek Wlkp.'];
        yield ['2020/0004', '2020-08-23', 'Pogoń Szczecin S/A', '771-21-33-214', 'ul. Twardowskiego 1, 71-899 Szczecin'];
        yield ['2020/0005', '2020-08-28', 'Taran Sp. z o.o.', '817-00-05-762', 'Olsztyńska 1B, 71-042 Szczecin'];
        yield ['2020/0006', '2020-08-28', 'Wilhelmsen MArine Personael', '819-00-05-733', 'pl. Rodła 8, 70-419 Szczecin'];
        yield ['2020/0007', '2020-08-29', 'Mróz Sp. Jawna', '747-21-13-214', 'ul. Gostyńska 8, 41-124 Borek Wlkp.'];
        yield ['2020/0008', '2020-08-30', 'Taran Sp. z o.o.', '817-00-05-762', 'Olsztyńska 1B, 71-042 Szczecin'];
        yield ['2020/0009', '2020-08-31', 'Drutex Sp. z o.o.', '143-21-12-445', 'ul. Nadmorska 8, 71-120 Bezrzecze'];
        yield ['2020/0010', '2020-08-31', 'Zakład usług kanalizacyjnych', '123-41-12-222', 'ul. Zawiślanska 12, 00-419 Warszawa'];
        yield ['2020/0011', '2020-08-31', 'Pogoń Szczecin S/A', '771-21-33-214', 'ul. Twardowskiego 1, 71-899 Szczecin'];
    }

}
