<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[Vich\Uploadable]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $subject;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'boolean')]
    private $isFinished;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: UserProjectGranted::class, orphanRemoval: true, cascade: ['all'])]
    private $userProjects;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favouriteProjects')]
    private $usersHaveFavourite;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'likedProjects')]
    private $usersWhoLiked;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Link::class, orphanRemoval: true)]
    private $links;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Comment::class, orphanRemoval: true)]
    private $comments;

    #[ORM\ManyToMany(targetEntity: Technology::class, inversedBy: 'projects')]
    private $technologies;

    #[ORM\Column(type: 'string')]
    private $imageName;

    #[Vich\UploadableField(mapping: 'project_image', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $gitHubLink;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $slackLink;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $trelloLink;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $websiteLink;

    public function __construct()
    {
        $this->isFinished = false;
        $this->createdAt = new \DateTime();
        $this->userProjects = new ArrayCollection();
        $this->usersHaveFavourite = new ArrayCollection();
        $this->usersWhoLiked = new ArrayCollection();
        $this->links = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->technologies = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param mixed $imageName
     */
    public function setImageName($imageName): void
    {
        $this->imageName = $imageName;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     */
    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;
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
    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject): void
    {
        $this->subject = $subject;
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

    /**
     * @return Collection<int, Technology>
     */
    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): self
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies[] = $technology;
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): self
    {
        $this->technologies->removeElement($technology);

        return $this;
    }

    public function getGitHubLink(): ?string
    {
        return $this->gitHubLink;
    }

    public function setGitHubLink(?string $gitHubLink): self
    {
        $this->gitHubLink = $gitHubLink;

        return $this;
    }

    public function getSlackLink(): ?string
    {
        return $this->slackLink;
    }

    public function setSlackLink(?string $slackLink): self
    {
        $this->slackLink = $slackLink;

        return $this;
    }

    public function getTrelloLink(): ?string
    {
        return $this->trelloLink;
    }

    public function setTrelloLink(?string $trelloLink): self
    {
        $this->trelloLink = $trelloLink;

        return $this;
    }

    public function getWebsiteLink(): ?string
    {
        return $this->websiteLink;
    }

    public function setWebsiteLink(?string $websiteLink): self
    {
        $this->websiteLink = $websiteLink;

        return $this;
    }
}
