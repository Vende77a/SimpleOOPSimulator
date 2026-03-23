<?php

abstract class Unit {
    private $name;
    private $hp;
    private $damage;
    private $maxHp;
    private static $unitCount = 0;

    abstract public function getUnitType();

    public function __construct($name, $hp, $damage) {
        $this->name = $name;
        $this->hp = $hp;
        $this->maxHp = $hp;
        $this->damage = $damage;

        self::$unitCount++;
    }

    public function attack($target) {
        $target->receiveDamage($this->damage);
    }

    public function receiveDamage($amount) {
        $this->hp -= $amount;
        if ($this->hp <= 0) {
            echo "$this->name умер" . PHP_EOL;
        }
         else {
             echo "{$this->getName()} имеет {$this->getHp()} HP." . PHP_EOL;
         }
    }

    public function addHp($amount) {
        $this->hp += $amount;

        if ($this->hp >= $this->maxHp) {
            $this->hp = $this->maxHp;
        }
    }

    public function getHp() {
        return $this->hp;
    }
    public function getName() {
        return $this->name;
    }
    public function getDamage() {
        return $this->damage;
    }
    public static function getUnitCount() {
        return self::$unitCount;
    }

    public function isAlive(){
        if ($this->hp > 0) {
            return true;
        }
        else return false;
    }
}

interface SpecialAbility {
    public function useUltimate($target);
}

trait Logger {
    public function log($message) {
        echo $message . PHP_EOL;
    }
}

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

$archer = new Archer("лучник", 100, 25);
$warrior = new Warrior("воин", 200, 35);
$healer = new Healer("лекарь", 70, 10);
$mage = new Mage("маг", 120, 50);
$devilJunior = new DevilJunior("маленький дьявол", 50, 5);
$jester = new Jester("шут", 75, 10);

$teamBlue = [$devilJunior, $mage, $archer];
$teamRed = [$jester, $healer, $warrior];

showingBlueTeam($teamBlue);
showingRedTeam($teamRed);

while (1) {
    if (isTeamAlive($teamBlue) == 0) {
        echo "Красные победили!";
        break;
    }

    if (isTeamAlive($teamRed) == 0) {
        echo "Синие победили!";
        break;
    }

    $teamRedTurn = mt_rand(0, 2);
    $teamRedAttack = mt_rand(0, 2);
    $teamRedUltimateRand = mt_rand(0, 4);

    if ($teamRed[$teamRedTurn]->isAlive() == 1 && $teamBlue[$teamRedAttack]->isAlive() == 1) {
        if ($teamRed[$teamRedTurn] instanceof Healer) {
            if ($teamRed[0]->getHp() > $teamRed[2]->getHp()) {
                $teamRed[1]->heal($teamRed[2]);
            }
            else {
                $teamRed[1]->heal($teamRed[0]);
            }
        }
        elseif ($teamRed[$teamRedTurn] instanceof SpecialAbility && $teamRedUltimateRand == 1 ) {
            $teamRed[$teamRedTurn]->useUltimate($teamBlue[$teamRedAttack]);
        }
        else {
            $teamRed[$teamRedTurn]->attack($teamBlue[$teamRedAttack]);
        }
    }

    $teamBlueTurn = mt_rand(0, 2);
    $teamBlueAttack = mt_rand(0, 2);
    $teamBlueUltimateRand = mt_rand(0, 4);

    if ($teamBlue[$teamBlueTurn]->isAlive() == 1 && $teamRed[$teamBlueAttack]->isAlive() == 1) {
        if ($teamBlue[$teamBlueTurn] instanceof SpecialAbility && $teamBlueUltimateRand == 1) {
            $teamBlue[$teamBlueTurn]->useUltimate($teamRed[$teamBlueAttack]);
        }
        else {
            $teamBlue[$teamBlueTurn]->attack($teamRed[$teamBlueAttack]);
        }
    }

}

function showingBlueTeam($teamBlue) {
    echo "КОМАНДА СИНИХ" . PHP_EOL;
    foreach ($teamBlue as $unit) {
        echo $unit->getName() . "\n";
    }
    echo PHP_EOL;
}

function showingRedTeam($teamRed) {
    echo "КОМАНДА КРАСЫХ" . PHP_EOL;
    foreach ($teamRed as $unit) {
        echo $unit->getName() . "\n";
    }
    echo PHP_EOL;
}

function isTeamAlive($team) {
    $aliveCount = 0;
    foreach ($team as $unit) {
        if ($unit->isAlive() == 1) {
            $aliveCount++;
        }
    }
    return $aliveCount;
}
