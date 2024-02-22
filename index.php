<?php
//
//class Encounter
//{
//    public const RESULT_WINNER = 1;
//    public const RESULT_LOSER = -1;
//    public const RESULT_DRAW = 0;
//    public const RESULT_POSSIBILITIES = [self::RESULT_WINNER, self::RESULT_LOSER, self::RESULT_DRAW];
//
//    public static function probabilityAgainst(Player $playerOne, Player $playerTwo): float
//    {
//        return 1/(1+(10 ** (($playerTwo->getLevel() - $playerOne->getLevel())/400)));
//    }
//
//    public static function setNewLevel(Player $playerOne, Player $playerTwo, int $playerOneResult): void
//    {
//        if (!in_array($playerOneResult, self::RESULT_POSSIBILITIES)) {
//            trigger_error(sprintf('Invalid result. Expected %s',implode(' or ', self::RESULT_POSSIBILITIES)));
//        }
//        $playerOne->setLevel(
//            $playerOne->getLevel() + round(32 * ($playerOneResult - self::probabilityAgainst($playerOne, $playerTwo)))
//        );
//
//    }
//}
//
//class Player
//{
//    private int $level;
//
//    public function __construct(int $level){
//        $this->level = $level;
//    }
//    public function getLevel(): int
//    {
//        return $this->level;
//    }
//    public function setLevel(int $level): void
//    {
//        $this->level = $level;
//    }
//}
//
//$greg = new Player(400);
//$jade = new Player(800);
//
//echo sprintf(
//        'Greg à %.2f%% chance de gagner face a Jade',
//        Encounter::probabilityAgainst($greg, $jade)*100
//    ).PHP_EOL;
//
//// Imaginons que greg l'emporte tout de même.
//Encounter::setNewLevel($greg, $jade, Encounter::RESULT_WINNER);
//Encounter::setNewLevel($jade, $greg, Encounter::RESULT_LOSER);
//
//echo sprintf(
//    'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade',
//    $greg->getLevel(),
//    $jade->getLevel()
//);






class User
{
    protected const STATUS_ACTIVE = 'active';
    protected const STATUS_INACTIVE = 'inactive';
    public static int $nombreUtilisateursInitialises = 0;

    public function __construct(protected string $username, protected string $status = self::STATUS_ACTIVE)
    {
    }

    public function setStatus(string $status): void
    {
        if (!in_array($status, [self::STATUS_ACTIVE, self::STATUS_INACTIVE])) {
            trigger_error(sprintf('Le status %s n\'est pas valide. Les status possibles sont : %s', $status,
                implode(', ', [self::STATUS_ACTIVE, self::STATUS_INACTIVE])), E_USER_ERROR);
        };

        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}


class Admin extends User
{
    public static int $nombreAdminInitialises = 0;
    public const STATUS_LOCKED = 'locked';

    public function __construct(public string $username, public array $roles = [], public string $status = self::STATUS_ACTIVE)
    {
        parent::__construct($username, $status);
    }

    public function addRole(string $role): void
    {
        $this->roles[] = $role;
        $this->roles = array_filter($this->roles);
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ADMIN';

        return $roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
    public static function nouvelleInitialisation(): void
    {
        self::$nombreUtilisateursInitialises++;
        parent::$nombreUtilisateursInitialises++;
    }
    public function printStatus(): void
    {
        echo '<br><br>'.$this->status.'<br><br>';
    }
    public function setStatus(string $status): void
    {
        if (!in_array($status, [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_LOCKED])) {
            trigger_error(sprintf('Le status %s n\'est pas valide. Les status possibles sont : %s', $status,
                implode(', ', [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_LOCKED])), E_USER_ERROR);
        };

        $this->status = $status;
    }

    public function getStatus(): string
    {
        return strtoupper(parent::getStatus());
    }
}
$u = new User('Greg');
$admin = new Admin('Lily');
$admin->printStatus();
$admin->setStatus(Admin::STATUS_LOCKED);
echo $admin->getStatus();

Admin::nouvelleInitialisation();
var_dump(Admin::$nombreAdminInitialises, Admin::$nombreUtilisateursInitialises, User::$nombreUtilisateursInitialises);