<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[ORM\Column(type: 'string', length: 255)]
    private $agency;

    #[ORM\Column(type: 'text')]
    private $bio;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\OneToMany(mappedBy: 'collaborator', targetEntity: UserProjectGranted::class, orphanRemoval: true)]
    private $userProjects;

    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'usersHaveFavourite')]
    #[ORM\JoinTable(name: "user_project_favourite")]
    private $favouriteProjects;

    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'usersWhoLiked')]
    #[ORM\JoinTable(name: "user_project_like")]
    private $likedProjects;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Comment::class, orphanRemoval: true)]
    private $comments;

    #[ORM\ManyToMany(targetEntity: Technology::class, inversedBy: 'users')]
    private Collection $technologies;

    #[ORM\Column(type: 'string', length: 255)]
    private $imageUrl;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->userProjects = new ArrayCollection();
        $this->favouriteProjects = new ArrayCollection();
        $this->likedProjects = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->technologies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

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
            $userProject->setCollaborator($this);
        }

        return $this;
    }

    public function removeUserProject(UserProjectGranted $userProject): self
    {
        if ($this->userProjects->removeElement($userProject)) {
            // set the owning side to null (unless already changed)
            if ($userProject->getCollaborator() === $this) {
                $userProject->setCollaborator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getFavouriteProjects(): Collection
    {
        return $this->favouriteProjects;
    }

    public function addFavouriteProject(Project $favouriteProject): self
    {
        if (!$this->favouriteProjects->contains($favouriteProject)) {
            $this->favouriteProjects[] = $favouriteProject;
        }

        return $this;
    }

    public function removeFavouriteProject(Project $favouriteProject): self
    {
        $this->favouriteProjects->removeElement($favouriteProject);

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getLikedProjects(): Collection
    {
        return $this->likedProjects;
    }

    public function addLikedProject(Project $likedProject): self
    {
        if (!$this->likedProjects->contains($likedProject)) {
            $this->likedProjects[] = $likedProject;
        }

        return $this;
    }

    public function removeLikedProject(Project $likedProject): self
    {
        $this->likedProjects->removeElement($likedProject);

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
            $comment->setOwner($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getOwner() === $this) {
                $comment->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, technology>
     */
    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(technology $technology): self
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies[] = $technology;
        }

        return $this;
    }

    public function removeTechnology(technology $technology): self
    {
        $this->technologies->removeElement($technology);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * @param mixed $agency
     */
    public function setAgency($agency): void
    {
        $this->agency = $agency;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}
