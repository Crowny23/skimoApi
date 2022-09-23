<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\RequestBody;
use ApiPlatform\OpenApi\OpenApi;

class OpenApiFactory implements OpenApiFactoryInterface
{

  public function __construct(private OpenApiFactoryInterface $decorated)
  {
    
  }

  public function __invoke(array $context = []): OpenApi
  {
    $openApi = $this->decorated->__invoke($context);

    $schemas = $openApi->getComponents()->getSecuritySchemes();
    $schemas['bearerAuth'] = new \ArrayObject([
      'type' => 'http',
      'scheme' => 'bearer',
      'bearerFormat' => 'JWT'
    ]);

    $schemas = $openApi->getComponents()->getSchemas();
    $schemas['Credentials'] = new \ArrayObject([
      'type' => 'object',
      'properties' => [
        'username' => [
          'type' => 'string',
          'example' => 'joe@gmail.com'
        ],
        'password' => [
          'type' => 'string',
          'example' => '0000'
        ]
      ]
    ]);
    $schemas['Token'] = new \ArrayObject([
      'type' => 'object',
      'properties' => [
        'Token' => [
          'type' => 'string',
          'readOnly' => true
        ]
      ]
    ]);

    $pathItem = new PathItem(
      post: new Operation(
        operationId: 'postApiLogin',
        tags: ['Users'],
        requestBody: new RequestBody(
          content: new \ArrayObject([
            'application\json' => [
              'schema' => [
                '$ref' => '#/components/schemas/Credentials'
              ]
            ]
          ])
        ),
        responses: [
          '200' => [
            'description' => 'Token JWT connecté',
            'content' => [
              'application\json' => [
                'schema' => [
                  '$ref' => '#/components/schemas/Token'
                ]
              ]
            ]
          ]
        ]
      )
    );

    $openApi->getPaths()->addPath('/api/login', $pathItem);

    return $openApi;
  }

}