<?php

namespace App\Entity;

use App\Repository\LogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogRepository::class)]
class Log
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    public ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'log', targetEntity: Details::class)]
    private Collection $log;

    #[ORM\OneToMany(mappedBy: 'log', targetEntity: User::class)]
    private Collection $user;

    public function __construct()
    {
        $this->log = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, Details>
     */
    public function getLog(): Collection
    {
        return $this->log;
    }

    public function addLog(Details $log): static
    {
        if (!$this->log->contains($log)) {
            $this->log->add($log);
            $log->setLog($this);
        }

        return $this;
    }

    public function removeLog(Details $log): static
    {
        if ($this->log->removeElement($log)) {
            // set the owning side to null (unless already changed)
            if ($log->getLog() === $this) {
                $log->setLog(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getContent();
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setLog($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLog() === $this) {
                $user->setLog(null);
            }
        }

        return $this;
    }
}
