<?php

namespace App\Entity;

use App\Entity\Trait\SlugTrait;
use App\Repository\MenuCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuCategoriesRepository::class)]
class MenuCategories
{
    use SlugTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $menuCategoryOrder = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'menuCategories')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: MenuCategories::class)]
    private Collection $menuCategories;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Menu::class)]
    private Collection $menus;

    public function __construct()
    {
        $this->menuCategories = new ArrayCollection();
        $this->menus = new ArrayCollection();
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

    public function getMenuCategoryOrder(): ?int
    {
        return $this->menuCategoryOrder;
    }

    public function setMenuCategoryOrder(int $menuCategoryOrder): self
    {
        $this->menuCategoryOrder = $menuCategoryOrder;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getMenuCategories(): Collection
    {
        return $this->menuCategories;
    }

    public function addMenuCategory(MenuCategories $menuCategory): self
    {
        if (!$this->menuCategories->contains($menuCategory)) {
            $this->menuCategories->add($menuCategory);
            $menuCategory->setParent($this);
        }

        return $this;
    }

    public function removeMenuCategory(MenuCategories $menuCategory): self
    {
        if ($this->menuCategories->removeElement($menuCategory)) {
            // set the owning side to null (unless already changed)
            if ($menuCategory->getParent() === $this) {
                $menuCategory->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus->add($menu);
            $menu->setCategory($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getCategory() === $this) {
                $menu->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->menuCategories;
    }

}
