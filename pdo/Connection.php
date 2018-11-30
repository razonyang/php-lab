<?php

class Connection
{
    /**
     * @var PDO $pdo PDO instance.
     */
    private $pdo;

    /**
     * @var string $dsn data source name
     */
    public $dsn;

    /**
     * @var string $username
     */
    public $username;

    /**
     * @var string $password
     */
    public $password;

    /**
     * @var array $options
     */
    public $options;

    /**
     * Connection constructor.
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @param array $options
     */
    public function __construct($dsn, $username = '', $password = '', $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION])
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
    }

    /**
     * Open connection
     * @throws \Exception it is user's responsibility to handle this exception.
     */
    public function open()
    {
        try {
            $this->pdo = new PDO($this->dsn, $this->username, $this->password, $this->options);
        } catch (\PDOException $e) {
            // catch PDOException for avoiding exposing sensitive data.
            throw new \Exception('Could not establish connection: ' . $e->getMessage());
        }
    }

    /**
     * Close connection
     */
    public function close()
    {
        $this->pdo = null;
    }

    /**
     * @return PDO
     * @throws \Exception
     */
    public function getPDO()
    {
        if ($this->pdo === null) {
            $this->open();
        }

        return $this->pdo;
    }

    /**
     * @return null|string connection ID.
     */
    public function getID()
    {
        $stat = $this->getPDO()->query('SELECT connection_id() AS id');
        if (!$stat) {
            return null;
        }

        $row = $stat->fetch(PDO::FETCH_ASSOC);
        return isset($row['id']) ? $row['id'] : null;
    }
}