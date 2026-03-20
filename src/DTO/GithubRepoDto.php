<?php

namespace App\DTO;

class GithubRepoDto
{
    public function __construct(
        public string $name,
        public string $url,
        public int $stars,
        public ?string $description,
        public string $owner,
    ) {}
}