<?php
require 'vendor/autoload.php';

use App\Units\Archer;
use App\Units\Mage;
use App\Units\Healer;
use App\Units\Warrior;
use App\Units\DevilJunior;
use App\Units\Jester;
use App\Interfaces\SpecialAbility;

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
