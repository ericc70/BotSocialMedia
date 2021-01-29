<?php

namespace App\Entity;

use App\Repository\LogBotPostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LogBotPostRepository::class)
 */
class LogBotPost
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @ORM\ManyToOne(targetEntity=BotContent::class, inversedBy="logBotPosts")
     */
    private $texte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getTexte(): ?BotContent
    {
        return $this->texte;
    }

    public function setTexte(?BotContent $texte): self
    {
        $this->texte = $texte;

        return $this;
    }
}
