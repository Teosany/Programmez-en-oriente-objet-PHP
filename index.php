<?php

class encounter
{
    public const RESULT_WINNER = 1;
    public const RESULT_LOSER = -1;
    public const RESULT_DRAW = 0;
    public const RESULT_POSSIBILITIES = [
        self::RESULT_WINNER, self::RESULT_LOSER, self::RESULT_DRAW
    ];

    public function probabilityAgainst(int $levelPlayerOne, int $againstLevelPlayerTwo)
    {
        return 1/(1+(10 ** (($againstLevelPlayerTwo - $levelPlayerOne)/400)));
    }

    public function setNewLevel(int &$levelPlayerOne, int $againstLevelPlayerTwo, int $playerOneResult)
    {
        if (!in_array($playerOneResult, self::RESULT_POSSIBILITIES)) {
            trigger_error(sprintf('Invalid result. Expected %s',implode(' or ', self::RESULT_POSSIBILITIES)));
        }

        $levelPlayerOne += (int) (32 * ($playerOneResult - $this->probabilityAgainst($levelPlayerOne, $againstLevelPlayerTwo)));
    }
}

$perso = new encounter();

$greg = 400;
$jade = 800;

echo sprintf(
    'Greg à %.2f%% chance de gagner face a Jade',
    $perso->probabilityAgainst($greg, $jade)*100
).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
$perso->setNewLevel($greg, $jade, $perso::RESULT_WINNER);
$perso->setNewLevel($jade, $greg, $perso::RESULT_LOSER);

echo sprintf(
    'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade',
    $greg,
    $jade
);

exit(0);
