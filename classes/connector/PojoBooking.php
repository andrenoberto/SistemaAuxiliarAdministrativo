<?php


class PojoBooking
{
    private $id;
    private $date;
    private $projectorId;
    private $startsAt;
    private $endsAt;
    private $bookedBy;
    private $requestedBy;
    private $destinationRoom;
    private $destinationCourse;
    private $modelName = '';
    private $createdAt;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        $timeInDatabaseArray = explode(' ', $this->createdAt);
        $dateArray = explode('-', $timeInDatabaseArray[0]);
        $timeArray = explode(':', $timeInDatabaseArray[1]);

        return "{$dateArray[2]}/{$dateArray[1]}/{$dateArray[0]} {$timeArray[0]}:{$timeArray[1]}";
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getModelName()
    {
        return $this->modelName;
    }

    /**
     * @param string $modelName
     */
    public function setModelName($modelName)
    {
        $this->modelName = $modelName;
    }

    /**
     * @return string
     */
    public function getReadableStartsDate()
    {
        $timeInDatabaseArray = explode(' ', $this->getStartsAt());
        $dateArray = explode('-', $timeInDatabaseArray[0]);
        $timeArray = explode(':', $timeInDatabaseArray[1]);

        return "{$dateArray[2]}/{$dateArray[1]}/{$dateArray[0]} {$timeArray[0]}:{$timeArray[1]}";
    }

    /**
     * @return string
     */
    public function getReadableEndsDate()
    {
        $timeInDatabaseArray = explode(' ', $this->getEndsAt());
        $dateArray = explode('-', $timeInDatabaseArray[0]);
        $timeArray = explode(':', $timeInDatabaseArray[1]);

        return "{$dateArray[2]}/{$dateArray[1]}/{$dateArray[0]} {$timeArray[0]}:{$timeArray[1]}";
    }

    /**
     * @return mixed
     */
    public function getSqlDate()
    {
        $dateArray = explode('/', $this->date);
        return "{$dateArray[2]}-{$dateArray[1]}-{$dateArray[0]}";
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProjectorId()
    {
        return $this->projectorId;
    }

    /**
     * @param mixed $projectorId
     */
    public function setProjectorId($projectorId)
    {
        $this->projectorId = $projectorId;
    }

    /**
     * @return mixed
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @param mixed $startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @return string
     */
    public function getSqlStartDate()
    {
        $dateArray = explode('/', $this->getDate());
        return "{$dateArray[2]}-{$dateArray[1]}-{$dateArray[0]} {$this->getStartsAt()}:00";
    }

    /**
     * @return string
     */
    public function getSqlEndDate()
    {
        $dateArray = explode('/', $this->getDate());
        return "{$dateArray[2]}-{$dateArray[1]}-{$dateArray[0]} {$this->getEndsAt()}:00";
    }

    /**
     * @return mixed
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * @param mixed $endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;
    }

    /**
     * @return mixed
     */
    public function getBookedBy()
    {
        return $this->bookedBy;
    }

    /**
     * @param mixed $bookedBy
     */
    public function setBookedBy($bookedBy)
    {
        $this->bookedBy = $bookedBy;
    }

    /**
     * @return mixed
     */
    public function getRequestedBy()
    {
        return $this->requestedBy;
    }

    /**
     * @param mixed $requestedBy
     */
    public function setRequestedBy($requestedBy)
    {
        $this->requestedBy = $requestedBy;
    }

    /**
     * @return mixed
     */
    public function getDestinationRoom()
    {
        return $this->destinationRoom;
    }

    /**
     * @param mixed $destinationRoom
     */
    public function setDestinationRoom($destinationRoom)
    {
        $this->destinationRoom = $destinationRoom;
    }

    /**
     * @return mixed
     */
    public function getDestinationCourse()
    {
        return $this->destinationCourse;
    }

    /**
     * @param mixed $destinationCourse
     */
    public function setDestinationCourse($destinationCourse)
    {
        $this->destinationCourse = $destinationCourse;
    }
}