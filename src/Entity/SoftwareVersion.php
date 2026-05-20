<?php

namespace App\Entity;

use App\Repository\SoftwareVersionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SoftwareVersionRepository::class)]
#[ORM\Table(name: 'software_version')]
class SoftwareVersion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name = '';

    #[ORM\Column(length: 255)]
    private string $systemVersion = '';

    #[ORM\Column(length: 255)]
    private string $systemVersionAlt = '';

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $link = '';

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $st = '';

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $gd = '';

    #[ORM\Column]
    private bool $latest = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSystemVersion(): string
    {
        return $this->systemVersion;
    }

    public function setSystemVersion(string $systemVersion): self
    {
        $this->systemVersion = $systemVersion;
        return $this;
    }

    public function getSystemVersionAlt(): string
    {
        return $this->systemVersionAlt;
    }

    public function setSystemVersionAlt(string $systemVersionAlt): self
    {
        $this->systemVersionAlt = $systemVersionAlt;
        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link ?? '';
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;
        return $this;
    }

    public function getSt(): ?string
    {
        return $this->st ?? '';
    }

    public function setSt(?string $st): self
    {
        $this->st = $st;
        return $this;
    }

    public function getGd(): ?string
    {
        return $this->gd ?? '';
    }

    public function setGd(?string $gd): self
    {
        $this->gd = $gd;
        return $this;
    }

    public function isLatest(): bool
    {
        return $this->latest;
    }

    public function setLatest(bool $latest): self
    {
        $this->latest = $latest;
        return $this;
    }
}
