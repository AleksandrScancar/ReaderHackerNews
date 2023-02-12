<?php


namespace App\Model\Entity;


use Nette\Utils\DateTime;

class Item
{
    /** @var int */
    private $id;

    /** @var bool */
    private $deleted;

    /** @var bool */
    private $dead;

    /** @var string */
    private $type;

    /** @var string */
    private $by;

    /** @var DateTime */
    private $time;

    /** @var string */
    private $text;

    /** @var string */
    private $parent;

    /** @var string */
    private $poll;

    /** @var string */
    private $kids;//TODO better would be to have kids as Collection of objects Child-Kid

    /** @var string */
    private $url;

    /** @var string */
    private $score;

    /** @var string */
    private $title;

    /** @var string */
    private $parts;

    /** @var int */
    private $descendants;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @return bool
     */
    public function isDead(): bool
    {
        return $this->dead;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getBy(): string
    {
        return $this->by;
    }

    /**
     * @return DateTime
     */
    public function getTime(): DateTime
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getParent(): string
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getPoll(): string
    {
        return $this->poll;
    }

    /**
     * @return string
     */
    public function getKids(): string
    {
        return $this->kids;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getScore(): string
    {
        return $this->score;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getParts(): string
    {
        return $this->parts;
    }

    /**
     * @return int
     */
    public function getDescendants(): int
    {
        return $this->descendants;
    }

    public function constructFromJson(array $data)
    {
        foreach($data as $key => $val) {
            if(property_exists(__CLASS__,$key)) {
                if($key === 'time') {
                    $this->$key =  new DateTime('@' . $val);
                }else{
                    $this->$key = $val;
                }
            }
        }
    }


}