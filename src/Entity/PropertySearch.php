<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch {

    /**
     * @var int|null
     */
    #[Assert\Range(min: 10, max: 400)]
    private $minSurface;

    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var ArrayCollection
     */
    private Collection $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * @var int|null $minSurface
     * @return PropertySearch
     */
    public function setMinSurface(int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;

        return $this;
    }

    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @var int|null $maxPrice
     * @return PropertySearch
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions(): ArrayCollection|Collection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection $options
     */
    public function setOptions(ArrayCollection|Collection $options): void
    {
        $this->options = $options;
    }


}