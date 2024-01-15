<?php

namespace App\Entity;

use App\Repository\DetailsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsRepository::class)]
class Details
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $timestemp = null;

    #[ORM\Column(length: 255)]
    private ?string $level = null;

    #[ORM\Column(length: 255)]
    private ?string $client_ip = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'log')]
    private ?Log $log = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimestemp(): ?string
    {
        return $this->timestemp;
    }

    public function setTimestemp(string $timestemp): static
    {
        $this->timestemp = $timestemp;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getClientIp(): ?string
    {
        return $this->client_ip;
    }

    public function setClientIp(string $client_ip): static
    {
        $this->client_ip = $client_ip;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getLog(): ?Log
    {
        return $this->log;
    }

    public function setLog(?Log $log): static
    {
        $this->log = $log;

        return $this;
    }
}
