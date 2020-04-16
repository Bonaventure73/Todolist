<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Listing", inversedBy="tasks")
     * @ORM\JoinColumn()
     */
    private $listing;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dueDate;

    private $reminder;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reminderDone = false;


    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): self{
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getListing() {
        return $this->listing;
    }
    /**
     * @param mixed $listing
     */
    public function setListing(listing $listing): void {
        $this->listing = $listing;
    }


    /**
     * @return mixed
     */
    public function getReminder() {
        return $this->reminder;
    }

    /**
     * @param mixed $reminder
     */
    public function setReminder($reminder): void {
        $this->reminder = $reminder;
    }

    
    /**
     * @return mixed
     */
    public function isReminderDone() {
        $this->reminderDone;
    }

    /**
     * @param mixed $reminderDone
     */
    public function setReminderDone($reminderDone): void {
        $this->reminderDone = $reminderDone;
    }
}
