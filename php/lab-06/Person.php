<?php

class Person
{
    private string $name;
    private DateTimeImmutable $birthDate;

    public function __construct(string $name, string $birthDateStr)
    {
        $this->name = $name;
        
        try {
            $date = new DateTimeImmutable($birthDateStr);
            if ($date > new DateTimeImmutable()) {
                throw new InvalidArgumentException("Дата рождения не может быть в будущем.");
            }
            $this->birthDate = $date;
        } catch (Exception $e) {
            throw new InvalidArgumentException("Некорректный формат даты рождения. Используйте YYYY-MM-DD.");
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        $today = new DateTimeImmutable();
        return $today->diff($this->birthDate)->y;
    }

    public function isAdult(): bool
    {
        return $this->getAge() >= 18;
    }

    public function getZodiacSign(): string
    {
        $month = (int)$this->birthDate->format('m');
        $day = (int)$this->birthDate->format('d');

        if (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) return "Овен";
        if (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) return "Телец";
        if (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) return "Близнецы";
        if (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) return "Рак";
        if (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) return "Лев";
        if (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) return "Дева";
        if (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) return "Весы";
        if (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) return "Скорпион";
        if (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) return "Стрелец";
        if (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) return "Козерог";
        if (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) return "Водолей";
        return "Рыбы";
    }

    public function __toString(): string
    {
        $status = $this->isAdult() ? "Совершеннолетний" : "Несовершеннолетний";
        return "Имя: {$this->name}, Дата рождения: {$this->birthDate->format('Y-m-d')}, Возраст: {$this->getAge()} лет ({$status}), Знак: {$this->getZodiacSign()}";
    }
}