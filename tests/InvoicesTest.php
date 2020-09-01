<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InvoicesTest extends WebTestCase {

    public function testNewInvoice() {
        $newBuyer = 'Acme' . random_int(1111, 9999);

        $client = static::createClient();
        $crawler = $client->request('GET', '/invoice-list');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Add')->form();
        $form['buyer'] = $newBuyer;
        $form['buyerTaxId'] = '123-123-12-12';
        $form['buyerAddress'] = 'Lorum Lorum';

        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();

        $pageContent = $client->getResponse()->getContent();
        $this->assertContains($newBuyer, $pageContent);

        $link = $crawler->filterXpath("(//a[@class='process'])[1]")->link();  //get top most link (new item) for Procces
        $crawler = $client->click($link);

        $pageContent = $client->getResponse()->getContent();
        $this->assertContains("Buyer: <strong>" . $newBuyer, $pageContent);
    }

    public function testNewInvoiceItem() {
        $newItem = "Joystick M-" . random_int(1111, 9999);
        $price = random_int(1, 9999);

        $client = static::createClient();
        $crawler = $client->request('GET', '/process-invoice/1');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Add')->form();
        $form['product'] = $newItem;
        $form['quantity'] = 2;
        $form['price'] = $price;

        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();

        $pageContent = $client->getResponse()->getContent();
        $this->assertContains($newItem, $pageContent);

        $newItemValueFormatted = number_format($price * 2, 2, ".", " ");

        $this->assertContains($newItemValueFormatted, $pageContent);
    }

    public function testUpdateSystem() {
        $newCompany = 'FooBar' . random_int(1111, 9999);

        $client = static::createClient();
        $crawler = $client->request('GET', '/update-system');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Save')->form();
        $form['system[CompanyName]'] = $newCompany;
        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();

        $link = $crawler->filterXpath("//a[@title='Settings']")->link();
        $crawler = $client->click($link);

        $pageContent = $client->getResponse()->getContent();
        $this->assertContains($newCompany, $pageContent);
    }



}
