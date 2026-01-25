<?php
require_once __DIR__ . '/../core/BaseController.php';

class AboutController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPageTitle(): string
    {
        return 'About us - Swapify';
    }

    public function getNavItems(): array
    {
        return [
            ['href' => 'index.php', 'label' => 'Home'],
            ['href' => 'about.php', 'label' => 'About Us', 'active' => true],
            ['href' => 'contact.php', 'label' => 'Contact'],
            ['href' => 'login.php', 'label' => 'Login'],
        ];
    }

    public function getSections(): array
    {
        return [
            'header' => [
                'title' => 'About Swapify',
                'subtitle' => 'Connecting people through knowledge sharing',
            ],
            'mission' => [
                'title' => 'Our Mission',
                'text' => 'Swapify is a platform that enables people to exchange skills and knowledge with each other. We believe that everyone has something valuable to teach and something new to learn.',
            ],
            'how_it_works' => [
                'title' => 'How It Works',
                'features' => [
                    [
                        'title' => 'Share Your Skills',
                        'text' => "List the skills you're confident in teaching to others",
                    ],
                    [
                        'title' => 'Discover New Skills',
                        'text' => 'Browse skills offered by other community members',
                    ],
                    [
                        'title' => 'Connect & Learn',
                        'text' => 'Arrange skill exchange sessions and grow together',
                    ],
                ],
            ],
            'story' => [
                'title' => 'Our Story',
                'text' => 'Founded in 2026, Swapify began as a small project aimed at creating meaningful connections between people through knowledge exchange. What started as a simple idea has grown into a community-driven platform.',
            ],
        ];
    }

    public function render(): void
    {
        $pageTitle = $this->getPageTitle();
        $navItems = $this->getNavItems();
        $sections = $this->getSections();

        // Expose variables to the view scope
        require __DIR__ . '/../views/about.php';
    }
}
