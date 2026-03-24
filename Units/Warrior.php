<?php
namespace App\Units;
use App\Interfaces\SpecialAbility;
use App\Traits\Logger;

class Warrior extends Unit implements SpecialAbility {
    use Logger;

    public function getUnitType() {
        return "Воин";
    }

    public function __construct($name, $hp, $damage) {
        parent::__construct($name, $hp, $damage);
    }

    public function attack($target) {
        $this->log("{$this->getName()} бьет мечом {$target->getName()}! Наносит {$this->getDamage()} урона!");
        parent::attack($target);
    }

    public function useUltimate($target) {
        $enhancedDamage = $this->getDamage() * 2.5;
        $this->log("{$this->getName()} бьет огромным мечом {$target->getName()}! Наносит {$enhancedDamage} урона! ");
        $target->receiveDamage($enhancedDamage);
    }

}
