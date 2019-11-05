<?php

namespace model;

/**
 * Readonly data structure for a user
 */
class Note
{
    private $title;
    private $note;

    public function __construct(string $title = "", string $note = "")
    {
        $this->setTitle($title);
        $this->setNote($note);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getNote(): string
    {
        return $this->note;
    }

    public function setTitle(string $title): void
    {
        if (strlen($title) < 3)
        {
            throw new TitleTooShortException();
        }
        $this->title = $title;
    }

    public function setNote(string $note): void
    {
        if (strlen($note) < 3)
        {
            throw new NoteTooShortException();
        }
        $this->note = $note;
    }
}
