<?php
namespace App\Units;
use App\Traits\Logger;


class Healer extends Unit {
    use Logger;

    public function getUnitType() {
        return "Лекарь";
    }

    public function __construct($name, $hp, $damage)
    {
        parent::__construct($name, $hp, $damage);
    }

    public function heal($target) {
        $healPower = 20;
        $target->addHp($healPower);
        $this->log("{$this->getName()} исцелил {$target->getName()} на $healPower HP.");
        $this->log("{$target->getName()} имеет {$target->getHp()} HP.");
    }

}
