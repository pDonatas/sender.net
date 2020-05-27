<?php

class Log
{
    public string $datetime;
    public int $N;
    public array $Cats;
    public int $CountAll;
    public int $CountN;

    /**
     * @return array
     */
    public function getCats(): array
    {
        return $this->Cats;
    }

    /**
     * @return int
     */
    public function getCountAll(): int
    {
        return $this->CountAll;
    }

    /**
     * @return int
     */
    public function getCountN(): int
    {
        return $this->CountN;
    }

    /**
     * @return string
     */
    public function getDatetime(): string
    {
        return $this->datetime;
    }

    /**
     * @return int
     */
    public function getN(): int
    {
        return $this->N;
    }

    /**
     * @param array $Cats
     */
    public function setCats(array $Cats): void
    {
        $this->Cats = $Cats;
    }

    /**
     * @param int $CountAll
     */
    public function setCountAll(int $CountAll): void
    {
        $this->CountAll = $CountAll;
    }

    /**
     * @param int $CountN
     */
    public function setCountN(int $CountN): void
    {
        $this->CountN = $CountN;
    }

    /**
     * @param string $datetime
     */
    public function setDatetime(string $datetime): void
    {
        $this->datetime = $datetime;
    }

    /**
     * @param int $N
     */
    public function setN(int $N): void
    {
        $this->N = $N;
    }
}