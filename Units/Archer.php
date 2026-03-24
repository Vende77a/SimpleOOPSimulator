<?php
namespace App\Units;
use App\Interfaces\SpecialAbility;
use App\Traits\Logger;

class Archer extends Unit implements SpecialAbility {
    use Logger;

    public function useUltimate($target) {
        $enhancedDamage = $this->getDamage() * 2;
        $this->log("{$this->getName()} бьет градом стрел по {$target->getName()} наносит $enhancedDamage урона");
        $target->receiveDamage($enhancedDamage);
    }
    public function getUnitType() {
        return "Лучник";
    }

    public function __construct($name, $hp, $damage) {
        parent::__construct($name, $hp, $damage);
    }

    public function attack($target) {
        $this->log("{$this->getName()} выпускает стрелу в {$target->getName()}! Наносит {$this->getDamage()} урона!");
        parent::attack($target);
    }
}
