<?php
namespace LeoGalleguillos\Vote\Model\Table;

use Exception;
use Generator;
use TypeError;
use Zend\Db\Adapter\Adapter;

class Votes
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function decrementUpVotes(
        int $entityTypeId,
        int $typeId
    ):int {
        $sql = '
            UPDATE `votes`
               SET `up_votes` = `up_votes` - 1
             WHERE `entity_type_id` = ?
               AND `type_id` = ?
        ';
        $parameters = [
            $entityTypeId,
            $typeId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    public function incrementUpVotes(
        int $entityTypeId,
        int $typeId
    ):int {
        $sql = '
            UPDATE `votes`
               SET `up_votes` = `up_votes` + 1
             WHERE `entity_type_id` = ?
               AND `type_id` = ?
        ';
        $parameters = [
            $entityTypeId,
            $typeId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    public function insertIgnore(
        int $entityTypeId,
        int $typeId
    ): int {
        $sql = '
            INSERT IGNORE
              INTO `votes` (
                       `entity_type_id`
                     , `type_id`
                   )
            VALUES (?, ?)
                 ;
        ';
        $parameters = [
            $entityTypeId,
            $typeId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    public function select(
        int $entityTypeId,
        int $typeId
    ): array {
        $sql = '
            SELECT `entity_type_id`
                 , `type_id`
                 , `up_votes`
                 , `down_votes`
              FROM `votes`
             WHERE `entity_type_id` = ?
               AND `type_id` = ?
                 ;
        ';
        $parameters = [
            $entityTypeId,
            $typeId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->current();
    }
}
