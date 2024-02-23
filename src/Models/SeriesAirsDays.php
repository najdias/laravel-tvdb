<?php

declare(strict_types=1);

namespace Days85\Tvdb\Models;

class SeriesAirsDays
{
    public bool $friday;

    public bool $monday;

    public bool $saturday;

    public bool $sunday;

    public bool $thursday;

    public bool $tuesday;

    public bool $wednesday;

    public function airsAllDays(): bool
    {
        return $this->monday && $this->tuesday && $this->wednesday && $this->thursday && $this->friday &&
            $this->saturday && $this->sunday;
    }

    public function airsNoDays(): bool
    {
        return ! $this->monday && ! $this->tuesday && ! $this->wednesday && ! $this->thursday && ! $this->friday &&
            ! $this->saturday && ! $this->sunday;
    }
}
