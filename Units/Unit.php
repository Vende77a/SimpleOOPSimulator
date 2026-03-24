<?php
namespace App\Units;

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
