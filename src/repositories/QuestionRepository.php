<?php declare(strict_types=1);

namespace Bogatyrev\repositories;

use Bogatyrev\PhoneNumber;
use Throwable;
use Bogatyrev\Question;
use Psr\Log\LoggerInterface;

class QuestionRepository
{
    /**
     * @var PersistanceInterface
     */
    private $persistence;

    /**
     * Default logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param PersistanceInterface $persistance
     * @param LoggerInterface $logger
     */
    public function __construct(PersistanceInterface $persistance, LoggerInterface $logger)
    {
        $this->persistence = $persistance;
        $this->logger = $logger;
    }

    /**
     * @param integer|null $limit
     * @param integer|null $offset
     * @param string|null $search
     * @return Question[]
     */
    public function findAll(?int $limit = null, ?int $offset = null, ?string $search = null): array
    {
        $result = [];

        try {
            $results = $this->persistence->find();
            foreach($results as $data) {
                $result[] = Question::fromArray($data);
            }
        } catch (Throwable $t) {
            $this->logger->error($t->getMessage());
        }

        return $result;
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @return boolean
     */
    public function save(Question $question): bool
    {
        $this->persistence->persist($question->toArray());

        return true;
    }
}
