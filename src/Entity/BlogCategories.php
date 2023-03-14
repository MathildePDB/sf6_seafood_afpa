<?php

namespace App\Entity;

use App\Repository\BlogCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlogCategoriesRepository::class)]
class BlogCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: BlogCategories::class)]
    private Collection $blogCategories;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Articles::class)]
    private Collection $articles;

    public function __construct()
    {
        $this->blogCategories = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, BlogCategories>
     */
    public function getBlogCategories(): Collection
    {
        return $this->blogCategories;
    }

    public function addBlogCategory(BlogCategories $blogCategory): self
    {
        if (!$this->blogCategories->contains($blogCategory)) {
            $this->blogCategories->add($blogCategory);
            $blogCategory->setParent($this);
        }

        return $this;
    }

    public function removeBlogCategory(BlogCategories $blogCategory): self
    {
        if ($this->blogCategories->removeElement($blogCategory)) {
            // set the owning side to null (unless already changed)
            if ($blogCategory->getParent() === $this) {
                $blogCategory->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setCategories($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategories() === $this) {
                $article->setCategories(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
