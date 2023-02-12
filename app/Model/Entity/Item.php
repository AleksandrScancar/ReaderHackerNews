<?php

declare(strict_types = 1);

namespace App\Model\Entity;

use Nette\Utils\DateTime;
use function property_exists;

final class Item
{

    private int $id;

    private bool $deleted;

    private bool $dead;

    private string $type;

    private string $by;

    private DateTime $time;

    private string $text;

    private string $parent;

    private string $poll;

    private string $kids;

    private string $url;

    private int $score;

    private string $title;

    private string $parts;

    private int $descendants;

    public function getId(): int
    {
        return $this->id;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function isDead(): bool
    {
        return $this->dead;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getBy(): string
    {
        return $this->by;
    }

    public function getTime(): DateTime
    {
        return $this->time;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getParent(): string
    {
        return $this->parent;
    }

    public function getPoll(): string
    {
        return $this->poll;
    }

    public function getKids(): string
    {
        return $this->kids;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getParts(): string
    {
        return $this->parts;
    }

    public function getDescendants(): int
    {
        return $this->descendants;
    }

    public function constructFromJson(array $data): void
    {
        foreach ($data as $key => $val) {
            if (property_exists(self::class, $key)) {
                $this->$key = $key === 'time'
                    ? new DateTime('@' . $val)
                    : $val;
            }
        }
    }

}
