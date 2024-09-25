<?php

namespace App\Controller;

use App\Request\ProduceRequest;
use App\Service\ProduceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api', name: 'api_')]
class ProduceController extends AbstractController
{
    private const FRUIT = 'fruit';
    private const VEGETABLE = 'vegetable';


    public function __construct(private ProduceService $produceService)
    {
    }

    #[Route('/process', name: 'process_json', methods: ['POST'])]
    public function processJson(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $jsonContent = $request->getContent();
        $this->produceService->processJsonFile($jsonContent);
        return new JsonResponse(['message' => 'JSON processed successfully']);
    }

    #[Route('/fruits', name: 'list_fruits', methods: ['GET'])]
    public function listFruits(Request $request): JsonResponse
    {
        $fruits = $this->produceService->list( self::FRUIT, $request);

        return $this->json($fruits);
    }

    #[Route('/vegetables', name: 'list_vegetables', methods: ['GET'])]
    public function listVegetables(Request $request): JsonResponse
    {
        $vegetables = $this->produceService->list( self::VEGETABLE, $request);

        return $this->json($vegetables);
    }

    #[Route('/fruit', name: 'add_fruit', methods: ['POST'])]
    public function addFruit(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $produceRequest = new ProduceRequest($data);
        $errors = $this->getJsonErrors($validator->validate($produceRequest));
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => $errors], 400);
        }
        $this->produceService->add($request);

        return new JsonResponse(['message' => 'Fruit added successfully']);
    }

    #[Route('/vegetable', name: 'add_vegetable', methods: ['POST'])]
    public function addVegetable(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $produceRequest = new ProduceRequest($data);
        $errors = $this->getJsonErrors($validator->validate($produceRequest));
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => $errors], 400);
        }
        $this->produceService->add($request);

        return new JsonResponse(['message' => 'Vegetable added successfully']);
    }

    #[Route('/fruits/{id}', name: 'remove_fruit', methods: ['DELETE'])]
    public function removeFruit(int $id): JsonResponse
    {
        try {
            $this->produceService->remove(self::FRUIT, $id);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }

        return new JsonResponse(['message' => 'Fruit removed successfully']);
    }

    #[Route('/vegetables/{id}', name: 'remove_vegetable', methods: ['DELETE'])]
    public function removeVegetable(int $id): JsonResponse
    {
        try {
            $this->produceService->remove(self::VEGETABLE, $id);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }

        return new JsonResponse(['message' => 'Vegetable removed successfully']);
    }

    private function getJsonErrors($errors): array
    {
        $messages = [];
        foreach ($errors as $error) {
            $messages[$error->getPropertyPath()] = $error->getMessage();
        }
        return $messages;
    }
}