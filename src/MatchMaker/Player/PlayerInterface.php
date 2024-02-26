<?php

namespace App\MatchMaker\Player;

interface PlayerInterface {
    public function getName(): string;
    public function updateRatioAgainst(): void;
    public function getRatio(): ?float;

}