<?php
namespace App\Units;
use App\Interfaces\SpecialAbility;
use App\Traits\Logger;

class DevilJunior extends Unit implements SpecialAbility {
    use Logger;

    public function getUnitType() {
        return "Маленький Дьявол";
    }

    public function __construct($name, $hp, $damage) {
        parent::__construct($name, $hp, $damage);
    }

    public function attack($target) {
        $this->log("{$this->getName()} бьет когтями {$target->getName()}! Наносит {$this->getDamage()} урона!");
        parent::attack($target);
    }

    public function useUltimate($target) {
        $enhancedDamage = $target->getHp();
        $this->log("{$this->getName()} стирает в порошек {$target->getName()}! Наносит {$enhancedDamage} урона! ");
        $target->receiveDamage($enhancedDamage);
    }
}
