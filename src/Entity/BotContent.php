<?php

namespace App\Entity;

use App\Repository\BotContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BotContentRepository::class)
 */
class BotContent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $texte;

    /**
     * @ORM\OneToMany(targetEntity=LogBotPost::class, mappedBy="texte")
     */
    private $logBotPosts;

    public function __construct()
    {
        $this->logBotPosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * @return Collection|LogBotPost[]
     */
    public function getLogBotPosts(): Collection
    {
        return $this->logBotPosts;
    }

    public function addLogBotPost(LogBotPost $logBotPost): self
    {
        if (!$this->logBotPosts->contains($logBotPost)) {
            $this->logBotPosts[] = $logBotPost;
            $logBotPost->setTexte($this);
        }

        return $this;
    }

    public function removeLogBotPost(LogBotPost $logBotPost): self
    {
        if ($this->logBotPosts->removeElement($logBotPost)) {
            // set the owning side to null (unless already changed)
            if ($logBotPost->getTexte() === $this) {
                $logBotPost->setTexte(null);
            }
        }

        return $this;
    }
}
