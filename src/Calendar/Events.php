<?php
namespace Calendar;

require '../src/Calendar/Event.php';

class Events {

    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère les évènements commençant entre 2 dates
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return Event[]
     */
    public function getEventsBetween (\DateTimeInterface $start, \DateTimeInterface $end): array {
      
        $sql = "SELECT sn_matches.id, sn_matches.teams, sn_matches.description, sn_matches.start, sn_matches.end, sn_matches.teamId AS teamId ,sn_teams.name,sn_teams.competition FROM sn_matches INNER JOIN sn_teams WHERE sn_matches.teamId = sn_teams.id AND start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' ORDER BY start ASC";
        $statement = $this->pdo->query($sql);
        $statement->setFetchMode(\PDO::FETCH_CLASS, Event::class);
        $results = $statement->fetchAll();
   
        return $results;
    }

    /**
     * Récupère les évènements commençant entre 2 dates indexé par jour
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return array
     */
    public function getEventsBetweenByDay (\DateTimeInterface $start, \DateTimeInterface $end): array {
        $events = $this->getEventsBetween($start, $end);

        $days = [];

        foreach($events as $event) {
           
            $date = $event->getStart()->format('Y-m-d');
            if (!isset($days[$date])) {


                $days[$date] = [$event];
            } else {
                $days[$date][] = $event;
            }
        }
        return $days;
    }

    /**
     * Récupère un évènement
     * @param int $id
     * @return Event
     * @throws \Exception
     */
    public function find (int $id): Event {
        $statement = $this->pdo->query("SELECT * FROM sn_matches WHERE id = $id LIMIT 1");
        $statement->setFetchMode(\PDO::FETCH_CLASS, Event::class);
        $result = $statement->fetch();
        if ($result === false) {
            throw new \Exception('Aucun résultat n\'a été trouvé');
        }
        return $result;
    }

    /**
     * @param Event $event
     * @param array $data
     * @return Event
     */
    public function hydrate (Event $event, array $data) {
        $event->setTeamId($data['teamId']);
        $event->setTeams($data['teams']);
        $event->setDescription($data['description']);
        $event->setStart(\DateTimeImmutable::createFromFormat('Y-m-d H:i',
            $data['date'] . ' ' . $data['start'])->format('Y-m-d H:i:s'));
        $event->setEnd(\DateTimeImmutable::createFromFormat('Y-m-d H:i',
            $data['date'] . ' ' . $data['end'])->format('Y-m-d H:i:s'));
        return $event;
    }

    /**
     * Crée un évènement au niveau de la base de donnée
     * @param Event $event
     * @return bool
     */
    public function create (Event $event): bool {
        $statement = $this->pdo->prepare('INSERT INTO sn_matches (teams, description, start, end, teamId) VALUES (?, ?, ?, ?, ?)');
        return $statement->execute([
           $event->getTeams(),
           $event->getDescription(),
           $event->getStart()->format('Y-m-d H:i:s'),
           $event->getEnd()->format('Y-m-d H:i:s'),
           $event->getTeamId(),
        ]);
    }

    /**
     * Met à jour un évènement au niveau de la base de données
     * @param Event $event
     * @return bool
     */
    public function update (Event $event): bool {

        $statement = $this->pdo->prepare('UPDATE sn_matches SET teams = ?, description = ?, start = ?, end = ?, teamId = ? WHERE id = ?');
        return $statement->execute([
            $event->getTeams(),
            $event->getDescription(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s'),
            $event->getTeamId(),
            $event->getId(),
        ]);
    }

    /**
     * TODO: Supprime un évènement
     * @param Event $event
     * @return bool
     */
    public function delete (int $id): bool {
        $statement = $this->pdo->prepare('DELETE  FROM sn_matches WHERE id='.$id.'');

        return $statement->execute();
    }


}
