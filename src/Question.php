<?php declare(strict_types=1);

namespace Bogatyrev;

use DateTime;

/**
 * Question item.
 */
class Question
{
    /**
     * ID
     *
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private $choices = [];

    /**
     * @var string
     */
    private $createdAt;


    public static function fromArray(array $data): Question
    {
        /** Question $result */
        $result = new Question();
        $result->setText($data['text']);
        $result->setCreatedAt($data['createdAt']);

        $choices = [];
        foreach ($data['choices'] as $choice) {
            $choices[] = $choice['text'];
        }
        $result->setChoices($choices);

        return $result;
    }

    /**
     * Get the value of createdAt
     *
     * @return  string
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param  string  $createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAtDt(): ?DateTime
    {
        $result = DateTime::createFromFormat('Y-m-d H:i:s', $this->getCreatedAt());
        if ($result === false) {
            return null;
        }
        return $result;
    }

    /**
     * Returns as array data.
     *
     * @return array
     */
    public function toArray(): array
    {
        $choices = [];

        foreach ($this->choices as $item) {
            $choices[] = ['text' => $item];
        }

        return [
            'text' => $this->getText(),
            'createdAt' => $this->getCreatedAt(),
            'choices' => $choices,
        ];
    }

    /**
     * Get the value of choices
     *
     * @return  array
     */ 
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * Set the value of choices
     *
     * @param  array  $choices
     *
     * @return  self
     */ 
    public function setChoices(array $choices)
    {
        $this->choices = $choices;

        return $this;
    }

    /**
     * Get iD
     *
     * @return  string
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set iD
     *
     * @param  string  $text  ID
     *
     * @return  self
     */ 
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }
}
