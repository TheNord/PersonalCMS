<?php

namespace App\Entity\Post;

// для создания отношений (hasMany и тд) используем ArrayCollection
use Doctrine\Common\Collections\ArrayCollection;
// подключаем аннотации доктрины как ORM
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    // при получении из бд автоматически будет сконвертированна в datetime_immutable
    /**
     * @ORM\Column(type="datetime_immutable", name="create_date")
     */
    private $createDate;
    /**
     * @ORM\Column(type="datetime_immutable", name="update_date", nullable=true)
     */
    private $updateDate;
    /**
     * @ORM\Column(type="string")
     */
    private $title;

    // контент назначается составным из класса Content
    // удобно разбивать множественные поля на разные классы чтобы не заграмождать класс

    /**
     * @var Content
     * @ORM\Embedded(class="Content")
     */
    private $content;

    // мета данные также делаем составными из класса Meta

    /**
     * @var Meta
     * @ORM\Embedded(class="Meta")
     */
    private $meta;

    // комментарии для поста, добавляем связь один ко многим, с целью на класс Comment
    // mappedBy - обратная связь из Коммента будет под названием post
    // orphanRemoval при удалении поста будут удаляться и комментарии
    // cascade={"persist"} - добавляем каскадную связь
    // сортировка по дате

    // каскадная связь нужна для того, что мы можем создать пост,
    // наполнить его данными и сохранить в базу 

    /**
     * @var ArrayCollection|Comment[]
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post", orphanRemoval=true, cascade={"persist"})
     * @ORM\OrderBy({"date" = "ASC"})
     */
    private $comments;

    public function __construct(\DateTimeImmutable $date, string $title, Content $content, Meta $meta)
    {
        $this->createDate = $date;
        $this->title = $title;
        $this->content = $content;
        $this->meta = $meta;
        $this->comments = new ArrayCollection();
    }

    public function edit(string $title, Content $content, Meta $meta): void
    {
        $this->title = $title;
        $this->content = $content;
        $this->meta = $meta;
        $this->updateDate = new \DateTimeImmutable();
    }

    // добавление новых комментариев
    public function addComment(\DateTimeImmutable $date, string $author, string $content): void
    {
        // через отношение добавляем новые комментарии
        $this->comments->add(new Comment($this, $date, $author, $content));
    }

    public function removeComment(int $id): void
    {
        foreach ($this->comments as $comment) {
            if ($comment->getId() === $id) {
                $this->comments->removeElement($comment);
            }
        }
        throw new \DomainException('Comment is not found.');
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreateDate(): \DateTimeImmutable
    {
        return $this->createDate;
    }

    public function getUpdateDate(): \DateTimeImmutable
    {
        return $this->createDate;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getMeta(): Meta
    {
        return $this->meta;
    }

    /**
     * @return Comment[]
     */
    public function getComments(): array
    {
        return $this->comments->toArray();
    }

    public function getCommentsCount(): int
    {
        return $this->comments->count();
    }
}
