<?php

namespace App\Test\Controller;

use App\Entity\Details;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DetailsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/details/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Details::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Detail index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'detail[timestemp]' => 'Testing',
            'detail[level]' => 'Testing',
            'detail[client_ip]' => 'Testing',
            'detail[message]' => 'Testing',
            'detail[log]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Details();
        $fixture->setTimestemp('My Title');
        $fixture->setLevel('My Title');
        $fixture->setClient_ip('My Title');
        $fixture->setMessage('My Title');
        $fixture->setLog('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Detail');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Details();
        $fixture->setTimestemp('Value');
        $fixture->setLevel('Value');
        $fixture->setClientIp('Value');
        $fixture->setMessage('Value');
        $fixture->setLog(1);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'detail[timestemp]' => 'Something New',
            'detail[level]' => 'Something New',
            'detail[client_ip]' => 'Something New',
            'detail[message]' => 'Something New',
            'detail[log]' => 'Something New',
        ]);

        self::assertResponseRedirects('/details/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTimestemp());
        self::assertSame('Something New', $fixture[0]->getLevel());
        self::assertSame('Something New', $fixture[0]->getClient_ip());
        self::assertSame('Something New', $fixture[0]->getMessage());
        self::assertSame('Something New', $fixture[0]->getLog());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Details();
        $fixture->setTimestemp('Value');
        $fixture->setLevel('Value');
        $fixture->setClient_ip('Value');
        $fixture->setMessage('Value');
        $fixture->setLog('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/details/');
        self::assertSame(0, $this->repository->count([]));
    }
}
