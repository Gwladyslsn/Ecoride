<?php

namespace App\Entity;

class TripReview
{
    private ?int $id_review = null;
    private int $note_reviews;
    private \DateTime $date_reviews;
    private string $comment_reviews;
    private string $status_reviews;
    private int $id_user;
    private int $id_recipient;
    private int $id_carpooling;

    public function __construct(
        int $note_reviews,
        \DateTime $date_reviews,
        string $comment_reviews,
        string $status_reviews,
        int $id_user,
        int $id_recipient,
        int $id_carpooling
    ) {
        $this->note_reviews = $note_reviews;
        $this->date_reviews = $date_reviews;
        $this->comment_reviews = $comment_reviews;
        $this->status_reviews = $status_reviews;
        $this->id_user = $id_user;
        $this->id_recipient = $id_recipient;
        $this->id_carpooling = $id_carpooling;
    }

    //GETTERS & SETTERS


    /**
     * Get the value of id_review
     */
    public function getIdReview(): ?int
    {
        return $this->id_review;
    }

    /**
     * Set the value of id_review
     */
    public function setIdReview(?int $id_review): self
    {
        $this->id_review = $id_review;

        return $this;
    }

    /**
     * Get the value of note_reviews
     */
    public function getNoteReviews(): int
    {
        return $this->note_reviews;
    }

    /**
     * Set the value of note_reviews
     */
    public function setNoteReviews(int $note_reviews): self
    {
        $this->note_reviews = $note_reviews;

        return $this;
    }

    /**
     * Get the value of date_reviews
     */
    public function getDateReviews(): \DateTime
    {
        return $this->date_reviews;
    }

    /**
     * Set the value of date_reviews
     */
    public function setDateReviews(\DateTime $date_reviews): self
    {
        $this->date_reviews = $date_reviews;

        return $this;
    }

    /**
     * Get the value of comment_reviews
     */
    public function getCommentReviews(): string
    {
        return $this->comment_reviews;
    }

    /**
     * Set the value of comment_reviews
     */
    public function setCommentReviews(string $comment_reviews): self
    {
        $this->comment_reviews = $comment_reviews;

        return $this;
    }

    /**
     * Get the value of status_reviews
     */
    public function getStatusReviews(): string
    {
        return $this->status_reviews;
    }

    /**
     * Set the value of status_reviews
     */
    public function setStatusReviews(string $status_reviews): self
    {
        $this->status_reviews = $status_reviews;

        return $this;
    }

    /**
     * Get the value of id_user
     */
    public function getIdUser(): int
    {
        return $this->id_user;
    }

    /**
     * Set the value of id_user
     */
    public function setIdUser(int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    /**
     * Get the value of idRecipient
     */
    public function getIdRecipient(): int
    {
        return $this->id_recipient;
    }

    /**
     * Set the value of idRecipient
     */
    public function setIdRecipient(int $id_recipient): self
    {
        $this->id_recipient = $id_recipient;

        return $this;
    }

    /**
     * Get the value of id_carpooling
     */
    public function getIdCarpooling(): int
    {
        return $this->id_carpooling;
    }

    /**
     * Set the value of id_carpooling
     */
    public function setIdCarpooling(int $id_carpooling): self
    {
        $this->id_carpooling = $id_carpooling;

        return $this;
    }
}