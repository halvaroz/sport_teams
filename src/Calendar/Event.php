<?php
namespace Calendar;

class Event {

    /*private $id;

    private $teams;

    private $description;

    private $start;

    private $end;

    private $competition;

    private $sexe;

    private $sport;

    private $teamId;

    private $nom;*/

    private $id, $teams,$description,$start,$end,$competition,$sexe,$sport,$teamId,$name;

    public function getName (): string{
        return $this->name;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getTeams (): string {
        return $this->teams;
    }

    public function getCompetition (): string {
        return $this->competition;
    }

    public function getDescription (): string {
        if($this->description ==''){
            return 'Match de championnat';
        }
        return $this->description ?? '';
    }

    public function getStart (): \DateTimeInterface {
        return new \DateTimeImmutable($this->start);
    }

    public function getEnd (): \DateTimeInterface {
        if ($this->end === null) {
            $lastminute = (new \DateTimeImmutable($this->end))
                ->setTime(23,59,00);

            return $lastminute;

        }
        return new \DateTimeImmutable($this->end);
    }

    public function getSexe(): string {
        if (strpos($this->competition, 'masc') !== false){
            return 'men';
        } else {
            return 'women';
        }
    }

    public function getSport(): string{
        $splitter=explode(" ", $this->competition);
        return strtolower($splitter['0']);
    }

    public function getTeamId (): string {
        return $this->teamId;
    }

    public function setTeams (string $teams) {
        $this->teams = $teams;
    }

    public function setCompetition (string $teams) {
        $this->competition = $competition;
    }

    public function setDescription (string $description) {
        $this->description = $description;
    }

    public function setStart (string $start) {
        $this->start = $start;
    }

    public function setEnd (string $end) {
        $this->end = $end;
    }

    public function setTeamId (string $teamId) {
        $this->teamId = $teamId ;
    }

}
