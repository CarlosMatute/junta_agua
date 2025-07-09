<?php

namespace Spatie\Backtrace;

class Frame
{
    /** @var string */
    public $file;

    /** @var string|null */
    public $trimmedFilePath;

    /** @var int */
    public $lineNumber;

    /** @var array|null */
    public $arguments = null;

    /** @var bool */
    public $applicationFrame;

    /** @var string|null */
    public $method;

    /** @var string|null */
    public $class;

<<<<<<< HEAD
    /** @var object|null */
    public $object;

    /** @var string|null */
    protected $textSnippet;

=======
>>>>>>> af3220020a35046e3fbe63c13a1df52bccccf17d
    public function __construct(
        string $file,
        int $lineNumber,
        ?array $arguments,
<<<<<<< HEAD
        ?string $method = null,
        ?string $class = null,
        ?object $object = null,
        bool $isApplicationFrame = false,
        ?string $textSnippet = null,
        ?string $trimmedFilePath = null
=======
        string $method = null,
        string $class = null,
        bool $isApplicationFrame = false
>>>>>>> af3220020a35046e3fbe63c13a1df52bccccf17d
    ) {
        $this->file = $file;

        $this->trimmedFilePath = $trimmedFilePath;

        $this->lineNumber = $lineNumber;

        $this->arguments = $arguments;

        $this->method = $method;

        $this->class = $class;

        $this->object = $object;

        $this->applicationFrame = $isApplicationFrame;
    }

    public function getSnippet(int $lineCount): array
    {
        return (new CodeSnippet())
            ->surroundingLine($this->lineNumber)
            ->snippetLineCount($lineCount)
            ->get($this->file);
    }

    public function getSnippetAsString(int $lineCount): string
    {
        return (new CodeSnippet())
            ->surroundingLine($this->lineNumber)
            ->snippetLineCount($lineCount)
            ->getAsString($this->file);
    }

    public function getSnippetProperties(int $lineCount): array
    {
        $snippet = $this->getSnippet($lineCount);

        return array_map(function (int $lineNumber) use ($snippet) {
            return [
                'line_number' => $lineNumber,
                'text' => $snippet[$lineNumber],
            ];
        }, array_keys($snippet));
    }
<<<<<<< HEAD

    protected function getCodeSnippetProvider(): SnippetProvider
    {
        if ($this->textSnippet) {
            return new LaravelSerializableClosureSnippetProvider($this->textSnippet);
        }

        if (@file_exists($this->file)) {
            return new FileSnippetProvider($this->file);
        }

        return new NullSnippetProvider();
    }
=======
>>>>>>> af3220020a35046e3fbe63c13a1df52bccccf17d
}
