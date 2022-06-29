<?php

namespace App\Entity;

use App\Repository\UserProjectRepositoryGranted;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserProjectRepositoryGranted::class)]
class UserProjectGranted
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userProjects')]
    #[ORM\JoinColumn(nullable: false)]
    private $collaborator;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'userProjects')]
    #[ORM\JoinColumn(nullable: false)]
    private $project;

    #[ORM\Column(type: 'boolean')]
    private $isGranted;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCollaborator(): ?User
    {
        return $this->collaborator;
    }

    public function setCollaborator(?User $collaborator): self
    {
        $this->collaborator = $collaborator;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function isIsGranted(): ?bool
    {
        return $this->isGranted;
    }

    public function setIsGranted(bool $isGranted): self
    {
        $this->isGranted = $isGranted;

        return $this;
    }
}
