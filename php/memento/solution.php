<?php

namespace DesignPatterns\Memento\Solution;

class Originator
{
    private string $state;

    public function __construct(string $state)
    {
        $this->state = $state;
        echo "Originator: Initial state {$this->state}" . PHP_EOL;
    }

    public function businessLogic(): void
    {
        echo "Originator: Do business logic" . PHP_EOL;
        $this->state = (string) rand(1000, 9999);
        echo "Originator: State after doing of business logic {$this->state}" . PHP_EOL;
    }

    public function save(): Memento
    {
        return new Snapshot($this->state);
    }

    public function restore(Memento $memento): void
    {
        $this->state = $memento->getState();
        echo "Originator: Restored state {$this->state} from snapshot {$memento->getDate()}" . PHP_EOL;
    }
}

interface Memento
{
    public function getState(): string;
    
    public function getDate(): string;
}

class Snapshot implements Memento
{
    private $state;
    
    private $date;

    public function __construct(string $state)
    {
        $this->state = $state;
        $this->date = date('Y-m-d H:i:s');
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getName(): string
    {
        return $this->date . ' / (' . $this->state . ')';
    }

}

class Caretaker
{
    private $originator;

    private array $snapshots = [];

    public function __construct(Originator $originator)
    {
        $this->originator = $originator;
    }

    public function backup()
    {
        echo 'Caretaker: command for originator for backup' . PHP_EOL;
        $this->snapshots[] = $this->originator->save();
    }

    public function undo()
    {
        if(!count($this->snapshots)) {
            return;
        }

        $lastSnapshot = array_pop($this->snapshots);

        echo 'Caretaker: Restoring of ' . $lastSnapshot->getname() . PHP_EOL;
        try {
            $this->originator->restore($lastSnapshot);
        } catch (\Exception $e) {
            $this->undo();
        }
    }

    public function showHistory()
    {
        echo 'Caretaker: List of hisotry: ' . PHP_EOL;
        foreach ($this->snapshots as $key => $snapshot) {
            echo $key + 1 . ' snap: ' . $snapshot->getName() . PHP_EOL;
        }
    }
}


// client code
$originator = new Originator('1111');

$caretaker = new Caretaker($originator);

$caretaker->backup();
$originator->businessLogic();

$caretaker->backup();
$originator->businessLogic();

$caretaker->backup();
$originator->businessLogic();

$caretaker->showHistory();

$originator->businessLogic();
$caretaker->undo();
$caretaker->undo();
$caretaker->undo();