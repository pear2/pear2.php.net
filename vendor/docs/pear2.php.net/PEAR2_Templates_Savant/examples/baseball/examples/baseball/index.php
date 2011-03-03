<?php
require __DIR__.'/../../../autoload.php';

class BaseballTeam
{
    protected $view = 'player';

    protected $view_map = array(
        'player' => 'BaseballPlayer'
        );

    public $name;

    public $output;

    function __construct($options = array())
    {
        if (isset($options['view'], $this->view_map[$options['view']])) {
            $this->view = $options['view'];
        }
        $this->output = new $this->view_map[$this->view]();
    }
}

class BaseballPlayer
{
    public $name = 'Joseph Baseball <AKA: Joey B>';
    public $years_on_team = array(2005, 2008);
    function __construct()
    {
        $this->years_on_team[] = new PartialSeason(date('Y'));
    }
}

class PartialSeason
{
    public $start;
    public $end;
    
    function __construct($start, $end = null)
    {
        $this->start = $start;
        if ($end) {
            $this->end = $end;
        }
    }
}

$team = new BaseballTeam();
$team->name = 'Phillies';

$savant = new PEAR2\Templates\Savant\Main();
$savant->setEscape('htmlspecialchars');
echo $savant->render($team);