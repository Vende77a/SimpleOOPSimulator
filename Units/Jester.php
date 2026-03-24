<?php
namespace App\Units;
use App\Interfaces\SpecialAbility;
use App\Traits\Logger;

class Jester extends Unit implements SpecialAbility {
    use Logger;

    public function getUnitType() {
        return "Шут";
    }

    public function __construct($name, $hp, $damage) {
        parent::__construct($name, $hp, $damage);
    }

    public function attack($target) {
        $this->log("{$this->getName()} шутит над {$target->getName()}! Наносит {$this->getDamage()} урона!");
        parent::attack($target);
    }

    public function useUltimate($target) {
        $enhancedDamage = mt_rand(1, 6) * 10;
        $this->log("{$this->getName()} заебал {$target->getName()}! Наносит {$enhancedDamage} урона! ");
        $target->receiveDamage($enhancedDamage);
    }
}
