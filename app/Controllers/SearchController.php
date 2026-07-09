<?php

class SearchController
{
    public function index(): void
    {
        requireAuth();
        $q = trim($_GET['q'] ?? '');
        $results = $q !== '' ? User::search($q) : [];
        require __DIR__ . '/../../resources/views/home/search.php';
    }
}
