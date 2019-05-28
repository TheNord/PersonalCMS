<?php

namespace App\Entity\Post;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comments")
 */
class Comment
{
    // отношение многие к одному к постам
    // JoinColumn внешний ключ - добавляем связь к посту по id, nullable = false, чтобы комментарий не оставался после каскадного удаления

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $post;
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;
    /**
     * @ORM\Column(type="string")
     */
    private $author;
    /**
     * @ORM\Column(type="text")
     */
    private $text;

    // прокидываем Пост для связи с постом
    public function __construct(Post $post, \DateTimeImmutable $date, string $author, string $text)
    {
        $this->post = $post;
        $this->date = $date;
        $this->author = $author;
        $this->text = $text;
    }

    public function edit($text): void
    {
        $this->text = $text;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
