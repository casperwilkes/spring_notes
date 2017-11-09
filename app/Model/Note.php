<?php

/**
 * Purpose:
 *  Handles note content handling
 * History:
 *  110717 - Lincoln: Created file
 */


namespace Spring_App\Model;

use Spring_App\Utility\Logger\Log;
use Spring_App\Utility\DB;

/**
 * Class Note
 * @package Spring_App\Model
 */
class Note {

    /**
     * Note id
     * @var int
     */
    private $id = 0;

    /**
     * User id
     * @var int
     */
    private $user_id = 0;

    /**
     * Note title
     * @var string
     */
    private $title = '';

    /**
     * Note body
     * @var string
     */
    private $body = '';

    /**
     * Created at timestamp
     * @var string
     */
    private $created_at = '';

    /**
     * Updated at timestamp
     * @var string
     */
    private $updated_at = '';

    /**
     * Database Object
     * @var DB
     */
    private $db;

    /**
     * Logging object
     * @var Log
     */
    private $log;

    /**
     * Note constructor.
     * @throws \RuntimeException
     */
    public function __construct() {
        $this->log = new Log([], 'note');
        $db = new DB(loadConfig('db'));
        $this->db = $db->getConn();
    }

    /**
     * Gets all notes based on supplied arguments.
     *  Can fetch: all notes in db, single note based on note id, all notes for user
     * @param int $id ID of note to fetch. 0 to fetch all
     * @param string $id_type Id type supplied if id is supplied. 'note' = note id, 'user' = user id
     * @return array|mixed
     */
    public function getNotes($id = 0, $id_type = 'note') {
        try {
            $sql = 'SELECT n.id, u.name, n.title, n.body, n.created_at, n.updated_at'
                   . ' FROM notes as n'
                   . ' JOIN users as u'
                   . ' ON n.user_id = u.id';

            // note id supplied //
            if ($id !== 0 && $id_type === 'note') {
                $sql .= ' WHERE n.id = :id';
            } elseif ($id !== 0 && $id_type === 'user') {
                // User id supplied //
                $sql .= ' WHERE u.id = :id';
            } else {
                // no id supplied //
                $sql .= '';
            }

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();

            if ($id !== 0 && $id_type === 'note') {
                return $stmt->fetch(\PDO::FETCH_ASSOC);
            }

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $ex) {
            $this->log->exLog($ex, __METHOD__);
        }
    }

    /**
     * Creates a new note in the database
     * @param array $data Note specific data [user_id, title, body]
     * @return bool|int Last inserted id, or false on failure
     */
    public function createNote(array $data) {
        try {
            $sql = 'INSERT INTO notes (user_id, title, body)'
                   . ' VALUES (:user_id, :title, :body)';


            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $data['user_id'], \PDO::PARAM_INT);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':body', $data['body']);

            if ($stmt->execute()) {
                return (int) $this->db->lastInsertId();
            }

            return false;
        } catch (\PDOException $ex) {
            $this->log->exLog($ex, __METHOD__);

            return false;
        }
    }

    /**
     * Updates a note in the database
     * @param array $data Note specific data [title, body]
     * @return bool Whether statement executed properly
     */
    public function updateNote(array $data) {
        try {
            $sql = 'UPDATE notes'
                   . ' SET title = :title, body = :body, updated_at = CURRENT_TIMESTAMP'
                   . ' WHERE id = :id';

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':body', $data['body']);

            return $stmt->execute();
        } catch (\PDOException $ex) {
            $this->log->exLog($ex, __METHOD__);

            return false;
        }
    }

    /**
     * Deletes a note from the database
     * @param int $id Note id to delete
     * @return bool whether note was deleted
     */
    public function deleteNote($id) {
        try {
            $sql = 'DELETE FROM notes WHERE id = :id';

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);

            return $stmt->execute();
        } catch (\PDOException $ex) {
            $this->log->exLog($ex, __METHOD__);

            return false;
        }
    }
}