<?php declare(strict_types=1);

namespace Bogatyrev\controllers;

use Bogatyrev\Question;
use Psr\Http\Message\ServerRequestInterface;
use Bogatyrev\repositories\QuestionRepository;
use Bogatyrev\translate\TranslatorInterface;
use League\Route\Http\Exception\BadRequestException;

class QuestionController
{
    private $questionRepository;

    private $translator;

    /**
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        QuestionRepository $questionRepository,
        TranslatorInterface $translator
    ) {
        $this->questionRepository = $questionRepository;
        $this->translator = $translator;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return array
     */
    public function listItems(ServerRequestInterface $request) : array
    {
        $response = ['data' => []];
        $params = $request->getQueryParams();
        $lang = $params['lang'] ?? null;

        $results = $this->questionRepository->findAll();
        foreach ($results as $srcQuestion) {
            $question = clone $srcQuestion;
            $question->setText($this->translator->translate($question->getText(), $lang));
            $translatedQuestion = [];

            foreach ($question->getChoices() as $choice) {
                $translatedQuestion[] = $this->translator->translate($choice, $lang);
            }
            $question->setChoices($translatedQuestion);
            $response['data'][] = $question->toArray();
        }
        
        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return array
     */
    public function createItem(ServerRequestInterface $request)
    {
        $json = $request->getBody()->getContents();
        $data = \json_decode($json, true);
        if (json_last_error() !== \JSON_ERROR_NONE) {
            throw new \Error('Json decode error');
        }
        $question = Question::fromArray($data);
        $result = $this->questionRepository->save($question);

        return $question->toArray();
    }
}
