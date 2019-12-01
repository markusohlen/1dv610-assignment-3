<?php

namespace model;

/**
 * Readonly data structure for a user
 */
class Event
{
    private $title;
    private $note;

    public function __construct(string $title, string $note)
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
        if (strlen($title) < \config\Constants::minTitleLength)
        {
            throw new TitleTooShortException();
        }
        $this->title = $title;
    }

    public function setNote(string $note): void
    {
        if (strlen($note) < \config\Constants::minNoteLength)
        {
            throw new NoteTooShortException();
        }
        $this->note = $note;
    }
}
