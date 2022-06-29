<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'boolean')]
    private $isFinished;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: UserProjectGranted::class, orphanRemoval: true)]
    private $userProjects;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favouriteProjects')]
    private $usersHaveFavourite;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'likedProjects')]
    private $usersWhoLiked;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Link::class, orphanRemoval: true)]
    private $links;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Comment::class, orphanRemoval: true)]
    private $comments;

    public function __construct()
    {
        $this->userProjects = new ArrayCollection();
        $this->usersHaveFavourite = new ArrayCollection();
        $this->usersWhoLiked = new ArrayCollection();
        $this->links = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): self
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    /**
     * @return Collection<int, UserProjectGranted>
     */
    public function getUserProjects(): Collection
    {
        return $this->userProjects;
    }

    public function addUserProject(UserProjectGranted $userProject): self
    {
        if (!$this->userProjects->contains($userProject)) {
            $this->userProjects[] = $userProject;
            $userProject->setProject($this);
        }

        return $this;
    }

    public function removeUserProject(UserProjectGranted $userProject): self
    {
        if ($this->userProjects->removeElement($userProject)) {
            // set the owning side to null (unless already changed)
            if ($userProject->getProject() === $this) {
                $userProject->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsersHaveFavourite(): Collection
    {
        return $this->usersHaveFavourite;
    }

    public function addUsersHaveFavourite(User $usersHaveFavourite): self
    {
        if (!$this->usersHaveFavourite->contains($usersHaveFavourite)) {
            $this->usersHaveFavourite[] = $usersHaveFavourite;
            $usersHaveFavourite->addFavouriteProject($this);
        }

        return $this;
    }

    public function removeUsersHaveFavourite(User $usersHaveFavourite): self
    {
        if ($this->usersHaveFavourite->removeElement($usersHaveFavourite)) {
            $usersHaveFavourite->removeFavouriteProject($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsersWhoLiked(): Collection
    {
        return $this->usersWhoLiked;
    }

    public function addUsersWhoLiked(User $usersWhoLiked): self
    {
        if (!$this->usersWhoLiked->contains($usersWhoLiked)) {
            $this->usersWhoLiked[] = $usersWhoLiked;
            $usersWhoLiked->addLikedProject($this);
        }

        return $this;
    }

    public function removeUsersWhoLiked(User $usersWhoLiked): self
    {
        if ($this->usersWhoLiked->removeElement($usersWhoLiked)) {
            $usersWhoLiked->removeLikedProject($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Link>
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }

    public function addLink(Link $link): self
    {
        if (!$this->links->contains($link)) {
            $this->links[] = $link;
            $link->setProject($this);
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        if ($this->links->removeElement($link)) {
            // set the owning side to null (unless already changed)
            if ($link->getProject() === $this) {
                $link->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProject($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProject() === $this) {
                $comment->setProject(null);
            }
        }

        return $this;
    }
}
