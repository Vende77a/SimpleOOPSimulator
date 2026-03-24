<?php
namespace App\Units;
use App\Interfaces\SpecialAbility;
use App\Traits\Logger;

class Mage extends Unit implements SpecialAbility {
    use Logger;

    public function useUltimate($target) {
        $enhancedDamage = $this->getDamage() * 3;
        $this->log("{$this->getName()} бьет метеоритом по {$target->getName()} наносит {$enhancedDamage}");
        $target->receiveDamage($enhancedDamage);
    }

    public function getUnitType() {
        return "Маг";
    }

    public function __construct($name, $hp, $damage) {
        parent::__construct($name, $hp, $damage);
    }

    public function attack($target) {
        $enhancedDamage = $this->getDamage() * 1.5;
        $this->log("{$this->getName()} бьет магией {$target->getName()} на $enhancedDamage урона!");
        $target->receiveDamage($enhancedDamage);
    }
}
