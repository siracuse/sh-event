<?php

namespace App\Mapper;

use App\DTO\GithubRepoDto;

class GithubMapper
{
    public function map(array $data): GithubRepoDto
    {
        return new GithubRepoDto(
            name: $data['name'],
            url: $data['html_url'],
            stars: $data['stargazers_count'],
            description: $data['description'] ?? null,
            owner: $data['owner']['login'],
        );
    }
}