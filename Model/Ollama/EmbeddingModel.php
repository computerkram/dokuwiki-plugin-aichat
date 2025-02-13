<?php

namespace dokuwiki\plugin\aichat\Model\Ollama;

use dokuwiki\plugin\aichat\Model\EmbeddingInterface;

class EmbeddingModel extends AbstractOllama implements EmbeddingInterface
{
    /** @inheritdoc */
    public function getEmbedding($text): array
    {
        $data = [
            'model' => $this->getModelNameWithSuffix(),
            'input' => $text,
            'options' => [
                'num_ctx' => $this->getMaxInputTokenLength()
            ]
        ];
        $response = $this->request('api/embed', $data);
        return $response['embeddings'][0] ?? [];
    }

    private function getModelNameWithSuffix(): string
    {
        $modelName = $this->getModelName();
        return str_ends_with($modelName, ':latest') ? $modelName : $modelName . ':latest';
    }
}

